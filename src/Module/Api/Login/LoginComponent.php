<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\Login;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\User;
use Osumi\OsumiFramework\App\DTO\UserLoginDTO;
use Osumi\OsumiFramework\App\Component\Model\Family\FamilyComponent;

class LoginComponent extends OComponent {
	public string $status = 'ok';
	public int $id        = -1;
	public string $name   = '';
	public string $token  = '';
	public string $color  = '';
	public ?FamilyComponent $family = null;

	/**
	 * Función para iniciar sesión en la aplicación
	 *
	 * @param UserLoginDTO $data Objeto con la información introducida para iniciar sesión
	 * @return void
	 */
	public function run(UserLoginDTO $data):void {
		$this->family = new FamilyComponent();

		if (!$data->isValid()) {
			$this->status = 'error';
		}
		else {
			$email = $data->getEmail();
			$pass  = $data->getPass();
		}

		if ($this->status=='ok') {
			$user = new User();
			if ($user->login($email, $pass)) {
				$this->id = $user->get('id');
				$this->name = $user->get('name');
				$this->color = $user->get('color');
				$this->family->family = $user->getFamily();

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',    $this->id);
				$tk->addParam('exp',   time() + (24 * 60 * 60));
				$this->token = $tk->getToken();
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
