<?php declare(strict_types=1);

namespace OsumiFramework\App\Component;

use OsumiFramework\OFW\Core\OComponent;

class MessageComponent extends OComponent {
	public array $depends = ['model/tag_list'];
}
