<?php
use OsumiFramework\App\Component\TagComponent;

foreach ($values['list'] as $i => $tag) {
	$tag_component = new TagComponent([ 'tag' => $tag ]);
	echo $tag_component;
	if ($i<count($values['list'])-1) {
		echo ",\n";
	}
}
