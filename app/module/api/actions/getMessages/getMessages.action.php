<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\MessageListComponent;

#[OModuleAction(
	url: '/get-messages',
	filter: 'login',
	services: ['web'],
	components: ['model/message_list']
)]
class getMessagesAction extends OAction {
	/**
	 * Función para obtener la lista de mensajes
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$filter = $req->getFilter('login');
		$message_list_component = new MessageListComponent(['list' => []]);

		if (is_null($filter) || $filter['status']=='error') {
			$status = 'error';
		}

		if ($status == 'ok') {
			$list = $this->web_service->getMessages($filter['id']);
			$message_list_component->setValue('list', $list);
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $message_list_component);
	}
}
