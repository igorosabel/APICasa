<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\CheckPasswordToken;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;

class CheckPasswordTokenAction extends OAction {
	public string $status = 'ok';

	/**
	 * Función para comprobar un token de un email de recuperación
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$token  = $req->getParamString('token');

		if (is_null($token)) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
				$check = $this->service['Web']->checkNewPasswordToken($token);
				$this->status = $check['status'];
		}
	}
}
