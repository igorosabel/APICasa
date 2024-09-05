<?php
use OsumiFramework\App\Component\Model\FamilyComponent;

foreach ($values['list'] as $i => $family) {
  $component = new FamilyComponent([ 'family' => $family ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
