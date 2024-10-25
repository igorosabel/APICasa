<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Service;

use Osumi\OsumiFramework\Core\OService;
use Osumi\OsumiFramework\Plugins\OEmailSMTP;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\User;
use Osumi\OsumiFramework\Component\Email\LostPassword\LostPasswordComponent;
use Osumi\OsumiFramework\Component\Email\PasswordChanged\PasswordChangedComponent;

class EmailService extends OService {
	/**
	 * Enviar email de recuperación de contraseña
	 *
	 * @param User $user Objeto usuario con los datos del usuario que quiere recuperar su contraseña
	 *
	 * @return void
	 */
	public function sendLostPassword(User $user): void {
		$tk = new OToken($this->getConfig()->getExtra('secret'));
		$tk->addParam('id', $user->id);
		$tk->addParam('email', $user->email);
		$tk->addParam('date', time());
		$token = $tk->getToken();

		$message = new LostPasswordComponent([
			'name'  => $user->name,
			'token' => urlencode($token)
		]);

		$email = new OEmailSMTP();
		$email->addRecipient($user->email);
		$email->setFrom($this->getConfig()->getAdminEmail(), 'Casa');
		$email->setSubject('Recuperar contraseña');
		$email->setMessage(strval($message));

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
		$message = new PasswordChangedComponent(['name' => $user->name]);

		$email = new OEmailSMTP();
		$email->addRecipient($user->email);
		$email->setFrom($this->getConfig()->getAdminEmail(), 'Casa');
		$email->setSubject('Contraseña cambiada');
		$email->setMessage(strval($message));

		$email->send();
	}
}
