<?php
use OsumiFramework\OFW\Tools\OTools;

foreach ($values['list'] as $i => $tag) {
	echo OTools::getComponent('model/tag', [ 'tag' => $tag ]);
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
