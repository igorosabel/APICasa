<?php
use Osumi\OsumiFramework\App\Component\Model\MemberList\MemberListComponent;
if (is_null($family)) {
?>
null
<?php
}
else{
	$member_list_component = new MemberListComponent([ 'list' => $family->getMembers() ]);
?>
{
	"id": <?php echo $family->get('id') ?>,
	"name": "<?php echo urlencode($family->get('name')) ?>",
	"members": [
<?php	echo $member_list_component ?>
	],
	"createdAt": "<?php echo $family->get('created_at', 'd/m/Y H:i:s') ?>",
	"updatedAt": "<?php echo is_null($family->get('updated_at')) ? 'null' : $family->get('updated_at', 'd/m/Y H:i:s') ?>"
}
<?php
}
?>
