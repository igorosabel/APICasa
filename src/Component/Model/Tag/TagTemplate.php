<?php if (is_null($tag)): ?>
null
<?php else: ?>
{
	"id": <?php echo $tag->id ?>,
	"id_user": <?php echo $tag->id_user ?>,
	"name": "<?php echo urlencode($tag->name) ?>"
}
<?php endif ?>
