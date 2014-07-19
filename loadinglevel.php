<?php 

require_once("inc/config.php");

$pageTitle = "Loading Information";
$section = "home";
$user = $_GET['userName'];
include(ROOT_PATH . 'inc/header.php'); ?>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript" charset="utf-8"></script>
	<div id="wrapper">
      <section>
		<div id="greetingArea">
			<p><?php echo "Hello ".$user." !"?></p>
			<p>Loading your details...</p>
			<div id="loadingDetails"></div>
			<br></br>
			<div id="newWords"></div>
			<button id="startMessage"></button>
		</div>
		<div id="wordTableArea">
		</div>
      </section>
	  
     <?php include(ROOT_PATH . 'loadfileinfo.php'); ?>
	<?php include(ROOT_PATH . 'inc/footer.php'); ?>  
	</div>
	 
     <?php include(ROOT_PATH . 'loadJSvars.php'); ?>
     <script src="js/init.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/explore.js" type="text/javascript" charset="utf-8"></script>
	
  </body>
</html>
