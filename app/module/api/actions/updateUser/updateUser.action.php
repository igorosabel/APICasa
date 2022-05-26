<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\App\DTO\UserUpdateDTO;
use OsumiFramework\App\Model\User;

#[OModuleAction(
	url: '/update-user',
	filter: 'login'
)]
class updateUserAction extends OAction {
	/**
	 * Función para actualizar los datos de perfil de un usuario
	 *
	 * @param UserUpdateDTO $data Objeto con los datos del usuario
	 * @return void
	 */
	public function run(UserUpdateDTO $data):void {
		$status = 'ok';

		if (!$data->isValid()) {
			$status = 'error';
		}

		if ($status == 'ok') {
			$user = new User();
			$user->find(['id' => $data->getId()]);

			$user->set('name',  $data->getName());
			$user->set('email', $data->getEmail());
			$user->set('color', $data->getColor());

			$user->save();
		}

		$this->getTemplate()->add('status', $status);
	}
}
