<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\ApiModule\Actions\GetMessage;

use Osumi\OsumiFramework\Routing\OModuleAction;
use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Message;
use Osumi\OsumiFramework\App\Model\User;
use Osumi\OsumiFramework\App\Component\Model\MessageComponent\MessageComponent;

#[OModuleAction(
	url: '/get-message',
	filters: ['Login']
)]
class GetMessageAction extends OAction {
	/**
	 * Función para obtener un mensaje concreto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status  = 'ok';
		$id      = $req->getParamInt('id');
		$filter  = $req->getFilter('Login');
		$message_component = new MessageComponent(['Message' => null]);

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
					$message_component->setValue('Message', $message);
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
