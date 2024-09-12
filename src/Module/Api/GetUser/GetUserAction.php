<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetUser;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\User;

class GetUserAction extends OAction {
	public string $status = 'ok';
	public int    $id    = -1;
	public string $name  = '';
	public string $email = '';
	public string $color = '';

	/**
	 * Función para obtener los datos de perfil de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$filter = $req->getFilter('Login');

		if (is_null($filter) || $filter['status']=='error') {
			$this->status = 'error';
		}

		if ($this->status == 'ok') {
			$user = new User();
			$user->find(['id' => $filter['id']]);

			$this->id    = $user->get('id');
			$this->name  = $user->get('name');
			$this->email = $user->get('email');
			$this->color = $user->get('color');
		}
	}
}
