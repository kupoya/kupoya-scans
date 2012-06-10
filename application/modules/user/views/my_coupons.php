<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
?>




<ul data-role="listview" data-corners="false">

	<?php foreach($my_coupons as $coupon): ?>
	    <li data-corners="false">
	    	<a href="<?=site_url('coupon/view/'.$coupon['id']);?>">
		        <img src='<?=site_url(htmlentities($coupon['strategy_picture']))?>' class='border' />
		       	<h3 class="ui-li-heading"><?=htmlentities($coupon['brand_name'])?></h3>
				<span class="ui-li-desc"><?=htmlentities($coupon['strategy_name'])?></span>
		        <!-- <span  class=" time"><?=htmlentities($coupon['purchased_time'])?></span> -->
		        <span  class=" time"><?=time_ago($coupon['purchased_time'])?></span>
		        
	        </a>
	    </li>
	<?php endforeach; ?>

</ul>

<br/>