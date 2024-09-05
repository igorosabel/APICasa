<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\ApiModule\Actions\SaveMessage;

use Osumi\OsumiFramework\Routing\OModuleAction;
use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\App\DTO\MessageDTO;
use Osumi\OsumiFramework\App\Model\Message;

#[OModuleAction(
	url: '/save-message',
	filters: ['Login'],
	services: ['Web']
)]
class SaveMessageAction extends OAction {
	/**
	 * Función para guardar un mensaje
	 *
	 * @param MessageDTO $data Datos del mensaje a guardar
	 * @return void
	 */
	public function run(MessageDTO $data):void {
		$status = 'ok';

		if (!$data->isValid()) {
			$status = 'error';
		}

		if ($status=='ok') {
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
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}
}
