<?php if (isset($page_title) && !empty($page_title)): ?>
	<span><?= htmlentities($page_title); ?></span>
<?php else: ?>
	<span>kupoya</span>
<?php endif; ?>

<?php if (isset($header_follow_link) && !empty($header_follow_link)): ?>
	<a href="<?= $header_follow_link?>" class="ui-btn-right">Follow</a>
<?php endif; ?>

<?php
	if (isset($header_content) && !empty($header_content)) {
		echo $header_content;
	}
?>
