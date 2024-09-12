<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\SaveMessage;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\App\DTO\MessageDTO;
use Osumi\OsumiFramework\App\Model\Message;

class SaveMessageAction extends OAction {
	public string $status = 'ok';

	/**
	 * Función para guardar un mensaje
	 *
	 * @param MessageDTO $data Datos del mensaje a guardar
	 * @return void
	 */
	public function run(MessageDTO $data):void {
		if (!$data->isValid()) {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
			$message = new Message();
			if ($data->getId() != -1) {
				$message->find(['id' => $data->getId()]);
			}
			else {
				$message->set('id_user', $data->getIdUser());
			}
			if ($message->get('id_user') == $data->getIdUser()) {
				$message->set('type', $data->getType());
				$message->set('body', $data->getBody());
				$message->set('done', $data->getDone());
				$message->set('is_private', $data->getIsPrivate());
				$message->set('color', $data->getColor());
				$message->save();

				$this->service['Web']->updateTags($message, $data->getTagList());
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
