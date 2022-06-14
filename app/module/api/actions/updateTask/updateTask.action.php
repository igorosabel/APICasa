<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Message;

#[OModuleAction(
	url: '/update-task',
	filter: 'login'
)]
class updateTaskAction extends OAction {
	/**
	 * Función para actualizar el estado de una tarea
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$id     = $req->getParamInt('id');
		$filter = $req->getFilter('login');

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
