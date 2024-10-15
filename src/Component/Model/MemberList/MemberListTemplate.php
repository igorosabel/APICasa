<?php
use Osumi\OsumiFramework\App\Component\Model\Member\MemberComponent;

foreach ($list as $i => $member) {
  $component = new MemberComponent([ 'member' => $member ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
