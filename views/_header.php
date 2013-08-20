<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Whats Up On Broadway</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width">
	<link rel="stylesheet" type="text/css" href="/assets/css/960-min.css" media="screen">
	<link rel="stylesheet" type="text/css" href="/assets/css/main.css" media="screen">
	<!-- script src="js/vendor/modernizr-2.6.2.min.js"></script -->
</head>

<body>
	<div id="container" class="container_16">
		<header class="grid_10 push_3">
			<div class="header-content">
				<div id="title">
					Whats Up On Broadway
					<div class="circles clearfix">
						<?php $x=0; while($x < 20 ){ ?>
							<div class="circle"></div>
						<?php $x++;  } ?>
					</div>
				</div>
				<div class="site-detail">
					{ lat : '<?php echo round($target['latitude'], 5)?>', long : '<?php echo round($target['longitude'], 5)?>' }
				</div>
			</div>

		</header>

		<div id="content-stream" class="grid_8 push_4">
