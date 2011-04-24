<?php




?>


    	<!-- FB CODE -->
		<div id="fb-root"></div>
		<script type="text/javascript">
			window.fbAsyncInit = function() {
	        	FB.init({
		        		appId: '<?=$facebook['app_id']?>',
		        		status: true,
		        		cookie: true,
		        		xfbml: true,
		        		//session : <?php //echo json_encode($session); ?>, // don't refetch the session when PHP already has it
		        });
	 
	            /* All the events registered */
	            FB.Event.subscribe('auth.login', function(response) {
	    			// do something with response
	                login();
	        	});
	
	            FB.Event.subscribe('auth.logout', function(response) {
	            // do something with response
	                logout();
	          	});
	   		};
	
	        (function() {
		        var e = document.createElement('script');
	            e.type = 'text/javascript';
	            e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
		          e.async = true;
	            document.getElementById('fb-root').appendChild(e);
	   	 	}());
	 
	        function login() {

	            var myPermissions = "<?=$facebook['perms']?>"; // permissions your app needs
/*
	            FB.Connect.showPermissionDialog(myPermissions , function(perms) {
	              if (!perms)
	              {
	                  // handles if the user rejects the request for permissions. 
	                  // This is a good place to log off from Facebook connect
	                  alert('rejecting you, bad user');
	                  logout();
	              }
	              else
	              {
	                 	 // finish up here if the user has accepted permission request
	                  alert('ok, lets continue');
	        		  document.location.href = "<?=$facebook['nextUrl']?>";
	              }
	            });
*/
				document.location.href = "<?=$facebook['nextUrl']?>";

	     	}
	
	        function logout() {
	        	document.location.href = "<?=base_url()?>";
	 		}
		</script>
		<!-- END OF FB CODE -->

<center>
<img src='<?= site_url('images/logo1.png')?>' />
<h1>Welcome to Scanalo!</h1>
<p>
We are happy to provide you with great service here at Scanalo.
<br/><br/>
<br/><br/>


<img src='http://www.resident.co.il/pics/places/medium/1621_1.jpg' />
<br/>
<?php echo $brand['description']?>


<br/><br/>
<a href='<?php echo $facebook['loginUrl'] ?>' /> Login 2 </a>
<br/><br/>
	<fb:login-button onlogin="login();" size="large" perms="user_location,user_checkins,status_update,user_birthday,publish_stream">
		Get your FREE Coupon
	</fb:login-button>
	<?php
		//echo '<a href="'.$fbLoginURL.'" > Login with Facbeook </a>'; 
	?>
<br/>
<small>click to login with your facebook account</small>
</p>