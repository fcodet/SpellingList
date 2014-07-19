$("#playArea").css("backgroundColor","lightyellow");

//This module designs the play Area of the spellingList App

//Select the words to be chosen for this seesion
//All new words will be included they are contained in the wordSpellingList array, assuming there are N words, 
// we will also include 0.25xN words that have already been seen (in the wordsSeen array) by prioritising those with the lowest rank (ranksSeen array).
// we will also include 0.10xN words that have already been seen (in the wordsSeen array) by prioritising those with the highest rank and oldest review date(ranksSeen, datesSeen arrays).

//Create an ordered array with the lowest ranked words in wordsSeen (from lowest rank to highest rank)
//Reminder of available java arrays:
// -wordsSeen
// -ranksSeen
// -datesSeen
currentWordIdx = parseInt(currentWordIdx);
numberWordsSeen = wordsSeen.length
numberRanksSeen = ranksSeen.length
numberDatesSeen = datesSeen.length
if (currentWordIdx === 0) {
	playwordsList =[] ;  //this is the list which we will use for this session

	if ((numberWordsSeen != numberRanksSeen) | (numberWordsSeen != numberDatesSeen)) {
		//Problems with wordsSeen data, it seems to be out of sync - in this case ignore add just concentrate on the new words
		}
	else {
		//create an array for the average rank for each word in the  wordsSeen array
		// result will be array avRank = [ [1,rank1], [2,rank2], ....]
		avRank = []
		for (i=0;i<ranksSeen.length;i++) {
			wordRankings = ranksSeen[i];
			sum = 0;
			for (j=0;j<wordRankings.length;j++) {
				sum = sum+wordRankings[j];
			}
			if (wordRankings.length>0) {
				av = sum / wordRankings.length
				word = wordsSeen[i]
				wordRankItem = [word,av];
				avRank.push(wordRankItem);
			}
		}
		//Sort the avRank array from lowest to highest rank - and create the associated sortedWordsSeenList
		avRank.sort(function(a,b) {return a[1]-b[1]});
		sortedWordsSeen =[]
		for (i=0;i<avRank.length;i++) {
				sortedWordsSeen.push(avRank[i][0])
		}
		
		//if we have N new words to be learnt and S the number of the words already seen then  add min(0.25xN,S)
		numlowRankWords = 0.25*wordSpellingList.length
		numlowRankWords = Math.min( numlowRankWords,wordsSeen.length)
		
		playWordList = sortedWordsSeen.slice(0,numlowRankWords);
	}


	playWordList = playWordList.concat(wordSpellingList);

	N = playWordList.length;
	wordsLeft = true;
	rndPlayWordList = []
	console.log(playWordList)
	while (N != 0) {
			console.log("length of playword List : " + playWordList.length);
			if (N!=0) {
			rndIndex = Math.round((N-1)*Math.random());}
			else {
			rndIndex=0;}
			if (playWordList[rndIndex]==undefined) {
				console.log("word undefined at index : " + rndIndex);}
				
			rndPlayWordList.push(playWordList[rndIndex]);
			playWordList.splice(rndIndex, 1);
			console.log(rndPlayWordList);
			N = N-1;
	}
	
	

}




