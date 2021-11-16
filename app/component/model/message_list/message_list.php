<?php
use OsumiFramework\OFW\Tools\OTools;

foreach ($values['list'] as $i => $message) {
	echo OTools::getComponent('model/message', [ 'message' => $message ]);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
