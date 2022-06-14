<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;

#[OModuleAction(
	url: '/check-password-token',
	services: ['web']
)]
class checkPasswordTokenAction extends OAction {
	/**
	 * Función para comprobar un token de un email de recuperación
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
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
}
