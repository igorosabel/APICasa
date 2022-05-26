<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\App\DTO\NewPassDTO;

#[OModuleAction(
	url: '/new-password',
	services: 'web, email'
)]
class newPasswordAction extends OAction {
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
}
