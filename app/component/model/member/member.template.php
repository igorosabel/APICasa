<?php if (is_null($values['member'])): ?>
null
<?php else: ?>
{
	"idUser": <?php echo is_null($values['member']->get('id_user')) ? 'null' : $values['member']->get('id_user') ?>,
	"isAdmin": <?php echo $values['member']->get('is_admin') ? 'true' : 'false' ?>
}
<?php endif ?>
