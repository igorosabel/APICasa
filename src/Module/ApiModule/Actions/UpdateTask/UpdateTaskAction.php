<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\ApiModule\Actions\UpdateTask;

use Osumi\OsumiFramework\Routing\OModuleAction;
use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Message;

#[OModuleAction(
	url: '/update-task',
	filters: ['Login']
)]
class UpdateTaskAction extends OAction {
	/**
	 * Función para actualizar el estado de una tarea
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('Login');

		if (is_null($id) || is_null($filter) || $filter['status']=='error') {
			$status = 'error';
		}

		if ($status == 'ok') {
			$message = new Message();
			if ($message->find(['id' => $id])) {
				if ($message->get('id_user') == $filter['id']) {
					$message->set('done', !$message->get('done'));
					$message->save();
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status', $status);
	}
}