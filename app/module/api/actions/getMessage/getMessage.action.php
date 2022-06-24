<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Model\Message;
use OsumiFramework\App\Model\User;
use OsumiFramework\App\Component\MessageComponent;

#[OModuleAction(
	url: '/get-message',
	filters: ['login'],
	components: ['model/message']
)]
class getMessageAction extends OAction {
	/**
	 * Función para obtener un mensaje concreto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status  = 'ok';
		$id      = $req->getParamInt('id');
		$filter  = $req->getFilter('login');
		$message_component = new MessageComponent(['message' => null]);

		if (is_null($id) || is_null($filter) || $filter['status']=='error') {
			$status = 'error';
		}

		if ($status == 'ok') {
			$message = new Message();
			if ($message->find(['id' => $id])) {
				if ($message->get('id_user') == $filter['id']) {
					$user = new User();
					$user->find(['id' => $message->get('id_user')]);
					$message->setColor($user->get('color'));
					$message_component->setValue('message', $message);
				}
				else {
					$status = 'error';
				}
			}
			else {
				$status = 'error';
			}
		}

		$this->getTemplate()->add('status',  $status);
		$this->getTemplate()->add('message', $message_component);
	}
}
