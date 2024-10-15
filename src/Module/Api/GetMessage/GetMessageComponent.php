<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Api\GetMessage;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Model\Message;
use Osumi\OsumiFramework\App\Model\User;
use Osumi\OsumiFramework\App\Component\Model\Message\MessageComponent;

class GetMessageComponent extends OComponent {
	public string $status = 'ok';
	public ?MessageComponent $message = null;

	/**
	 * Función para obtener un mensaje concreto
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$id      = $req->getParamInt('id');
		$filter  = $req->getFilter('Login');
		$this->message = new MessageComponent();

		if (is_null($id) || is_null($filter) || $filter['status']=='error') {
			$this->status = 'error';
		}

		if ($this->status == 'ok') {
			$message = new Message();
			if ($message->find(['id' => $id])) {
				if ($message->get('id_user') == $filter['id']) {
					$user = new User();
					$user->find(['id' => $message->get('id_user')]);
					$message->setColor($user->get('color'));
					$this->message->message = $message;
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
