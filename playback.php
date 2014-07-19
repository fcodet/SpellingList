<?php 
require_once("inc/config.php");

$pageTitle = "Exploring the new words";
$section = "play";
$user = $_GET['userName'];

include(ROOT_PATH . 'inc/header.php'); ?>
	<?php if (DEV_ENV=="DEV") {ChromePhp::log("ROOT PATH:".ROOT_PATH);} ?>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript" charset="utf-8"></script>
	<?php include(ROOT_PATH . 'loadfileinfo.php'); ?>
	<?php include(ROOT_PATH . 'loadJSvars.php'); ?>
	
	<div id="playArea">
	</div>

	<script src="js/play.js" type="text/javascript" charset="utf-8"></script>
  </body>
</html>