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
     <?php
		//Download User Information
		//Stored in userInfo.json
		//Format as follows:
		//"fieldUserName: (string) "user"
		//"fieldLastLevel: (int) level //Last successful level
		//"fieldWordsSeen: (array) [ "word1", "word2" .....//the actual spelling of the word
		//"fieldDatesSeen: (array) [ "d1/m1/y1", "d2/m2/y2" .....//the dates the words were asked
		//"fieldRanksSeen: (array) [ rank1 , rank2" , rank3 ] // list of ranks = double(0.00=didn't know -> 1.00=correct result) ]
		//$userFileName = "./userdata/".$user."Info.txt";
		define("USERNAME_FIELD", "fieldUserName");
		define("LASTLEVEL_FIELD", "fieldLastLevel");
		define("WORDSSEEN_FIELD", "fieldWordsSeen");
		define("DATESSEEN_FIELD", "fieldDatesSeen");
		define("RANKSSEEN_FIELD", "fieldRanksSeen");
		//JSON Format file containing userInfo will be something like  "./userdata/fredInfo.json"
		$userJSONFileName = "./userdata/".$user."Info.json";
		if (!file_exists($userJSONFileName)) {
			//New user, let's create a new profile
			
		}
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
			//The current level file to download will be level'n'SpellingList.json with 'n'=$lastLevel+1 (from the userInfo file)
			$currentLevel = (string)(((int)$lastLevel)+1);
			ChromePhp::log("Current level: ".$currentLevel);
			define("LISTNAME_FIELD", "fieldSpellingListName");
			define("LISTCOMMENT_FIELD", "fieldSpellingListComment");
			define("WORDLIST_FIELD", "fieldWordsList");
		
			$levelJSONFileName = "./data/level".$currentLevel."SpellingList.json";
			$data = file_get_contents($levelJSONFileName);
			$out = json_decode($data,true);
			ChromePhp::log($out);
			$listName = $out[LISTNAME_FIELD];
			$listComment = $out[LISTCOMMENT_FIELD];
			$currentWordList = $out[WORDLIST_FIELD];
			ChromePhp::log($currentWordList);
		}
		else {
		//TODO Treat error - problem with userInfo.txt file information
		}
		
		//Now we have the details of the spelling list let's extract spelling, definitions, example sentences etc...
		//$wordSpellingList,$wordDefinitionList,$wordSentenceList will be PHP arrays containing this information
		//Use the JSON file for each word to get this data
		define("SPELLING_FIELD", "fieldSpelling");
		define("DEFINITION_FIELD", "fieldDefinition");
		define("SENTENCE_FIELD", "fieldSentence");
		$wordSpellingList = array();
		$wordDefinitionList = array();
		$wordSentenceList = array();
		for ($i=0;$i<count($currentWordList);$i++) {
			ChromePhp::log("Current word:".$currentWordList[$i]);
			$wordJSONFileName = "./data/".$currentWordList[$i].".json";
			$data = file_get_contents($wordJSONFileName);
			$out = json_decode($data,true);
			$spelling = $out[SPELLING_FIELD];
			$definition = $out[DEFINITION_FIELD];
			$sentence = $out[SENTENCE_FIELD];
			array_push($wordSpellingList, $spelling);
			array_push($wordDefinitionList, $definition);
			array_push($wordSentenceList, $sentence);
		}
		
				
	?>
	<?php include(ROOT_PATH . 'inc/footer.php'); ?>  
	</div>
	 
	<script type="text/javascript">
		// Assign all PHP variables in JS variables for later use on page (jQuery operations etc...)
		var currentWordList = <?php echo json_encode($currentWordList); ?>;
		var userName = <?php echo '"'.$userName.'"' ?>;
		var lastLevel = <?php echo $lastLevel ?>;
		var currentLevel = <?php echo $currentLevel ?>;
		var wordsSeen = <?php if ($wordsSeen !== '[]') {echo json_encode($wordsSeen);} else {echo '[]';} ?>;
		var newWords = <?php echo json_encode($currentWordList); ?>;
		var wordSpellingList = <?php echo json_encode($wordSpellingList); ?>;
		var wordDefinitionList = <?php echo json_encode($wordDefinitionList); ?>;
		var wordSentenceList = <?php echo json_encode($wordSentenceList); ?>;
		//console.log("wordSpellingList: "+ wordSpellingList);
	</script>
    <script src="js/init.js" type="text/javascript" charset="utf-8"></script>
    <script src="js/explore.js" type="text/javascript" charset="utf-8"></script>
	
  </body>
</html>
