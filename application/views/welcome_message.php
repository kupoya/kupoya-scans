<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Welcome to Kupoya</title>

<style type="text/css">

body {
 background-color: #fff;
 margin: 40px;
 font-family: Lucida Grande, Verdana, Sans-serif;
 font-size: 14px;
 color: #4F5155;
}

a {
 color: #003399;
 background-color: transparent;
 font-weight: normal;
}

h1 {
 color: #444;
 background-color: transparent;
 border-bottom: 1px solid #D0D0D0;
 font-size: 16px;
 font-weight: bold;
 margin: 24px 0 2px 0;
 padding: 5px 0 6px 0;
}

code {
 font-family: Monaco, Verdana, Sans-serif;
 font-size: 12px;
 background-color: #f9f9f9;
 border: 1px solid #D0D0D0;
 color: #002166;
 display: block;
 margin: 14px 0 14px 0;
 padding: 12px 10px 12px 10px;
}

</style>
</head>
<body>

<?php 
//var_dump($brand);
//var_dump($agent);
//var_dump($facebook);

//var_dump($facebook['loginUrl'])
?>


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
<a href='<?php echo $facebook['loginUrl'] ?>' /> Login </a>
<br/><br/>

<br/>
<small>click to login with your facebook account</small>
</p>


<br/><br/><br/><br/>
<br/><br/><br/><br/>
<p> Scanalo @ Copyright 2011 </p>
</center>



</body>
</html>