function letsStart() {
	//Make the greeting messages disappear
	$greetingArea = $("#greetingArea");
	$greetingArea.remove();

	//Insert each word, Sound File, Definition and example sentences in the the word table just after the headings tag #wordTableHeadings
	htmlString = '<table id="wordTable" border="1">'
	htmlString = htmlString + '<tr id="wordTableHeadings"><th id="wordHeading" style="width:150px">Word</th><th style="width:150px">Sounds like</th><th style="width:300px">Definition</th><th style="width:200px">Example</th></tr>';
	for (i=0;i<wordSpellingList.length;i++) {
		//read the JSON file corresponding to the current word in the currentWordList
		//JSON Format file containing userInfo will be something like  "./data/word??.json"
		htmlString = htmlString + '<tr id="'+wordSpellingList[i]+'Tr">';
		htmlString = htmlString + '<td id='+wordSpellingList[i]+'Td><div id="'+wordSpellingList[i]+'Div" style="padding:10px;text-align:center">';
		htmlString = htmlString + wordSpellingList[i];
		htmlString = htmlString + "</div></td>";
		htmlString = htmlString + "<td>";
		htmlString = htmlString + '<audio id="'+wordSpellingList[i]+'AudioArea" controls > <source src=http://localhost/data/' + currentWordList[i] + '.mp3 type="audio/mpeg" ></audio>';
		//htmlString = htmlString + '<audio id="audioArea" controls > <source src=http://www.oxforddictionaries.com/media/english/uk_pron/w/wal/walk_/walk__gb_1.mp3 type="audio/mpeg" ></audio>';
		//htmlString = htmlString + '<audio id="audioArea" controls > <source src=http://localhost/data/walk.mp3 type="audio/mpeg" ></audio>';
		htmlString = htmlString + "</td>";
		htmlString = htmlString + '<td  style="padding:10px">'+wordDefinitionList[i]+"</td>";
		htmlString = htmlString + '<td id='+wordSpellingList[i]+'Sentences style="padding:10px">'+wordSentenceList[i]+"</td>";
		htmlString = htmlString + "</tr>";
	}
	$("#wordTableArea").append(htmlString);
	htmlButton = '<button id="practiceButton" style="display:inline">Practice</button><br></br>';
	$("#wordTableArea").before(htmlButton);
	$("#practiceButton").click(practiceWords);
	$("#practiceButton").after('<div style="display:inline;float:right;font-size:30px"> LEVEL '+currentLevel.toString()+'</div>');

}

function practiceWords() {
	console.log("Practice");
	//Disable the Practice Button
	$("#practiceButton").attr("disabled","disabled");
	
	for (i=0;i<wordSpellingList.length;i++) {
		//Make Example sentences invisible which will contain the word and might help the learner....
		sentencesTag = $("#"+wordSpellingList[i]+"Sentences");
		sentencesTag.css("visibility","hidden");
		//Remove the existing word in the Word column and relace with text Input Box
		divTag="#"+wordSpellingList[i]+"Div";
		
		if ($(divTag).length != 0)  {
			$(divTag).remove();
			tdTag="#"+wordSpellingList[i]+"Td";
			inputHtml = '<form id='+wordSpellingList[i]+'Form><input id='+wordSpellingList[i]+'Input autocomplete="off" type="text" name="'+wordSpellingList[i]+'"></form>';
			$(tdTag).append(inputHtml);
			trTag="#"+wordSpellingList[i]+"Tr";
			$(trTag).addClass("unlocked");
		}
		
		inputTag = "#"+wordSpellingList[i]+"Input";
		$(inputTag).mouseover( function () {$(this).css("backgroundColor","lightyellow");});
		$(inputTag).mouseout( function () { $(this).css("backgroundColor","white");});
		formTag = "#"+wordSpellingList[i]+"Form";
		$(inputTag).keypress( function (event) { 
									if (event.keyCode == 13) { 
										console.log("submitted guess for "+$(this).attr("name"));
										event.preventDefault();
										console.log("Before process");
										if ($(this).parents().hasClass("unlocked")) { 
											console.log("Let's process");
											processGuess($(this));
											}
										}
									
								});
		$(inputTag).focus( function () { 
							wordAudioTag = "#"+$(this).attr("name")+"AudioArea";
							if ($(this).parents().hasClass("unlocked")) {
								console.log("FOCUS");
								$(wordAudioTag).get(0).play()}
								;
							});
		
		}
}

