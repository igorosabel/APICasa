<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Plugins\OToken;
use OsumiFramework\App\DTO\UserLoginDTO;
use OsumiFramework\App\Model\User;

#[OModuleAction(
	url: '/login'
)]
class loginAction extends OAction {
	/**
	 * Función para iniciar sesión en la aplicación
	 *
	 * @param UserLoginDTO $data Objeto con la información introducida para iniciar sesión
	 * @return void
	 */
	public function run(UserLoginDTO $data):void {
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
}
