<?php 
require_once("inc/config.php");

$pageTitle = "Exploring the new words";
$section = "explore";
include(ROOT_PATH . 'inc/header.php'); ?>

<div id="exploreArea">
<table id="wordTable" border="1" style="width:80%">

<tr id="wordTableHeadings">
  <th style="width:150px">Word</th>
  <th style="width:150px">Sounds like</th> 
  <th style="width:300px">Definition</th>
  <th style="width:200px">Example</th>
</tr>

<tr>
  <td style="padding:10px;text-align:center">walk</td>
  <td>
	<audio id="audioArea" controls > <source src="data/walk.mp3" type="audio/mpeg" > 
	</audio>
  </td>
  <td  style="padding:10px">Move at a regular pace by lifting and setting down each foot in turn, never having both feet off the ground at once</td> 
  <td  style="padding:10px">I walked across the lawn</td>
</tr>

</table>

</div>
  <script src="js/explore.js" type="text/javascript" charset="utf-8"></script>
  </body>
</html>