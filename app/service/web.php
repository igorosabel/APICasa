<?php declare(strict_types=1);

namespace OsumiFramework\App\Service;

use OsumiFramework\OFW\Core\OService;
use OsumiFramework\OFW\DB\ODB;
use OsumiFramework\OFW\Plugins\OToken;
use OsumiFramework\App\Model\User;

class webService extends OService {
	/**
	 * Load service tools
	 */
	function __construct() {
		$this->loadService();
	}

	/**
	 * Comprueba el token de un email de recuperación de contraseña
	 *
	 * @param string $token Token del email
	 *
	 * @return array Estado de la comprobación y datos del usuario
	 */
	public function checkNewPasswordToken(string $token): array {
		$status = 'ok';
		$tk = new OToken($this->getConfig()->getExtra('secret'));
		$user = new User();

		if ($tk->checkToken($token)) {
			$date = intval($tk->getParam('date'));
			$one_day = 60 * 60 * 24;

			if ( ($date+$one_day) > time() ) {
				if ($user->find(['id'=>$tk->getParam('id')])) {
					if ($user->get('email')!=$tk->getParam('email')) {
						$status = 'error'; // El email no coincide
					}
				}
				else {
					$status = 'error'; // Usuario no encontrado
				}
			}
			else {
				$status = 'error'; // Token caducado
			}
		}
		else {
			$status = 'error'; // Token no valido
		}

		return ['status' => $status, 'user' => $user];
	}
}