function CreateInputArea() {
	if (currentWordIdx != 0) {
		for (i=0;i<rndPlayWordList.length;i++) {
				$("#"+rndPlayWordList[i]+"Perf").remove();
				console.log("Removing "+"#"+rndPlayWordList[i]+'Perf')
		}
	}
	
	performanceHtml = '';
	for (i=0;i<rndPlayWordList.length;i++) {
		offsetStr = String ( 10 * i + 5);
		imgSrc = "img/blank10by10px.png"
		
		if ($("#"+rndPlayWordList[i]+"Form").hasClass("firstTimeCorrect")) {
			imgSrc = "img/verylonggreen10by10px.png"
		}
		if ($("#"+rndPlayWordList[i]+"Form").hasClass("secondTimeCorrect")) {
			imgSrc = "img/longlight-green10by10px.png"
		}
		if ($("#"+rndPlayWordList[i]+"Form").hasClass("thirdTimeCorrect")) {
			imgSrc = "img/mediumorange10by10px.png"
		}
		if ($("#"+rndPlayWordList[i]+"Form").hasClass("thirdTimeWrong")) {
			imgSrc = "img/red10by10px.png"
		}
		
		performanceHtml = performanceHtml + 
		'<img id='+rndPlayWordList[i]+'Perf src="'+imgSrc+'" style="position:relative;left:+'+offsetStr+'px;top:-10px">'
	}
	
	
	htmlPressToHearWord = '<span id='+rndPlayWordList[currentWordIdx]+'Span style="display:inline-block;height:40px;position:relative;top:-10px">Press to hear word:</span>'
	htmlPressToHearWord = htmlPressToHearWord + '<button id="'+rndPlayWordList[currentWordIdx]+'Button" type="button" style="margin:15px;marginTop:10px;background:white;height:40px;width:40px;background-size:100%;background-image:url(http://localhost/img/ear.png)"></button>'

	htmlInputForm = '<form id='+rndPlayWordList[currentWordIdx]+'Form class="noGuessYet" style="display:inline-block;position:relative;top:-10px;margin-left:30px">Please type in the word:<input id="'+rndPlayWordList[currentWordIdx]+'Input" style="margin-left:10px;width:200px" autocomplete="off" type="text" name="'+rndPlayWordList[currentWordIdx]+'"></form>'
	$pressToHearTag = $("#playArea").append(htmlPressToHearWord);
	$pressToHearTag.append(htmlInputForm);
	$pressToHearTag.append(performanceHtml);
	console.log("square append:"+performanceHtml);
	//$pressToHearTag.append('<br id='+rndPlayWordList[currentWordIdx]+'Br></br>');

	buttonIdTagStr = '#'+rndPlayWordList[currentWordIdx]+"Button";
	$buttonIdTag = $(buttonIdTagStr);
	$buttonIdTag.click(function () {
					playItem = new Audio('/data/'+$(this).attr("id").replace("Button","")+'.mp3').play()
					console.log(rndPlayWordList[currentWordIdx]);
					});
					
	inputTagStr = "#"+rndPlayWordList[currentWordIdx]+"Input";
	console.log('input tag:' + inputTagStr);
	$(inputTagStr).mouseover( function () {$(this).css("backgroundColor","lightyellow");});
	$(inputTagStr).mouseout( function () { $(this).css("backgroundColor","white");});
	formTagStr = "#"+rndPlayWordList[currentWordIdx]+"Form";

	$(inputTagStr).keypress( function (event) { 
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
	$(inputTagStr).focus( function () { 
						$guessWordFormTag = $("#"+$(this).attr("name")+"Form");
						if ($guessWordFormTag.hasClass("unlocked")) {
							console.log('/data/'+$(this).attr("id").replace("Input","")+'.mp3')
							playItem = new Audio('/data/'+$(this).attr("id").replace("Input","")+'.mp3').play()
							console.log(rndPlayWordList[currentWordIdx]);
						}
					});
	$guessWordFormTag = $("#"+rndPlayWordList[currentWordIdx]+"Form");
	$guessWordFormTag.addClass("unlocked");
}

CreateInputArea()

function processGuess ($guessWordTag) {
	//Once a guess is submitted lock it in and select a different backgroundColor
	$guessWordTag.css("backgroundColor","lightblue");
	$guessWordTag.attr("readonly","readonly");
	//Assign a locked status and remove unlocked status to parent tr
	guessWordFormStr = "#"+$guessWordTag.attr("name")+"Form"
	$guessWordForm = $(guessWordFormStr);
	$guessWordForm.removeClass("unlocked");
	$guessWordForm.addClass("locked");
	
	//correctResponseHtml = '<div style="font-size:14;color:green" id="'+$guessWordTag.attr("name")+'correctDiv">Correct!</div>';
	incorrectResponseId = $guessWordTag.attr("name")+'incorrectDiv'
	incorrectResponseHtml = '<a href=# style="font-size:12;color:red" id="'+incorrectResponseId+'">Sorry! Shall we try again!</a>';
	
	if ($guessWordTag.val() == $guessWordTag.attr("name")) {
		$guessWordFormTag.addClass("correct");
		if ($guessWordFormTag.hasClass("noGuessYet")) {
			$guessWordFormTag.removeClass("noGuessYet");
			$guessWordFormTag.addClass("firstTimeCorrect");
			
		}
		if ($guessWordFormTag.hasClass("firstTimeWrong")) {
			$guessWordFormTag.removeClass("firstTimeWrong");
			$guessWordFormTag.addClass("secondTimeCorrect");
			
		}
		if ($guessWordFormTag.hasClass("secondTimeWrong")) {
			$guessWordFormTag.removeClass("secondTimeWrong");
			$guessWordFormTag.addClass("thirdTimeCorrect");
			
		}
		
		if ($guessWordFormTag.addClass("correct")) {TryNextWord() }
		
	}

	else {
		
		if ($guessWordFormTag.hasClass("secondTimeWrong")) {
			$guessWordFormTag.removeClass("secondTimeWrong");
			$guessWordFormTag.addClass("thirdTimeWrong");
			TryNextWord()
			}
		else {
			if ($guessWordFormTag.hasClass("firstTimeWrong")) {
				
				$guessWordFormTag.addClass("secondTimeWrong");
				}
			if ($guessWordFormTag.hasClass("noGuessYet")) {
				$guessWordFormTag.removeClass("noGuessYet");
				$guessWordFormTag.addClass("firstTimeWrong");
				}
			
		
			console.log(incorrectResponseHtml);
			$guessWordTag.css("backgroundColor","FF950D");
			$guessWordTag.mouseover( function () { $(this).css("backgroundColor","xFF950D");} );
			$guessWordTag.mouseout( function () { $(this).css("backgroundColor","FF950D");} );
			$guessWordTag.after(incorrectResponseHtml);
			$("#"+incorrectResponseId).click(function(){
					$guessWordTag = $("#"+($(this).attr("id")).replace("incorrectDiv","")+"Input");
					console.log("the id is : "+$guessWordTag.attr("name"));
					$guessWordFormTag = $("#"+$guessWordTag.attr("name")+"Form");
					console.log("the tr id is : "+$guessWordTag.attr("name"));
					$guessWordTag.removeAttr("readonly");
					$guessWordTag.css("backgroundColor","lightyellow");
					console.log("set tr class to unlocked"+$guessWordFormTag.attr("id"));
					$guessWordFormTag.removeClass("locked");
					$guessWordFormTag.addClass("unlocked");
					$guessWordTag.focus();
					$guessWordTag.css("backgroundColor","lightyellow");
					$guessWordTag.mouseover( function () { $(this).css("backgroundColor","lightyellow");} );
					$guessWordTag.mouseout( function () { $(this).css("backgroundColor","lightyellow");} );
					$(this).remove();
			
			});
		}
	}
	
	
	
}

function TryNextWord() {
	if (currentWordIdx<rndPlayWordList.length) {
		$("#"+rndPlayWordList[currentWordIdx]+"Span").hide()
		$("#"+rndPlayWordList[currentWordIdx]+"Button").hide()
		$("#"+rndPlayWordList[currentWordIdx]+"Form").hide()
		$("#"+rndPlayWordList[currentWordIdx]+"Input").hide()
		$("#"+rndPlayWordList[currentWordIdx]+"Br").hide()
		prevCurrentWordIdx = currentWordIdx
		currentWordIdx = currentWordIdx + 1
		CreateInputArea()
		console.log("focus on "+rndPlayWordList[currentWordIdx]+"Input");
		$("#"+rndPlayWordList[currentWordIdx]+"Input").focus();
		}
	else {
		//TO DO we've gone through all the words
		//Display summary
		//Move to next level, pratice/review unknown words, that's enough for today...
	}
		
}


				
