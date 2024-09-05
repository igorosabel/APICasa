<?php
use Osumi\OsumiFramework\App\Component\Model\FamilyComponent\FamilyComponent;

foreach ($values['list'] as $i => $Family) {
  $component = new FamilyComponent([ 'Family' => $Family ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
