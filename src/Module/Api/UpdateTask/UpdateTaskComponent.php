<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\UpdateTask;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Message;

class UpdateTaskComponent extends OComponent {
	public string $status = 'ok';

	/**
	 * Función para actualizar el estado de una tarea
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('Login');

		if (is_null($id) || is_null($filter) || $filter['status'] === 'error') {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$message = Message::findOne(['id' => $id]);
			if (!is_null($message)) {
				if ($message->id_user === $filter['id']) {
					$message->done = !$message->done;
					$message->save();
				}
				else {
					$this->status = 'error';
				}
			}
			else {
				$this->status = 'error';
			}
		}
	}
}
