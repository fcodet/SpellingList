<html>
  <head>
    <meta charset="utf-8">
    <title>Spelling List</title>
    <link rel="stylesheet" href="css/normalise.css">
    <link href='http://fonts.googleapis.com/css?family=Changa+One|Open+Sans:400,400italic,700,700italic,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/responsive.css">
    <meta name="vimport" content="width-device-width, initial-scale-1.0">
 </head>
 <body>
	<header>
		<a href="index.php" id="logo">
			<h1>Spelling List</h1>
		 </a>
		 <nav>
			<ul>
			  <li><a href="index.php" <?php if ($section == "home") { echo "class='selected'"; } ?>>Home</a></li>
			  <li><a href="about.php" <?php if ($section == "about") { echo "class='selected'"; } ?>>About</a></li>  
			  <li><a href="contact.php" <?php if ($section == "contact") { echo "class='selected'"; } ?>>Contact</a></li>  
			</ul>
		 </nav>
	</header>