<?php if (isset($page_title) && !empty($page_title)): ?>
	<span style="margin-bottom: 15px; display: block;"><?= htmlentities($page_title); ?></span>
<?php else: ?>
	<span style="margin-bottom: 15px; display: block;">kupoya</span>
<?php endif; ?>

<?php if (isset($header_follow_link) && !empty($header_follow_link)): ?>
	<a href="<?= $header_follow_link?>" class="ui-btn-right" style="margin-top: 7px;"><?= $this->lang->line('menu:Follow');?></a>
<?php endif; ?>

<?php
	if (isset($header_content) && !empty($header_content)) {
		echo $header_content;
	}
?>
