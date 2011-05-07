
<script>

$(document).ready(function() {
	$("#submit_btn").click(function() {

		$.ajax({
			type:		'POST',
			url:		'<?php echo site_url('coupon/coupon_create')?>',
			//data:		'',
			dataType:	"html",
			success:	function(data) {
				$("#coupon_code").html(data);
			}
		});

	});
});


</script>


<h1>Coupon for Aroma</h1>
<p>
You are entitled to get a free coupon from Aroma Bar&Coffee
<br/>
<small>clicking the button will post a wall post to your facebook</small>
<br/><br/>
<br/><br/>
<button id='submit_btn' name='coupon_get' type='button'>Get Coupon!</button>
<br/>
<br/><br/>
<br/><br/>

<div id="coupon_code">
</div>
<?php 
	//var_dump($agent);var_dump
	//var_dump($fql);
	var_dump($fbUser);
?>
<br/><br/>

    	
    	
		<div id="fb-root"></div>
		<script type="text/javascript">
		/*
		window.fbAsyncInit = function() {
				FB.init({
		        		appId: '<?php //$appkey?>',
		        		status: true,
		        		cookie: true,
		        		xfbml: true,
		        		//session : <?php //echo json_encode($session); ?>, // don't refetch the session when PHP already has it
		        });


		        
		};
				(function() {
			        var e = document.createElement('script');
		            e.type = 'text/javascript';
		            e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
			          e.async = true;
		            document.getElementById('fb-root').appendChild(e);
		   	 	}());
	*/	            
/*

		        FB.api(
		        		  {
		        		    method: 'fql.query',
		        		    query: 'SELECT name FROM user WHERE uid=686773813'
		        		  },
		        		  function(response) {
		        		    alert('Name is ' + response[0].name);
		        		  }
		        		);
*/	          	
	   		

			
		</script>