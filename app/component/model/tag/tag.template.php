<?php if (is_null($values['tag'])): ?>
null
<?php else: ?>
{
	"id": <?php echo $values['tag']->get('id') ?>,
	"id_user": <?php echo $values['tag']->get('id_user') ?>,
	"name": "<?php echo urlencode($values['tag']->get('name')) ?>"
}
<?php endif ?>
