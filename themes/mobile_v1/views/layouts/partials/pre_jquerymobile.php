<?php ?>

	<script type="text/javascript">
		// disable jquery mobile's automatic ajax on submit and links loading 
		$(document).bind("mobileinit", function(){
		  $.extend(  $.mobile , {
		    ajaxEnabled: 0
		  });
		});
	</script>
