<?php 

require_once("inc/config.php");

$pageTitle = "Spelling List Home";
$section = "home";
include(ROOT_PATH . 'inc/header.php'); ?>
    <div id="wrapper">
      <section>
		<p>Please enter your details:<p>
		<form action="loadinglevel.php" method="GET">
		Enter your name: <input type="text" name="userName"><br>
		<input type="submit" value="Submit">
		</form>
      </section>
     <?php include(ROOT_PATH . 'inc/footer.php'); ?>  
    </div>

  </body>
</html>
