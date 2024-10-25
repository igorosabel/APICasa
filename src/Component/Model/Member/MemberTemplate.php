<?php if (is_null($member)): ?>
null
<?php else: ?>
{
	"idUser": <?php echo is_null($member->id_user) ? 'null' : $member->id_user ?>,
	"isAdmin": <?php echo $member->is_admin ? 'true' : 'false' ?>
}
<?php endif ?>
