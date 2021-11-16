<?php declare(strict_types=1);

namespace OsumiFramework\App\Module;

use OsumiFramework\OFW\Core\OModule;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\OFW\Routing\ORoute;
use OsumiFramework\App\Model\User;
use OsumiFramework\App\Model\Message;
use OsumiFramework\App\Service\webService;
use OsumiFramework\App\Service\emailService;
use OsumiFramework\App\DTO\UserLoginDTO;
use OsumiFramework\App\DTO\UserRegisterDTO;
use OsumiFramework\App\DTO\NewPassDTO;
use OsumiFramework\App\DTO\MessageDTO;
use OsumiFramework\OFW\Plugins\OToken;

#[ORoute(
	type: 'json',
	prefix: '/api'
)]
class api extends OModule {
	public ?webService $web_service = null;
	public ?emailService $email_service = null;

	function __construct() {
		$this->web_service = new webService();
		$this->email_service = new emailService();
	}

	/**
	 * Función para iniciar sesión en la aplicación
	 *
	 * @param UserLoginDTO $data Objeto con la información introducida para iniciar sesión
	 *
	 * @return void
	 */
	#[ORoute('/login')]
	public function login(UserLoginDTO $data): void {
		$status = 'ok';
		$id     = -1;
		$name   = '';
		$token  = '';
		$color  = '';

		if (!$data->isValid()) {
			$status = 'error';
		}
		else {
			$email  = $data->getEmail();
			$pass   = $data->getPass();
		}

		if ($status=='ok') {
			$user = new User();
			if ($user->login($email, $pass)) {
				$id = $user->get('id');
				$name = $user->get('name');
				$color = $user->get('color');

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',    $id);
				$tk->addParam('exp',   time() + (24 * 60 * 60));
				$token = $tk->getToken();
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
		$this->getTemplate()->add('name',   $name);
		$this->getTemplate()->add('token',  $token);
		$this->getTemplate()->add('color',  $color);
	}

	/**
	 * Función para registrar un nuevo usuario
	 *
	 * @param UserRegisterDTO $data Objeto con la información introducida para registrar un nuevo usuario
	 * @return void
	 */
	#[ORoute('/register')]
	public function register(UserRegisterDTO $data): void {
		$status = 'ok';
		$id     = -1;
		$name   = '';
		$token  = '';
		$color  = '';

		if (!$data->isValid()) {
			$status = 'error';
		}
		else {
			$email = $data->getEmail();
			$pass  = $data->getPass();
			$name  = $data->getName();
		}

		if ($status=='ok') {
			$user = new User();

			if ($user->find(['email' => $email])) {
				$status = 'in-use';
			}
			else {
				$user->set('email', $email);
				$user->set('pass',  password_hash($pass, PASSWORD_BCRYPT));
				$user->set('name', $name);
				$user->set('color', sprintf('%06X', mt_rand(0, 0xFFFFFF)));
				$user->save();

				$id = $user->get('id');
				$color = $user->get('color');

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',    $id);
				$tk->addParam('exp',   time() + (24 * 60 * 60));
				$token = $tk->getToken();
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
		$this->getTemplate()->add('name',   $name);
		$this->getTemplate()->add('token',  $token);
		$this->getTemplate()->add('color',  $color);
	}

	/**
	 * Función para obtener un enlace de recuperación de contraseña
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute('/recover')]
	public function recover(ORequest $req): void {
		$status = 'ok';
		$email  = $req->getParamString('email');

		if (is_null($email)) {
			$status = 'error';
		}

		if ($status=='ok') {
			$user = new User();

			if ($user->find(['email' => $email])) {
				$this->email_service->sendLostPassword($user);
			}
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para comprobar un token de un email de recuperación
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute('/check-password-token')]
	public function checkPasswordToken(ORequest $req): void {
		$status = 'ok';
		$token  = $req->getParamString('token');

		if (is_null($token)) {
			$status = 'error';
		}

		if ($status=='ok') {
				$check = $this->web_service->checkNewPasswordToken($token);
				$status = $check['status'];
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para cambiar la contraseña de un usuario
	 *
	 * @param NewPassDTO $data Nueva contraseña y token de un usuario
	 * @return void
	 */
	#[ORoute('/new-password')]
	public function newPassword(NewPassDTO $data): void {
		$status = 'ok';

		if (!$data->isValid()) {
			$status = 'error';
		}

		if ($status=='ok') {
				$check = $this->web_service->checkNewPasswordToken($data->getToken());
				$status = $check['status'];
				if ($status == 'ok') {
					$user = $check['user'];
					$user->set('pass', password_hash($data->getPass(), PASSWORD_BCRYPT));
					$user->save();

					$this->email_service->sendPasswordChanged($user);
				}
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para obtener la lista de tags de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/get-tags',
		filter: 'loginFilter'
	)]
	public function getTags(ORequest $req): void {
		$status = 'ok';
		$filter = $req->getFilter('loginFilter');

		if (is_null($filter) || $filter['status']=='error') {
			$status = 'error';
		}

		if ($status=='ok') {
				$list = $this->web_service->getUserTags($filter['id']);
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'model/tag_list', ['list' => $list, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para guardar un mensaje
	 *
	 * @param MessageDTO $data Datos del mensaje a guardar
	 * @return void
	 */
	#[ORoute(
		'/save-message',
		filter: 'loginFilter'
	)]
	public function saveMessage(MessageDTO $data): void {
		$status = 'ok';

		if (!$data->isValid()) {
			$status = 'error';
		}

		if ($status=='ok') {
			$message = new Message();
			if ($data->getId() != -1) {
				$message->find(['id' => $data->getId()]);
			}
			else {
				$message->set('id_user', $data->getIdUser());
			}
			if ($message->get('id_user') == $data->getIdUser()) {
				$message->set('type', $data->getType());
				$message->set('body', $data->getBody());
				$message->set('done', $data->getDone());
				$message->set('is_private', $data->getIsPrivate());
				$message->set('color', $data->getColor());
				$message->save();

				$this->web_service->updateTags($message, $data->getTagList());
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}

	/**
	 * Función para obtener la lista de mensajes
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/get-messages',
		filter: 'loginFilter'
	)]
	public function getMessages(ORequest $req): void {
		$status = 'ok';
		$filter = $req->getFilter('loginFilter');
		$list   = [];

		if (is_null($filter) || $filter['status']=='error') {
			$status = 'error';
		}

		if ($status == 'ok') {
			$list = $this->web_service->getMessages($filter['id']);
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('list', 'model/message_list', ['list' => $list, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para obtener un mensaje concreto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/get-message',
		filter: 'loginFilter'
	)]
	public function getMessage(ORequest $req): void {
		$status  = 'ok';
		$id      = $req->getParamInt('id');
		$filter  = $req->getFilter('loginFilter');
		$message = null;

		if (is_null($id) || is_null($filter) || $filter['status']=='error') {
			$status = 'error';
		}

		if ($status == 'ok') {
			$message = new Message();
			if ($message->find(['id' => $id])) {
				if ($message->get('id_user') == $filter['id']) {
					$user = new User();
					$user->find(['id' => $message->get('id_user')]);
					$message->setColor($user->get('color'));
				}
				else {
					$message = null;
					$status = 'error';
				}
			}
			else {
				$message = null;
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->addComponent('message', 'model/message', ['message' => $message, 'extra' => 'nourlencode']);
	}

	/**
	 * Función para actualizar el estado de una tarea
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	#[ORoute(
		'/update-task',
		filter: 'loginFilter'
	)]
	public function updateTask(ORequest $req): void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('loginFilter');

		if (is_null($id) || is_null($filter) || $filter['status']=='error') {
			$status = 'error';
		}

		if ($status == 'ok') {
			$message = new Message();
			if ($message->find(['id' => $id])) {
				if ($message->get('id_user') == $filter['id']) {
					$message->set('done', !$message->get('done'));
					$message->save();
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}
}
