<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\Recover;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\EmailService;
use Osumi\OsumiFramework\App\Model\User;

class RecoverComponent extends OComponent {
	private ?EmailService $es = null;

	public string $status = 'ok';

	public function __construct() {
    parent::__construct();
		$this->es = inject(EmailService::class);
	}

	/**
	 * Función para obtener un enlace de recuperación de contraseña
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$email = $req->getParamString('email');

		if (is_null($email)) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$user = User::findOne(['email' => $email]);

			if (!is_null($user)) {
				$this->es->sendLostPassword($user);
			}
		}
	}
}
