<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\NewPassword;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\App\DTO\NewPassDTO;

class NewPasswordAction extends OAction {
	public string $status = 'ok';

	/**
	 * Función para cambiar la contraseña de un usuario
	 *
	 * @param NewPassDTO $data Nueva contraseña y token de un usuario
	 * @return void
	 */
	public function run(NewPassDTO $data):void {
		if (!$data->isValid()) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
				$check = $this->service['Web']->checkNewPasswordToken($data->getToken());
				$this->status = $check['status'];
				if ($this->status == 'ok') {
					$user = $check['user'];
					$user->set('pass', password_hash($data->getPass(), PASSWORD_BCRYPT));
					$user->save();

					$this->service['Email']->sendPasswordChanged($user);
				}
		}
	}
}
