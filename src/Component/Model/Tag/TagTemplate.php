<?php if (is_null($tag)): ?>
null
<?php else: ?>
{
	"id": <?php echo $tag->get('id') ?>,
	"id_user": <?php echo $tag->get('id_user') ?>,
	"name": "<?php echo urlencode($tag->get('name')) ?>"
}
<?php endif ?>
