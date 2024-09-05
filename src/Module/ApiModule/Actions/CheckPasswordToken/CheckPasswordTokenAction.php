<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\ApiModule\Actions\CheckPasswordToken;

use Osumi\OsumiFramework\Routing\OModuleAction;
use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;

#[OModuleAction(
	url: '/check-password-token',
	services: ['Web']
)]
class CheckPasswordTokenAction extends OAction {
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
				$check = $this->service['Web']->checkNewPasswordToken($token);
				$status = $check['status'];
		}

		$this->getTemplate()->add('status', $status);
	}
}