function PracticeOver (allGood){
	if (allGood) {
		console.log("Well practiced, shall we move on to the serious stuff?");
	}
	else {
		console.log("Are you sure you don't want to finish practicing?");
	}
}

function processGuess ($guessWordTag) {
	//Once a guess is submitted lock it in and select a different backgroundColor
	$guessWordTag.css("backgroundColor","lightblue");
	$guessWordTag.attr("readonly","readonly");
	//Assign a locked status and remove unlocked status to parent tr
	guessWordTrStr = "#"+$guessWordTag.attr("name")+"Tr"
	$guessWordTrTag = $(guessWordTrStr);
	$guessWordTrTag.removeClass("unlocked");
	$guessWordTrTag.addClass("locked");
	
	correctResponseHtml = '<div style="font-size:14;color:green" id="'+$guessWordTag.attr("name")+'correctDiv">Correct!</div>';
	incorrectResponseId = $guessWordTag.attr("name")+'incorrectDiv'
	incorrectResponseHtml = '<a href=# style="font-size:12;color:red" id="'+incorrectResponseId+'">Sorry! Shall we try again!</a>';
	
	if ($guessWordTag.val() == $guessWordTag.attr("name")) {
		$guessWordTrTag.addClass("correct");
		$guessWordTag.mouseover( function () { $(this).css("backgroundColor","lightblue");} );
		$guessWordTag.mouseout( function () { $(this).css("backgroundColor","lightblue");} );
		console.log(correctResponseHtml);
		$guessWordTag.after(correctResponseHtml);
		moveFocusToNextWord($guessWordTag);
		//Test if all practice words have been praticed correctly
		allCorrect = true;
		for (i=0;i<wordSpellingList.length;i++) {
			guessWordTrTag = $("#"+wordSpellingList[i]+"Tr");
			allCorrect = allCorrect & guessWordTrTag.hasClass("correct");
		}
		if (allCorrect) {
			PracticeOver(allCorrect);
		}
	}

	else {
		console.log(incorrectResponseHtml);
		$guessWordTag.css("backgroundColor","FF950D");
		$guessWordTag.mouseover( function () { $(this).css("backgroundColor","xFF950D");} );
		$guessWordTag.mouseout( function () { $(this).css("backgroundColor","FF950D");} );
		$guessWordTag.after(incorrectResponseHtml);
		$("#"+incorrectResponseId).click(function(){
				$guessWordTag = $("#"+($(this).attr("id")).replace("incorrectDiv","")+"Input");
				console.log("the id is : "+$guessWordTag.attr("name"));
				$guessWordTrTag = $("#"+$guessWordTag.attr("name")+"Tr");
				console.log("the tr id is : "+$guessWordTag.attr("name"));
				$guessWordTag.removeAttr("readonly");
				$guessWordTag.css("backgroundColor","lightyellow");
				console.log("set tr class to unlocked"+$guessWordTrTag.attr("id"));
				$guessWordTrTag.removeClass("locked");
				$guessWordTrTag.addClass("unlocked");
				$guessWordTag.focus();
				$guessWordTag.css("backgroundColor","lightyellow");
				$guessWordTag.mouseover( function () { $(this).css("backgroundColor","lightyellow");} );
				$guessWordTag.mouseout( function () { $(this).css("backgroundColor","lightyellow");} );
				$(this).remove();
		
		});
	}
	
	
	
}

function moveFocusToNextWord ($guessWordTag) {

	guessWordTrTagStr = "#"+$guessWordTag.attr("name")+"Tr";
	console.log("this trTag is: "+guessWordTrTagStr);
	guessWordNextTrStr = "#"+$guessWordTag.attr("name")+"Tr ~ tr.unlocked";
	$nexttr = $(guessWordNextTrStr);
	console.log($nexttr.attr("id"));
	$nextInputTag = $nexttr.first().find("input");
	console.log("TEST");
	console.log($nextInputTag);
	if ($nextInputTag.attr("name")!= undefined)
		{
		$nextInputTag.focus();
		guessWordNextAudioTagStr = "#"+$nextInputTag.attr("name")+"AudioArea"
		console.log(guessWordNextAudioTagStr);
		//$(guessWordNextAudioTag).attr("autoplay","autoplay");
		//$(guessWordNextAudioTag).removeAttr("autoplay","autoplay");
		$(guessWordNextAudioTagStr).get(0).play();
	}
	
	

	

}



//Once the start button is pressed
$("#startMessage").click(letsStart);



























	
  
  
  
