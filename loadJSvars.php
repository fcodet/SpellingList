<script type="text/javascript">
		// Assign all PHP variables in JS variables for later use on page (jQuery operations etc...)
		var dev_env = "<?php echo DEV_ENV; ?>";
		var currentWordList = <?php echo json_encode($currentWordList); ?>;
		var userName = <?php echo '"'.$userName.'"' ?>;
		var lastLevel = <?php echo $lastLevel ?>;
		var currentLevel = <?php echo $currentLevel ?>;
		var wordsSeen = <?php if ($wordsSeen !== '[]') {echo json_encode($wordsSeen);} else {echo '[]';} ?>;
		var datesSeen = <?php if ($datesSeen !== '[]') {echo json_encode($datesSeen);} else {echo '[]';} ?>;
		var ranksSeen = <?php if ($ranksSeen !== '[]') {echo json_encode($ranksSeen);} else {echo '[]';} ?>;
		var newWords = <?php echo json_encode($currentWordList); ?>;
		var wordSpellingList = <?php echo json_encode($wordSpellingList); ?>;
		var wordDefinitionList = <?php echo json_encode($wordDefinitionList); ?>;
		var wordSentenceList = <?php echo json_encode($wordSentenceList); ?>;
		var listName = <?php echo json_encode($listName); ?>;
		var listType = <?php echo json_encode($listType); ?>;
		
	</script>