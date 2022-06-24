<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\User;

#[OModuleAction(
	url: '/get-user',
	filters: ['login']
)]
class getUserAction extends OAction {
	/**
	 * Función para obtener los datos de perfil de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$filter = $req->getFilter('login');

		$id    = -1;
		$name  = '';
		$email = '';
		$color = '';

		if (is_null($filter) || $filter['status']=='error') {
			$status = 'error';
		}

		if ($status == 'ok') {
			$user = new User();
			$user->find(['id' => $filter['id']]);

			$id    = $user->get('id');
			$name  = $user->get('name');
			$email = $user->get('email');
			$color = $user->get('color');
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
		$this->getTemplate()->add('name',   $name);
		$this->getTemplate()->add('email',  $email);
		$this->getTemplate()->add('color',  $color);
	}
}
