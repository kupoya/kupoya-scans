<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

/// QUIT!!
exit;

if ($strategy['plan_type'] === 'expiration'):
	// if this is an expiration time then we want to print out when this lottery will end
	$diff = ($strategy['expiration_date'] - time());
	// if diff is more than 0 then this expiration date is in the future and we should tell
	// the user when the strategy is over...
	$days = 0;
	if ($diff >= 0):
		// there's a diff so include the javascript library as we need it
		echo js('jquery.lwtCountdown-1.0.js', 'lottery');

		//$days = (int) ($diff/86400) . ' days';
		$days = (int) ($diff/86400);
?>
<script language="javascript" type="text/javascript">
	$(document).ready(function() {
		$('#countdown_dashboard').countDown({
			targetOffset: {
				'day': 		<?php echo $days; ?>,
				'month': 	0,
				'year': 	0,
				'hour': 	0,
				'min': 		0,
				'sec': 		0
			}
		});
	});
</script>
<?php
	endif;
endif;
?>