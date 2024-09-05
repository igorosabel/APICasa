<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\ApiModule\Actions\GetMessages;

use Osumi\OsumiFramework\Routing\OModuleAction;
use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Model\MessageListComponent\MessageListComponent;

#[OModuleAction(
	url: '/get-messages',
	filters: ['Login'],
	services: ['Web']
)]
class GetMessagesAction extends OAction {
	/**
	 * Función para obtener la lista de mensajes
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$filter = $req->getFilter('Login');
		$message_list_component = new MessageListComponent(['list' => []]);

		if (is_null($filter) || $filter['status']=='error') {
			$status = 'error';
		}

		if ($status == 'ok') {
			$list = $this->service['Web']->getMessages($filter['id']);
			$message_list_component->setValue('list', $list);
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $message_list_component);
	}
}
