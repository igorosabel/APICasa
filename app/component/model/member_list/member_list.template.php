<?php
use OsumiFramework\App\Component\Model\MemberComponent;

foreach ($values['list'] as $i => $member) {
  $component = new MemberComponent([ 'member' => $member ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
