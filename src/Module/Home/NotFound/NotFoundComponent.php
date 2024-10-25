<?php declare(strict_types=1);

namespace Osumi\OsumiFramework\App\Module\Home\NotFound;

use Osumi\OsumiFramework\Core\OComponent;
use Osumi\OsumiFramework\Routing\OUrl;
use Osumi\OsumiFramework\Web\ORequest;

class NotFoundComponent extends OComponent {
	/**
	 * Página de error 404
	 *
	 * @param ORequest $req Request object with method, headers, parameters and filters used
	 * @return void
	 */
	public function run(ORequest $req): void {
		OUrl::goToUrl('https://casa.osumi.es');
	}
}
