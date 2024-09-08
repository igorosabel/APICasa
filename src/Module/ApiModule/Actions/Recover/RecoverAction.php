<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\ApiModule\Actions\Recover;

use Osumi\OsumiFramework\Routing\OModuleAction;
use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\User;

#[OModuleAction(
	url: '/recover',
	services: ['Email']
)]
class RecoverAction extends OAction {
	public string $status = 'ok';

	/**
	 * Función para obtener un enlace de recuperación de contraseña
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$email = $req->getParamString('email');

		if (is_null($email)) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
			$user = new User();

			if ($user->find(['email' => $email])) {
				$this->service['Email']->sendLostPassword($user);
			}
		}
	}
}
