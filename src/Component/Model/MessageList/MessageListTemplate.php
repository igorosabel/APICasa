<?php
use Osumi\OsumiFramework\App\Component\Model\Message\MessageComponent;

foreach ($values['list'] as $i => $Message) {
  $component = new MessageComponent([ 'Message' => $Message ]);
	echo strval($component);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
