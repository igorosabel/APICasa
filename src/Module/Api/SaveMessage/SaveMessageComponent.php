<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\SaveMessage;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\App\DTO\MessageDTO;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Model\Message;

class SaveMessageComponent extends OComponent {
	private ?WebService $ws = null;

	public string $status = 'ok';

	public function __construct() {
    parent::__construct();
		$this->ws = inject(WebService::class);
	}

	/**
	 * Función para guardar un mensaje
	 *
	 * @param MessageDTO $data Datos del mensaje a guardar
	 * @return void
	 */
	public function run(MessageDTO $data): void {
		if (!$data->isValid()) {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			if ($data->getId() !== -1) {
				$message = Message::findOne(['id' => $data->getId()]);
			}
			else {
				$message = Message::create();
				$message->id_user = $data->getIdUser();
			}
			if ($message->id_user === $data->getIdUser()) {
				$message->type       = $data->getType();
				$message->body       = $data->getBody();
				$message->done       = $data->getDone();
				$message->is_private = $data->getIsPrivate();
				$message->color      = $data->getColor();
				$message->save();

				$this->ws->updateTags($message, $data->getTagList());
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
