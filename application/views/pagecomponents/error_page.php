<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Error Page</title>
	<link href="<?php echo base_url() . 'pageConstructions/'?>tools/style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url() . 'pageConstructions/'?>tools/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() . 'pageConstructions/'?>tools/cufon-yui.js"></script>
	<script type="text/javascript" src="<?php echo base_url() . 'pageConstructions/'?>tools/Akzidenz-Grotesk_BQ_500-Akzidenz-Grotesk_BQ_500-Akzidenz-Grotesk_BQ_italic_700.font.js"></script>
	<script type="text/javascript" src="<?php echo base_url() . 'pageConstructions/'?>tools/FontSoupGerman_700.font.js"></script>

	<script type="text/javascript" src="<?php echo base_url() . 'pageConstructions/'?>tools/Gotham_Rounded_Medium_350.font.js"></script>
	<script type="text/javascript">
		Cufon.replace('.logo h1', {fontFamily: 'FontSoupGerman'});
		Cufon.replace('.logo span', {fontFamily: 'Gotham Rounded Medium'});
		Cufon.replace('h2 strong', {fontFamily: 'Akzidenz-Grotesk BQ'});
		Cufon.replace('h2 span', {fontFamily: 'Akzidenz-Grotesk BQ'});
	</script>

</head>
<body>
<div id="wrapper">
	<div class="main_content">
		<div class="uppersection">
			<div class="logo"></div>
			<h2><strong>Sorry <?php echo $number != 0 && count($orderNumber)>0 ? 'your order number is already used' : 'you have not enter your order number'?>!</strong></h2>
			<p>Please proceed to your email and try again.</p>
		</div>
	</div>
</div>
</body>
</html>
