<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetMessages;

use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Service\WebService;
use Osumi\OsumiFramework\App\Component\Model\MessageList\MessageListComponent;

class GetMessagesAction extends OAction {
	private ?WebService $ws = null;

	public string $status = 'ok';
	public ?MessageListComponent $list = null;

	public function __construct() {
		$this->ws = inject(WebService::class);
		$this->list = new MessageListComponent(['list' => []]);
	}

	/**
	 * Función para obtener la lista de mensajes
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$filter = $req->getFilter('Login');

		if (is_null($filter) || $filter['status'] === 'error') {
			$this->status = 'error';
		}

		if ($this->status === 'ok') {
			$this->list->setValue('list', $this->ws->getMessages($filter['id']));
		}
	}
}
