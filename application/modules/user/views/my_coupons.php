<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//var_dump($user);
//var_dump($my_coupons);
?>

	<div id="header">
		 
		 <br/>
		<div id="breadcrumb">
			<h3 class='theme_title_text_color'><?= $this->lang->line('my_coupons'); ?></h3>
		</div>
		
	</div>

	<br/>

<ul data-role="listview" data-inset="true" data-theme="e">

	<?php foreach($my_coupons as $coupon): ?>
	<li data-theme="<?=($coupon['status'] == 'validated') ? 'a' : 'e' ?>" data-corners="false" data-shadow="false" data-iconshadow="true" data-inline="false" data-wrapperels="div" data-icon="arrow-r" data-iconpos="right" class="ui-btn ui-btn-icon-right ui-li-has-arrow ui-li ui-li-has-thumb ui-btn-up-<?=($coupon['status'] == 'validated') ? 'a' : 'e' ?>">
		<div class="ui-btn-inner ui-li">
			<div class="ui-btn-text">
			<a href="<?=site_url('coupon/view/'.$coupon['id']);?>" class="ui-link-inherit">
			<img src='<?=site_url(htmlentities($coupon['strategy_picture']))?>' alt='logo' class="ui-li-thumb" />
				<h3 class="ui-li-heading"><?=htmlentities($coupon['strategy_name'])?></h3>
				<p class="ui-li-desc"><?=htmlentities($coupon['purchased_time'])?></p>
				<span class="ui-li-count ui-btn-up-c ui-btn-corner-all"><?=htmlentities($coupon['serial'])?></span>
			</a>
		</div><span class="ui-icon ui-icon-arrow-r ui-icon-shadow"></span>
		</div>
	</li>
	<?php endforeach; ?>

</ul>

</br><br/>
