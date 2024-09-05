<?php
use Osumi\OsumiFramework\App\Component\Model\MemberListComponent\MemberListComponent;
if (is_null($values['Family'])) {
?>
null
<?php
}
else{
	$member_list_component = new MemberListComponent([ 'list' => $values['Family']->getMembers() ]);
?>
{
	"id": <?php echo $values['Family']->get('id') ?>,
	"name": "<?php echo urlencode($values['Family']->get('name')) ?>",
	"members": [
<?php	echo $member_list_component ?>
	],
	"createdAt": "<?php echo $values['Family']->get('created_at', 'd/m/Y H:i:s') ?>",
	"updatedAt": "<?php echo is_null($values['Family']->get('updated_at')) ? 'null' : $values['Family']->get('updated_at', 'd/m/Y H:i:s') ?>"
}
<?php
}
?>
