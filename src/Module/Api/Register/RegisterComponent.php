<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\Register;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\User;
use Osumi\OsumiFramework\App\DTO\UserRegisterDTO;


class RegisterComponent extends OComponent {
	public string $status = 'ok';
	public int    $id     = -1;
	public string $name   = '';
	public string $token  = '';
	public string $color  = '';

	/**
	 * Función para registrar un nuevo usuario
	 *
	 * @param UserRegisterDTO $data Objeto con la información introducida para registrar un nuevo usuario
	 * @return void
	 */
	public function run(UserRegisterDTO $data):void {
		if (!$data->isValid()) {
			$this->status = 'error';
		}
		else {
			$email = $data->getEmail();
			$pass  = $data->getPass();
			$name  = $data->getName();
		}

		if ($this->status=='ok') {
			$user = new User();

			if ($user->find(['email' => $email])) {
				$this->status = 'in-use';
			}
			else {
				$user->set('email', $email);
				$user->set('pass',  password_hash($pass, PASSWORD_BCRYPT));
				$user->set('name', $name);
				$user->set('color', sprintf('%06X', mt_rand(0, 0xFFFFFF)));
				$user->save();

				$this->id = $user->get('id');
				$this->name = $user->get('name');
				$this->color = $user->get('color');

				$tk = new OToken($this->getConfig()->getExtra('secret'));
				$tk->addParam('id',    $id);
				$tk->addParam('exp',   time() + (24 * 60 * 60));
				$this->token = $tk->getToken();
			}
		}
	}
}
