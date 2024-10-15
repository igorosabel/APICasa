<?php
use Osumi\OsumiFramework\App\Component\Model\Message\MessageComponent;

foreach ($list as $i => $message) {
  $component = new MessageComponent([ 'message' => $message ]);
	echo strval($component);
	if ($i < count($list) - 1) {
		echo ",\n";
	}
}
