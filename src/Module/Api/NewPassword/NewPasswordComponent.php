<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\NewPassword;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\App\DTO\NewPassDTO;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Service\EmailService;

class NewPasswordComponent extends OComponent {
	private ?WebService $ws = null;
	private ?EmailService $es = null;

	public string $status = 'ok';

	public function __construct() {
    parent::__construct();
		$this->ws = inject(WebService::class);
		$this->es = inject(EmailService::class);
	}

	/**
	 * Función para cambiar la contraseña de un usuario
	 *
	 * @param NewPassDTO $data Nueva contraseña y token de un usuario
	 * @return void
	 */
	public function run(NewPassDTO $data): void {
		if (!$data->isValid()) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$check = $this->ws->checkNewPasswordToken($data->token);
			$this->status = $check['status'];
			if ($this->status === 'ok') {
				$user = $check['user'];
				$user->set('pass', password_hash($data->pass, PASSWORD_BCRYPT));
				$user->save();

				$this->es->sendPasswordChanged($user);
			}
		}
	}
}
