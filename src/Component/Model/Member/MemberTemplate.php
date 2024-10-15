<?php if (is_null($member)): ?>
null
<?php else: ?>
{
	"idUser": <?php echo is_null($member->get('id_user')) ? 'null' : $member->get('id_user') ?>,
	"isAdmin": <?php echo $member->get('is_admin') ? 'true' : 'false' ?>
}
<?php endif ?>
