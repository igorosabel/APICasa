<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\User;

#[OModuleAction(
	url: '/recover',
	services: ['email']
)]
class recoverAction extends OAction {
	/**
	 * Función para obtener un enlace de recuperación de contraseña
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
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
