<?php 
include('ChromePhp.php');
require_once("inc/config.php");

$pageTitle = "Loading Information";
$section = "home";
$user = $_GET['userName'];
include(ROOT_PATH . 'inc/header.php'); ?>
    <div id="wrapper">
      <section>
		<p><?php echo "Hello ".$user." !"?>
		<p>Loading your details...<p>
		
      </section>
     <?php include(ROOT_PATH . 'inc/footer.php'); ?>  
	
	<?php
		//Download User Information
		//Store in userInfo.txt
		//Format as follows:
		//"fieldUserName":user
		//"fieldLastLevel":string(level) //Last successful level
		//"fieldWordsSeen": [ ["word1", //the actual spelling of the word
		//               [ [date1,rank1],[date2,rank2] ,[date3,rank3] ,[date4,rank4] ] // list of [date seen, rank = double(0.00=didn't know -> 1.00=correct result) ]
		
		$userFileName = "./userdata/".$user."Info.txt";
		define("USERNAME_FIELD", "fieldUserName:");
		define("LASTLEVEL_FIELD", "fieldLastLevel:");
		define("WORDSSEEN_FIELD", "fieldWordsSeen:");
		
		ChromePhp::log("File Name: ".$userFileName);
		$myFile=fopen($userFileName,"r+") or die("Unable to open file");
		ChromePhp::log("$myFile Object: ".$myFile);
		
		while(!feof($myFile)) {
		  $readLine = fgets($myFile);
		  $readLine = str_replace(array("\n", "\r"), '', $readLine); //remove new line and carriage return
			if (strpos($readLine, USERNAME_FIELD)!==false) {
			$userName = str_replace( USERNAME_FIELD,"",$readLine);
			ChromePhp::log($userName);
			}
			if (strpos($readLine,LASTLEVEL_FIELD)!==false) {
			$lastLevel = str_replace( LASTLEVEL_FIELD,"",$readLine);
			ChromePhp::log($lastLevel);
			}
			if (strpos($readLine,WORDSSEEN_FIELD)!==false) {
			$wordsSeen = str_replace( WORDSSEEN_FIELD,"",$readLine);
			ChromePhp::log($wordsSeen);
			}
		}
		fclose($myFile);
		
		//Let's check that all user data fields have been found.
		$userInfoComplete = ((isset($userName)) AND (isset($lastLevel)) AND (isset($wordsSeen)));
		
		if ($userInfoComplete) {
			//Download User's current Level information
			//The current level file to download will be level'n'SpellingList.txt with 'n'=$lastLevel+1 (from the userInfo file)
			$currentlevel = (string)(((int)$lastLevel)+1);
			ChromePhp::log("Current level: ".$currentlevel);
			$levelFileName = "./data/level".$currentlevel."SpellingList.txt";
			ChromePhp::log("Level file name: ".$levelFileName);
			//We have the name of the file containing the new words for the current level being attempted
			$currentWordList = array();
			$myFile=fopen($levelFileName,"r+") or die("Unable to open file");
			while(!feof($myFile)) {
			  $readLine = fgets($myFile);
			  $readWord = str_replace(array("\n", "\r"), '', $readLine); //remove new line and carriage return
			  array_push($currentWordList, $readWord);
			 }
			fclose($myFile);
			ChromePhp::log($currentWordList);
		}
		else {
		//TODO Treat error - problem with userInfo.txt file information
		}
		
		
		
		
		
		
		
		
		//Download User's current Level information
		//The current level file to download will be levelnSpellingList.txt with n=$lastlevel+1 (from the userInfo file)
		
		
		
	?>
    </div>
    
	<script src="http://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/indexpagebuttons.js" type="text/javascript" charset="utf-8"></script>

  </body>
</html>
