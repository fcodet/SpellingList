<?php
		//Download User Information
		//Stored in userInfo.json
		//Format as follows:
		//"fieldUserName: (string) "user"
		//"fieldLastLevel: (int) level //Last successful level
		//"fieldWordsSeen: (array) [ "word1", "word2" .....//the actual spelling of the word
		//"fieldDatesSeen: (array) [ ["d1w1/m1w1/y1w1", "d2w1/m2w1/y2w1", ...] ["d1w2/m1w2/y1w2", "d2w2/m2w2/y2w2", ...]//the dates the words were asked
		//"fieldRanksSeen: (array) [ [rankw1_1, rankw1_2, ...] [rankw2_1, rankw2_2, ...] // list of ranks = double(0.00=didn't know -> 1.00=correct result) ]
		
		define("USERNAME_FIELD", "fieldUserName");
		define("LASTLEVEL_FIELD", "fieldLastLevel");
		define("WORDSSEEN_FIELD", "fieldWordsSeen");
		define("DATESSEEN_FIELD", "fieldDatesSeen");
		define("RANKSSEEN_FIELD", "fieldRanksSeen");
		//JSON Format file containing userInfo will be something like  "./userdata/fredInfo.json"
		$userJSONFileName = "./userdata/".$user."Info.json";
		if (!file_exists($userJSONFileName)) {
			//New user, let's create a new profile
			$userInfoArray = array ( "fieldUserName" => $user,
						"fieldLastLevel" => 0,
						"fieldWordsSeen" => array(),
						"fieldDatesSeen" => array(),
						"fieldRanksSeen" => array() );
			$fp = fopen($userJSONFileName, 'w');
			fwrite($fp, json_encode($userInfoArray ));
			fclose($fp);

			
		}
		$data = file_get_contents($userJSONFileName);
		$out = json_decode($data,true);
		if (DEV_ENV=="DEV") {ChromePhp::log($out);}
		//Assign Values to the userInfo PHP variables
		$userName = $out[USERNAME_FIELD];
		$lastLevel = $out[LASTLEVEL_FIELD];
		$wordsSeen = $out[WORDSSEEN_FIELD];
		$datesSeen = $out[DATESSEEN_FIELD];
		$ranksSeen = $out[RANKSSEEN_FIELD];
		
		
		//Let's check that all user data fields have been found.
		$userInfoComplete = ((isset($userName)) AND (isset($lastLevel)) AND (isset($wordsSeen)) AND (isset($datesSeen)) AND (isset($ranksSeen)));
		if ($userInfoComplete) {
			if (DEV_ENV=="DEV") {ChromePhp::log(USERNAME_FIELD." : ".$userName);}
			if (DEV_ENV=="DEV") {ChromePhp::log(LASTLEVEL_FIELD." : ".$lastLevel);}
			if (DEV_ENV=="DEV") {ChromePhp::log(WORDSSEEN_FIELD." : ".json_encode($wordsSeen));}
			if (DEV_ENV=="DEV") {ChromePhp::log(DATESSEEN_FIELD." : ".json_encode($datesSeen));}
			if (DEV_ENV=="DEV") {ChromePhp::log(RANKSSEEN_FIELD." : ".json_encode($ranksSeen));}
			
			//Download User's current Level information
			//The current level file to download will be level'n'SpellingList.json with 'n'=$lastLevel+1 (from the userInfo file)
			$currentLevel = (string)(((int)$lastLevel)+1);
			if (DEV_ENV=="DEV") {ChromePhp::log("Current level: ".$currentLevel);}
			define("LISTNAME_FIELD", "fieldSpellingListName");  	//Name of the Spelling List
			define("LISTTYPE_FIELD", "fieldSpellingListType");  	//What type of list is the list, single words to spell (value = "SINGLE"), 
														// or is it a relationship between two words (value ="COUPLE") a single to plural ("mouse / mice"), verb to name ("find / finder") 
			define("LISTCOMMENT_FIELD", "fieldSpellingListComment"); //Any general comments about the theme of the list of the spelling rules that might apply
			define("WORDLIST_FIELD", "fieldWordsList");			//The actual list of the words that will be used (whose corresponding file is contained in word.json
			define("WORDLIST2_FIELD", "fieldWordsList2");		//A second list of words (applicable only is "fieldSpellingListType"="COUPLE"
		
			$levelJSONFileName = "./data/level".$currentLevel."SpellingList.json";
			$data = file_get_contents($levelJSONFileName);
			$out = json_decode($data,true);
			if (DEV_ENV=="DEV") {ChromePhp::log("JSON Data");}
			if (DEV_ENV=="DEV") {ChromePhp::log($out);}
			$listName = $out[LISTNAME_FIELD];
			$listType = $out[LISTTYPE_FIELD];
			$listComment = $out[LISTCOMMENT_FIELD];
			$currentWordList = $out[WORDLIST_FIELD];
			$currentWordList2 = $out[WORDLIST2_FIELD];
			if (DEV_ENV=="DEV") {ChromePhp::log($currentWordList);}
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
			if (DEV_ENV=="DEV") {ChromePhp::log("Current word:".$currentWordList[$i]);}
			$wordJSONFileName = "./data/".$currentWordList[$i].".json";
			if (DEV_ENV=="DEV") {ChromePhp::log("File is :".$wordJSONFileName);}
			if (DEV_ENV=="DEV") {ChromePhp::log("File size:".filesize($wordJSONFileName));}
			if (filesize($wordJSONFileName)!=0) {
				if (DEV_ENV=="DEV") {ChromePhp::log("Processing".$currentWordList[$i]);}
				$data = file_get_contents($wordJSONFileName);
				$out = json_decode($data,true);
				$spelling = $out[SPELLING_FIELD];
				$definition = $out[DEFINITION_FIELD];
				$sentence = $out[SENTENCE_FIELD];
			
			} 
			else {
				if (DEV_ENV=="DEV") {ChromePhp::log("Problem with file");}
				if (DEV_ENV=="DEV") {ChromePhp::log($data);}
				if (DEV_ENV=="DEV") {ChromePhp::log("Indeed!");}
				$spelling = $currentWordList[$i];
				$definition = "";
				$sentence = "";
			}
			array_push($wordSpellingList, $spelling);
			array_push($wordDefinitionList, $definition);
			array_push($wordSentenceList, $sentence);
		}
		
				
	?>