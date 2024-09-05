<?php if (is_null($values['Member'])): ?>
null
<?php else: ?>
{
	"idUser": <?php echo is_null($values['Member']->get('id_user')) ? 'null' : $values['Member']->get('id_user') ?>,
	"isAdmin": <?php echo $values['Member']->get('is_admin') ? 'true' : 'false' ?>
}
<?php endif ?>
