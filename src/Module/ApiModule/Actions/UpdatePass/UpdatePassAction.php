<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\ApiModule\Actions\UpdatePass;

use Osumi\OsumiFramework\Routing\OModuleAction;
use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\App\DTO\PassUpdateDTO;
use Osumi\OsumiFramework\App\Model\User;

#[OModuleAction(
	url: '/update-pass',
	filters: ['Login']
)]
class UpdatePassAction extends OAction {
	/**
	 * Función para actualizar la contraseña de un usuario
	 *
	 * @param PassUpdateDTO $data Objeto con la contraseña actual y nueva del usuario
	 * @return void
	 */
	public function run(PassUpdateDTO $data):void {
		$status = 'ok';

		if (!$data->isValid()) {
			$status = 'error';
		}

		if ($status == 'ok') {
			$user = new User();
			$user->find(['id' => $data->getIdToken()]);

			if ($user->checkPass($data->getCurrent())) {
				$user->set('pass', password_hash($data->getNewPass(), PASSWORD_BCRYPT));
				$user->save();
			}
			else {
				$status = 'error-pass';
			}
		}

		$this->getTemplate()->add('status', $status);
	}
}
