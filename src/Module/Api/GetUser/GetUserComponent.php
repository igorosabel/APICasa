<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetUser;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\User;
use Osumi\OsumiFramework\App\Component\Model\Family\FamilyComponent;

class GetUserComponent extends OComponent {
	public string $status = 'ok';
	public int    $id    = -1;
	public string $name  = '';
	public string $email = '';
	public string $color = '';
	public ?FamilyComponent $family = null;

	/**
	 * Función para obtener los datos de perfil de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$filter = $req->getFilter('Login');
		$this->family = new FamilyComponent();

		if (is_null($filter) || $filter['status'] === 'error') {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$user = User::findOne(['id' => $filter['id']);

			$this->id    = $user->id;
			$this->name  = $user->name;
			$this->email = $user->email;
			$this->color = $user->color;
			$this->family->family = $user->getFamily();
		}
	}
}
