<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Service;

use Osumi\OsumiFramework\Core\OService;
use Osumi\OsumiFramework\DB\ODB;
use Osumi\OsumiFramework\Tools\OTools;
use Osumi\OsumiFramework\Plugins\OToken;
use Osumi\OsumiFramework\App\Model\Message;
use Osumi\OsumiFramework\App\Model\MessageTag;
use Osumi\OsumiFramework\App\Model\Tag;
use Osumi\OsumiFramework\App\Model\User;

class WebService extends OService {
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

	/**
	 * Función para obtener la lista de tags de un usuario
	 *
	 * @param int $id_user Id del usuario
	 *
	 * @return array Lista de tags de un usuario
	 */
	public function getUserTags(int $id_user): array {
		$tags = [];
		$db = new ODB();
		$sql = "SELECT * FROM `tag` WHERE `id_user` = ?";
		$db->query($sql, [$id_user]);

		while ($res = $db->next()) {
			$tag = new Tag();
			$tag->update($res);
			array_push($tags, $tag);
		}

		return $tags;
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
		$db->query($sql, [$message->get('id')]);

		// Recorro las tags que han llegado
		$tags = explode(',', $tag_list);
		foreach ($tags as $tag) {
			$tag = trim($tag);
			$sql = "SELECT * FROM `tag` WHERE `slug` = ?";
			$db->query($sql, [OTools::slugify($tag)]);

			$t = new Tag();
			if ($res = $db->next()) {
				$t->update($res);
			}
			else {
				$t->set('id_user', $message->get('id_user'));
				$t->set('name', $tag);
				$t->set('slug', OTools::slugify($tag));
				$t->save();
			}
			$mt = new MessageTag();
			$mt->set('id_message', $message->get('id'));
			$mt->set('id_tag', $t->get('id'));
			$mt->save();
		}

		// Borro tags no usadas
		$sql = "DELETE FROM `tag` WHERE `id_user` = ? AND `id` NOT IN (SELECT DISTINCT(`id_tag`) FROM `message_tag` WHERE `id_message` IN (SELECT `id` FROM `message` WHERE `id_user` = ?))";
		$db->query($sql, [$message->get('id_user'), $message->get('id_user')]);
	}

	/**
	 * Función para obtener la lista de mensajes de un usuario
	 *
	 * @param int $id_user Id del usuario que obtiene los mensajes
	 *
	 * @return array Lista de mensajes
	 */
	public function getMessages(int $id_user): array {
		$db = new ODB();
		$sql = "SELECT * FROM `message` WHERE `id_user` = ? ORDER BY `updated_at` DESC";
		$db->query($sql, [$id_user]);
		$list = [];
		$user_list = [];

		while ($res = $db->next()) {
			$message = new Message();
			$message->update($res);

			if (!array_key_exists('user_'.$message->get('id_user'), $user_list)) {
				$user = new User();
				$user->find(['id' => $message->get('id_user')]);
				$user_list['user_'.$message->get('id_user')] = $user;
			}
			$message->setColor($user_list['user_'.$message->get('id_user')]->get('color'));

			array_push($list, $message);
		}

		return $list;
	}
}
