<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\ApiModule\Actions\NewPassword;

use Osumi\OsumiFramework\Routing\OModuleAction;
use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\App\DTO\NewPassDTO;

#[OModuleAction(
	url: '/new-password',
	services: ['Web', 'Email']
)]
class NewPasswordAction extends OAction {
	/**
	 * Función para cambiar la contraseña de un usuario
	 *
	 * @param NewPassDTO $data Nueva contraseña y token de un usuario
	 * @return void
	 */
	public function run(NewPassDTO $data):void {
		$status = 'ok';

		if (!$data->isValid()) {
			$status = 'error';
		}

		if ($status=='ok') {
				$check = $this->service['Web']->checkNewPasswordToken($data->getToken());
				$status = $check['status'];
				if ($status == 'ok') {
					$user = $check['user'];
					$user->set('pass', password_hash($data->getPass(), PASSWORD_BCRYPT));
					$user->save();

					$this->service['Email']->sendPasswordChanged($user);
				}
		}

		$this->getTemplate()->add('status', $status);
	}
}
