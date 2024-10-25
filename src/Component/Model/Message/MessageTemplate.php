<?php
use Osumi\OsumiFramework\App\Component\Model\TagList\TagListComponent;
if (is_null($message)) {
?>
null
<?php
}
else {
?>
{
	"id": <?php echo $message->id ?>,
	"idUser": <?php echo is_null($message->id_user) ? 'null' : $message->id_user ?>,
	"body": "<?php echo urlencode($message->body) ?>",
	"type": <?php echo $message->type ?>,
	"done": <?php echo $message->done ? 'true' : 'false' ?>,
	"isPrivate": <?php echo $message->is_private ? 'true' : 'false' ?>,
	"tags": [
<?php	echo new TagListComponent([ 'list' => $message->getTags() ]) ?>
	],
	"date": "<?php echo is_null($message->updated_at) ? 'null' : $message->get('updated_at', 'd/m/Y H:i:s') ?>",
	"color": "<?php echo $message->getColor() ?>"
}
<?php
}
?>
