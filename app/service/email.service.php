<?php declare(strict_types=1);

namespace OsumiFramework\App\Service;

use OsumiFramework\OFW\Core\OService;
use OsumiFramework\OFW\DB\ODB;
use OsumiFramework\OFW\Plugins\OEmailSMTP;
use OsumiFramework\OFW\Plugins\OToken;
use OsumiFramework\OFW\Tools\OTools;
use OsumiFramework\App\Model\User;

class emailService extends OService {
	/**
	 * Load service tools
	 */
	function __construct() {
		$this->loadService();
	}

	/**
	 * Enviar email de recuperación de contraseña
	 *
	 * @param User $user Objeto usuario con los datos del usuario que quiere recuperar su contraseña
	 *
	 * @return void
	 */
	public function sendLostPassword(User $user): void {
		$tk = new OToken($this->getConfig()->getExtra('secret'));
		$tk->addParam('id', $user->get('id'));
		$tk->addParam('email', $user->get('email'));
		$tk->addParam('date', time());
		$token = $tk->getToken();

		$message = OTools::getTemplate($this->getConfig()->getDir('app_component').'email/lost_password/lost_password.php', '', [
			'name'  => $user->get('name'),
			'token' => urlencode($token)
		]);

		$email = new OEmailSMTP();
		$email->addRecipient($user->get('email'));
		$email->setFrom($this->getConfig()->getAdminEmail(), 'Casa');
		$email->setSubject('Recuperar contraseña');
		$email->setMessage($message);

		$email->send();
	}

	/**
	 * Enviar email de contraseña cambiada
	 *
	 * @param User $user Objeto usuario con los datos del usuario que ha cambiado su contraseña
	 *
	 * @return void
	 */
	public function sendPasswordChanged(User $user): void {
		$message = OTools::getTemplate($this->getConfig()->getDir('app_component').'email/password_changed/password_changed.php', '', [
			'name'  => $user->get('name')
		]);

		$email = new OEmailSMTP();
		$email->addRecipient($user->get('email'));
		$email->setFrom($this->getConfig()->getAdminEmail(), 'Casa');
		$email->setSubject('Contraseña cambiada');
		$email->setMessage($message);

		$email->send();
	}
}
