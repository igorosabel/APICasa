<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Service;

use Osumi\OsumiFramework\Core\OService;
use Osumi\OsumiFramework\ORM\ODB;
use Osumi\OsumiFramework\Tools\OTools;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\Message;
use Osumi\OsumiFramework\App\Model\MessageTag;
use Osumi\OsumiFramework\App\Model\Tag;
use Osumi\OsumiFramework\App\Model\User;

class WebService extends OService {
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
		$user = User::create();

		if ($tk->checkToken($token)) {
			$date = intval($tk->getParam('date'));
			$one_day = 60 * 60 * 24;

			if ( ($date + $one_day) > time() ) {
				$user = User::findOne(['id'=>$tk->getParam('id')]);
				if (!is_null($user)) {
					if ($user->email !== $tk->getParam('email')) {
						$status = 'error'; // El email no coincide
					}
				}
				else {
					$user = User::create();
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

	/**
	 * Función para obtener la lista de tags de un usuario
	 *
	 * @param int $id_user Id del usuario
	 *
	 * @return array Lista de tags de un usuario
	 */
	public function getUserTags(int $id_user): array {
		return Tag::where(['id_user' => $id_user]);
	}

	/**
	 * Función para actualizar las tags de un mensaje
	 *
	 * @param Message $message Objeto con el mensaje a actualizar
	 *
	 * @param string $tag_list Tags a aplicar al mensaje
	 *
	 * @return void
	 */
	public function updateTags(Message $message, string $tag_list): void {
		$db = new ODB();
		// Limpio tags actuales del mensaje
		$sql = "DELETE FROM `message_tag` WHERE `id_message` = ?";
		$db->query($sql, [$message->id]);

		// Recorro las tags que han llegado
		$tags = explode(',', $tag_list);
		foreach ($tags as $tag) {
			$tag = trim($tag);

			$t = Tag::findOne(['slug' => OTools::slugify($tag)]);
			if (is_null($t)) {
				$t = Tag::create();
				$t->id_user = $message->id_user;
				$t->name = $tag;
				$t->slug = OTools::slugify($tag);
				$t->save();
			}
			$mt = MessageTag::create();
			$mt->id_message = $message->id;
			$mt->id_tag = $t->id;
			$mt->save();
		}

		// Borro tags no usadas
		$sql = "DELETE FROM `tag` WHERE `id_user` = ? AND `id` NOT IN (SELECT DISTINCT(`id_tag`) FROM `message_tag` WHERE `id_message` IN (SELECT `id` FROM `message` WHERE `id_user` = ?))";
		$db->query($sql, [$message->id_user, $message->id_user]);
	}

	/**
	 * Función para obtener la lista de mensajes de un usuario
	 *
	 * @param int $id_user Id del usuario que obtiene los mensajes
	 *
	 * @return array Lista de mensajes
	 */
	public function getMessages(int $id_user): array {
		$messages = Message::where(['id_user' => $id_user], ['updated_at#desc']);
		$list = [];
		$user_list = [];

		foreach ($messages as $message) {
			if (!array_key_exists('user_' . $message->id_user, $user_list)) {
				$user = User::findOne(['id' => $message->id_user]);
				$user_list['user_' . $message->id_user] = $user;
			}
			$message->setColor($user_list['user_' . $message->id_user]->color);

			$list[] = $message;
		}

		return $list;
	}
}
