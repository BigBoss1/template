<html>
<head>
	<title><?php echo $args[0]; ?></title>
	<?php
		HTML::put_css();
		HTML::put_js();
	?>
</head>

<body>
<div id="wrapper">
<div id="menu">
<?php echo Menu::get_menu_html(); ?>
</div>
<div id="main">
