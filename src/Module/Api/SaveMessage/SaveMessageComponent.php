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
				$message = Message::findOne(['id' => $data->id]);
			}
			else {
				$message = Message::create();
				$message->id_user = $data->id_user;
			}
			if ($message->id_user === $data->id_user) {
				$message->type       = $data->type;
				$message->body       = $data->body;
				$message->done       = $data->done;
				$message->is_private = $data->is_private;
				$message->color      = $data->color;
				$message->save();

				$this->ws->updateTags($message, $data->tag_list);
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
