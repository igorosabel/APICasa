<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\ApiModule\Actions\GetTags;

use Osumi\OsumiFramework\Routing\OModuleAction;
use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Model\TagList\TagListComponent;

#[OModuleAction(
	url: '/get-tags',
	filters: ['Login'],
	services: ['Web']
)]
class GetTagsAction extends OAction {
	public string $status = 'ok';
	public ?TagListComponent $list = null;

	/**
	 * Función para obtener la lista de tags de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$filter = $req->getFilter('Login');
		$this->list = new TagListComponent(['list' => []]);

		if (is_null($filter) || $filter['status']=='error') {
			$this->status = 'error';
		}

		if ($this->status=='ok') {
				$this->list->setValue('list', $this->service['Web']->getUserTags($filter['id']));
		}
	}
}
