
<div data-role="navbar" class=" ui-navbar" data-grid="a" role="navigation">
	<ul class="ui-grid-a">

		<li class="ui-block-a" data-theme="c" ><a href="<?=site_url('user/active')?>" 
			class="ui-corner-top <?php if (isset($type) && $type == 'active') echo 'ui-btn-active'; ?>"
			data-theme="<?= (isset($type) && $type == 'active') ? 'd' : 'a'; ?>"
			data-role="button"><?=$this->lang->line('Active')?></a></li>

		<li class="ui-block-b" data-theme="c" ><a href="<?=site_url('user/inactive')?>"
			class="ui-corner-top <?php if (isset($type) && $type == 'inactive') echo 'ui-btn-active'; ?>"
			data-theme="<?= (isset($type) && $type == 'active') ? 'a' : 'd'; ?>"
			data-role="button"><?=$this->lang->line('History')?></a></li>

	</ul>
</div>