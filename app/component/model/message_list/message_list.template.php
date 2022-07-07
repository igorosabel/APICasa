<?php
use OsumiFramework\App\Component\Model\MessageComponent;

foreach ($values['list'] as $i => $message) {
	$message_component = new MessageComponent([ 'message' => $message ]);
	echo $message_component;
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
