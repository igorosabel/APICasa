<?php
use Osumi\OsumiFramework\App\Component\Model\Member\MemberComponent;

foreach ($values['list'] as $i => $Member) {
  $component = new MemberComponent([ 'Member' => $Member ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
