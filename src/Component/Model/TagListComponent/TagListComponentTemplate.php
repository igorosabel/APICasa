<?php
use Osumi\OsumiFramework\App\Component\Model\TagComponent\TagComponent;

foreach ($values['list'] as $i => $Tag) {
  $component = new TagComponent([ 'Tag' => $Tag ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
