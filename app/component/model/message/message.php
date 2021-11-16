<?php
use OsumiFramework\OFW\Tools\OTools;
?>
<?php if (is_null($values['message'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['message']->get('id') ?>,
	"id_user": <?php echo is_null($values['message']->get('id_user')) ? 'null' : $values['message']->get('id_user') ?>,
	"body": "<?php echo urlencode($values['message']->get('body')) ?>",
	"type": <?php echo $values['message']->get('type') ?>,
	"done": <?php echo $values['message']->get('done') ? 'true' : 'false' ?>,
	"is_private": <?php echo $values['message']->get('is_private') ? 'true' : 'false' ?>,
	"tags": [
<?php	echo OTools::getComponent('model/tag_list', [ 'list' => $values['message']->getTags() ]); ?>
	],
	"date": "<?php echo is_null($values['message']->get('updated_at')) ? 'null' : $values['message']->get('updated_at', 'd/m/Y H:i:s') ?>",
	"color": "<?php echo $values['message']->getColor() ?>"
}
<?php endif ?>
