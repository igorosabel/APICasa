<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\ApiModule\Actions\GetTags;

use Osumi\OsumiFramework\Routing\OModuleAction;
use Osumi\OsumiFramework\Routing\OAction;
use Osumi\OsumiFramework\Web\ORequest;
use Osumi\OsumiFramework\App\Component\Model\TagListComponent\TagListComponent;

#[OModuleAction(
	url: '/get-tags',
	filters: ['Login'],
	services: ['Web']
)]
class GetTagsAction extends OAction {
	/**
	 * Función para obtener la lista de tags de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$filter = $req->getFilter('Login');
		$tag_list_component = new TagListComponent(['list' => []]);

		if (is_null($filter) || $filter['status']=='error') {
			$status = 'error';
		}

		if ($status=='ok') {
				$list = $this->service['Web']->getUserTags($filter['id']);
				$tag_list_component->setValue('list', $list);
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $tag_list_component);
	}
}
