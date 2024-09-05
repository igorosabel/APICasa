<?php
use Osumi\OsumiFramework\App\Component\Model\TagListComponent\TagListComponent;
if (is_null($values['Message'])) {
?>
null
<?php
}
else{
	$tag_list_component = new TagListComponent([ 'list' => $values['Message']->getTags() ]);
?>
{
	"id": <?php echo $values['Message']->get('id') ?>,
	"idUser": <?php echo is_null($values['Message']->get('id_user')) ? 'null' : $values['Message']->get('id_user') ?>,
	"body": "<?php echo urlencode($values['Message']->get('body')) ?>",
	"type": <?php echo $values['Message']->get('type') ?>,
	"done": <?php echo $values['Message']->get('done') ? 'true' : 'false' ?>,
	"isPrivate": <?php echo $values['Message']->get('is_private') ? 'true' : 'false' ?>,
	"tags": [
<?php	echo $tag_list_component ?>
	],
	"date": "<?php echo is_null($values['Message']->get('updated_at')) ? 'null' : $values['Message']->get('updated_at', 'd/m/Y H:i:s') ?>",
	"color": "<?php echo $values['Message']->getColor() ?>"
}
<?php
}
?>
