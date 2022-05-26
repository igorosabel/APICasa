<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Plugins\OToken;
use OsumiFramework\App\DTO\UserRegisterDTO;
use OsumiFramework\App\Model\User;

#[OModuleAction(
	url: '/register'
)]
class registerAction extends OAction {
	/**
	 * Función para registrar un nuevo usuario
	 *
	 * @param UserRegisterDTO $data Objeto con la información introducida para registrar un nuevo usuario
	 * @return void
	 */
	public function run(UserRegisterDTO $data):void {
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
}
