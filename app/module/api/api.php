<?php declare(strict_types=1);

namespace OsumiFramework\App\Module;

use OsumiFramework\OFW\Core\OModule;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\OFW\Routing\ORoute;
use OsumiFramework\App\Model\User;
use OsumiFramework\App\Service\webService;
use OsumiFramework\App\Service\emailService;
use OsumiFramework\App\DTO\UserLoginDTO;
use OsumiFramework\App\DTO\UserRegisterDTO;
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
	 * Función para registrar un nuevo usuario
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
}
