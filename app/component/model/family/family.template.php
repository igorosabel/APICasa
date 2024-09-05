<?php
use OsumiFramework\App\Component\Model\MemberListComponent;
if (is_null($values['family'])) {
?>
null
<?php
}
else{
	$member_list_component = new MemberListComponent([ 'list' => $values['family']->getMembers() ]);
?>
{
	"id": <?php echo $values['family']->get('id') ?>,
	"name": "<?php echo urlencode($values['family']->get('name')) ?>",
	"members": [
<?php	echo $member_list_component ?>
	],
	"createdAt": "<?php echo $values['family']->get('created_at', 'd/m/Y H:i:s') ?>",
	"updatedAt": "<?php echo is_null($values['family']->get('updated_at')) ? 'null' : $values['family']->get('updated_at', 'd/m/Y H:i:s') ?>"
}
<?php
}
?>
