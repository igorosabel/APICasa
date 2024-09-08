<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\ApiModule\Actions\GetMessages;

use Osumi\OsumiFramework\Routing\OModuleAction;
use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Model\MessageList\MessageListComponent;

#[OModuleAction(
	url: '/get-messages',
	filters: ['Login'],
	services: ['Web']
)]
class GetMessagesAction extends OAction {
	public string $status = 'ok';
	public ?MessageListComponent $list = null;

	/**
	 * Función para obtener la lista de mensajes
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$filter = $req->getFilter('Login');
		$this->list = new MessageListComponent(['list' => []]);

		if (is_null($filter) || $filter['status']=='error') {
			$this->status = 'error';
		}

		if ($this->status == 'ok') {
			$this->list->setValue('list', $this->service['Web']->getMessages($filter['id']));
		}
	}
}
