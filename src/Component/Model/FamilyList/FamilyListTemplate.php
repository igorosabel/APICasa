<?php
use Osumi\OsumiFramework\App\Component\Model\Family\FamilyComponent;

foreach ($list as $i => $family) {
  $component = new FamilyComponent([ 'family' => $family ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
