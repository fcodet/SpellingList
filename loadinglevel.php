<?php 
include('ChromePhp.php');
require_once("inc/config.php");

$pageTitle = "Loading Information";
$section = "home";
$user = $_GET['userName'];
include(ROOT_PATH . 'inc/header.php'); ?>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript" charset="utf-8"></script>
	<div id="wrapper">
      <section>
		<p><?php echo "Hello ".$user." !"?></p>
		<p>Loading your details...</p>
      </section>
     <?php
		//Download User Information
		//Stored in userInfo.json
		//Format as follows:
		//"fieldUserName: (string) "user"
		//"fieldLastLevel: (int) level //Last successful level
		//"fieldWordsSeen: (array) [ "word1", "word2" .....//the actual spelling of the word
		//"fieldDatesSeen: (array) [ "d1/m1/y1", "d2/m2/y2" .....//the dates the words were asked
		//"fieldRanksSeen: (array) [ rank1 , rank2" , rank3 ] // list of ranks = double(0.00=didn't know -> 1.00=correct result) ]
		$userFileName = "./userdata/".$user."Info.txt";
		define("USERNAME_FIELD", "fieldUserName");
		define("LASTLEVEL_FIELD", "fieldLastLevel");
		define("WORDSSEEN_FIELD", "fieldWordsSeen");
		define("DATESSEEN_FIELD", "fieldDatesSeen");
		define("RANKSSEEN_FIELD", "fieldRanksSeen");
		//JSON Format file containing userInfo will be something like  "./userdata/fredInfo.json"
		$userJSONFileName = "./userdata/".$user."Info.json";
		$data = file_get_contents($userJSONFileName);
		$out = json_decode($data,true);
		ChromePhp::log($out);
		//Assign Values to the userInfo PHP variables
		$userName = $out[USERNAME_FIELD];
		$lastLevel = $out[LASTLEVEL_FIELD];
		$wordsSeen = $out[WORDSSEEN_FIELD];
		$datesSeen = $out[DATESSEEN_FIELD];
		$ranksSeen = $out[RANKSSEEN_FIELD];
		
		
		//Let's check that all user data fields have been found.
		$userInfoComplete = ((isset($userName)) AND (isset($lastLevel)) AND (isset($wordsSeen)) AND (isset($datesSeen)) AND (isset($ranksSeen)));
		if ($userInfoComplete) {
			ChromePhp::log(USERNAME_FIELD." : ".$userName);
			ChromePhp::log(LASTLEVEL_FIELD." : ".$lastLevel);
			ChromePhp::log(WORDSSEEN_FIELD." : ".json_encode($wordsSeen));
			ChromePhp::log(DATESSEEN_FIELD." : ".json_encode($datesSeen));
			ChromePhp::log(RANKSSEEN_FIELD." : ".json_encode($ranksSeen));
			//Download User's current Level information
			//The current level file to download will be level'n'SpellingList.txt with 'n'=$lastLevel+1 (from the userInfo file)
			$currentlevel = (string)(((int)$lastLevel)+1);
			ChromePhp::log("Current level: ".$currentlevel);
			
			///////////////////////////////////////////////////////////////////////////////
			/*
			$levelFileName = "./data/level".$currentlevel."SpellingList.txt";
			ChromePhp::log("Level file name: ".$levelFileName);
			//We have the name of the file containing the new words for the current level being attempted
			$currentWordList = array(); //$currentWordList is an array that will hold the new words to be acquired to pass the level.
			$myFile=fopen($levelFileName,"r+") or die("Unable to open file");
			$numChar = strlen(file_get_contents($levelFileName));
			ChromePhp::log("The file has ".$numChar." chars");
			$charCount = 0;
			while(!feof($myFile)) {
				$readLine = fgets($myFile);
				$readWord = str_replace(array("\n", "\r"), '', $readLine); //remove new line and carriage return
				array_push($currentWordList, '"'.$readWord.'"');
				$charCount = $charCount + strlen($readLine);
				$progressNum = (double) (((int)$charCount)/((int)($numChar)));
				$progressNumStr = (string) (100 * $progressNum);
				ChromePhp::log($progressNumStr);
				}
			fclose($myFile);
			ChromePhp::log($currentWordList);
			ChromePhp::log("Total chars counted:" . $charCount);
			*/
			/////////////////////////////////////////////////////////////////////////////////////
			define("LISTNAME_FIELD", "fieldSpellingListName");
			define("WORDLIST_FIELD", "fieldWordsList");
		
			$levelJSONFileName = "./data/level".$currentlevel."SpellingList.json";
			$data = file_get_contents($levelJSONFileName);
			$out = json_decode($data,true);
			ChromePhp::log($out);
			$listName = $out[LISTNAME_FIELD];
			$currentWordList = $out[WORDLIST_FIELD];
			
			
			
			
			
		}
		else {
		//TODO Treat error - problem with userInfo.txt file information
		}
		
				
	?>
	<?php include(ROOT_PATH . 'inc/footer.php'); ?>  
	</div>
	
	<script type="text/javascript">
		var currentWordList = <?php echo json_encode($currentWordList); ?>;
		var userName = <?php echo '"'.$userName.'"' ?>;
		var lastLevel = <?php echo $lastLevel ?>;
		var wordsSeenList = <?php if ($wordsSeen !== '[]') {echo json_encode($wordsSeen);} else {echo '[]';} ?>;
		
		var strWordList = currentWordList.toString();
		console.log("java variable: "+ strWordList);
	</script>
	
	
     <script src="js/init.js" type="text/javascript" charset="utf-8"></script>
	
  </body>
</html>
