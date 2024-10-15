<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\UpdatePass;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\App\DTO\PassUpdateDTO;
use Osumi\OsumiFramework\App\Model\User;

class UpdatePassComponent extends OComponent {
	public string $status = 'ok';

	/**
	 * Función para actualizar la contraseña de un usuario
	 *
	 * @param PassUpdateDTO $data Objeto con la contraseña actual y nueva del usuario
	 * @return void
	 */
	public function run(PassUpdateDTO $data):void {
		if (!$data->isValid()) {
			$this->status = 'error';
		}

		if ($this->status == 'ok') {
			$user = new User();
			$user->find(['id' => $data->getIdToken()]);

			if ($user->checkPass($data->getCurrent())) {
				$user->set('pass', password_hash($data->getNewPass(), PASSWORD_BCRYPT));
				$user->save();
			}
			else {
				$this->status = 'error-pass';
			}
		}
	}
}