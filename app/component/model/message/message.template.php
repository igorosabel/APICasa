<?php
use OsumiFramework\App\Component\Model\TagListComponent;
if (is_null($values['message'])) {
?>
null
<?php
}
else{
	$tag_list_component = new TagListComponent([ 'list' => $values['message']->getTags() ]);
?>
{
	"id": <?php echo $values['message']->get('id') ?>,
	"id_user": <?php echo is_null($values['message']->get('id_user')) ? 'null' : $values['message']->get('id_user') ?>,
	"body": "<?php echo urlencode($values['message']->get('body')) ?>",
	"type": <?php echo $values['message']->get('type') ?>,
	"done": <?php echo $values['message']->get('done') ? 'true' : 'false' ?>,
	"is_private": <?php echo $values['message']->get('is_private') ? 'true' : 'false' ?>,
	"tags": [
<?php	echo $tag_list_component ?>
	],
	"date": "<?php echo is_null($values['message']->get('updated_at')) ? 'null' : $values['message']->get('updated_at', 'd/m/Y H:i:s') ?>",
	"color": "<?php echo $values['message']->getColor() ?>"
}
<?php
}
?>
