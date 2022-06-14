<?php declare(strict_types=1);

namespace OsumiFramework\App\Module\Action;

use OsumiFramework\OFW\Routing\OModuleAction;
use OsumiFramework\OFW\Routing\OAction;
use OsumiFramework\OFW\Web\ORequest;
use OsumiFramework\App\Component\TagListComponent;

#[OModuleAction(
	url: '/get-tags',
	filter: 'login',
	services: ['web'],
	components: ['model/tag_list']
)]
class getTagsAction extends OAction {
	/**
	 * Función para obtener la lista de tags de un usuario
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req):void {
		$status = 'ok';
		$filter = $req->getFilter('login');
		$tag_list_component = new TagListComponent(['list' => []]);

		if (is_null($filter) || $filter['status']=='error') {
			$status = 'error';
		}

		if ($status=='ok') {
				$list = $this->web_service->getUserTags($filter['id']);
				$tag_list_component->setValue('list', $list);
		}

		$this->getTemplate()->add('status', $status);
		$this->getTemplate()->add('list',   $tag_list_component);
	}
}
