<?php
use Osumi\OsumiFramework\App\Component\Model\TagList\TagListComponent;
if (is_null($message)) {
?>
null
<?php
}
else{
	$tag_list_component = new TagListComponent([ 'list' => $message->getTags() ]);
?>
{
	"id": <?php echo $message->get('id') ?>,
	"idUser": <?php echo is_null($message->get('id_user')) ? 'null' : $message->get('id_user') ?>,
	"body": "<?php echo urlencode($message->get('body')) ?>",
	"type": <?php echo $message->get('type') ?>,
	"done": <?php echo $message->get('done') ? 'true' : 'false' ?>,
	"isPrivate": <?php echo $message->get('is_private') ? 'true' : 'false' ?>,
	"tags": [
<?php	echo $tag_list_component ?>
	],
	"date": "<?php echo is_null($message->get('updated_at')) ? 'null' : $message->get('updated_at', 'd/m/Y H:i:s') ?>",
	"color": "<?php echo $message->getColor() ?>"
}
<?php
}
?>
