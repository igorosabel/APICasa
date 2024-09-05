<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\ApiModule\Actions\Login;

use Osumi\OsumiFramework\Routing\OModuleAction;
use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\User;
use Osumi\OsumiFramework\App\DTO\UserLoginDTO;
use Osumi\OsumiFramework\App\Component\Model\FamilyComponent\FamilyComponent;

#[OModuleAction(
	url: '/login'
)]
class LoginAction extends OAction {
	/**
	 * Función para iniciar sesión en la aplicación
	 *
	 * @param UserLoginDTO $data Objeto con la información introducida para iniciar sesión
	 * @return void
	 */
	public function run(UserLoginDTO $data):void {
		$status = 'ok';
		$id     = -1;
		$name   = '';
		$token  = '';
		$color  = '';
		$family_component = new FamilyComponent(['Family' => null]);

		if (!$data->isValid()) {
			$status = 'error';
		}
		else {
			$email = $data->getEmail();
			$pass  = $data->getPass();
		}

		if ($status=='ok') {
			$user = new User();
			if ($user->login($email, $pass)) {
				$id = $user->get('id');
				$name = $user->get('name');
				$color = $user->get('color');
				$family_component->setValue('Family', $user->getFamily());

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',    $id);
				$tk->addParam('exp',   time() + (24 * 60 * 60));
				$token = $tk->getToken();
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('id',     $id);
		$this->getTemplate()->add('name',   $name);
		$this->getTemplate()->add('token',  $token);
		$this->getTemplate()->add('color',  $color);
		$this->getTemplate()->add('family', $family_component);
	}
}
