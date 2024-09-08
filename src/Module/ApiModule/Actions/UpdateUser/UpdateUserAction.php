<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\ApiModule\Actions\UpdateUser;

use Osumi\OsumiFramework\Routing\OModuleAction;
use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\App\DTO\UserUpdateDTO;
use Osumi\OsumiFramework\App\Model\User;

#[OModuleAction(
	url: '/update-user',
	filters: ['Login']
)]
class UpdateUserAction extends OAction {
	public string $status = 'ok';

	/**
	 * Función para actualizar los datos de perfil de un usuario
	 *
	 * @param UserUpdateDTO $data Objeto con los datos del usuario
	 * @return void
	 */
	public function run(UserUpdateDTO $data):void {
		if (!$data->isValid()) {
			$this->status = 'error';
		}

		if ($this->status == 'ok') {
			$user = new User();
			$user->find(['id' => $data->getId()]);

			$user->set('name',  $data->getName());
			$user->set('email', $data->getEmail());
			$user->set('color', $data->getColor());

			$user->save();
		}
	}
}
