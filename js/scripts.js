//Main function
var counter = 0; //variable to hold number of attempts.
	$('.clueForm').on('click','#guess',function(){
	   counter++;
       $('#numattempts').text(counter);	   
       var answer = $("#answerinput").val();
       var answerdata = "answer_text=" + answer; 	   
       $.ajax({ //Process the form using $.ajax().
            type      : 'POST', 
			dataType  : 'text',
            url       : 'answer.php',
            data      : answerdata, //Forms name.
		    success   : function(data){
	   //array to hold wrong answer text.
       var textArraywrong = [
	   'Wrong Answer!',
	   'Try Again!',
	   'Not This Time!',
	   'It\'s a tricky one!',
	   'Not Even Close!',
	   'Incorrect!',
	   'Give it another try!'
	   ];
	   //array to hold right answer text.
	   var textArrayright = [
	   'Way to go!',
	   'Correct!',
	   'Good job!',
	   'Well done!',
	   'Keep up the good work!',
	   'You have done well.',
	   'Clue master!'
	   ];
       //variables to generate a random number based on array lenght and select and store in a variable	   
	   var randomNumber = Math.floor(Math.random()*textArraywrong.length);
	   var wronganswer = (textArraywrong[randomNumber]);
	   var rightanswer = (textArrayright[randomNumber]);
	   //if attampts are less than 3 and if correct say correct and no. attempts. Also unfocus and prohibit selection of inputs if right.
	   if (counter <= 2){	
	     if (jQuery.trim(data) === "<p id='right'>Right</P>") {
		 $("#answertest" ).html("<p id='right'> <span class='glyphicon glyphicon-ok'></span> "+ rightanswer +"</P>");
		 $("#answertest" ).append('you got it in ' +counter+ ' attempt(s).');
		 $("#guess").addClass("disableClickbtn");
		 $("#answerinput").addClass("disableClick");
		 $("#answerinput").blur();
		 $('#answerinput').on("keypress", "form", function(event) { //stops user submitting using enter key.
        return event.keyCode != 13;
        });
      }
	  //if attempts less than 3 and if wrong then sya incorrect.
	     if (jQuery.trim(data) === "<p id='wrong'>Wrong</P>") {
		 $("#answertest" ).html("<p id='wrong'> <span class='glyphicon glyphicon-remove'></span> "+ wronganswer +"</P>");
	  }		
	  }
      //else if attampts are > than 3 show hint and if correct say correct and no. attempts. Also unfocus and prohibit selection of inputs if right.	  
	  else if (counter >= 3) {
	  $("#hintBut" ).show();
	  $("#answertest" ).html('you have had ' +counter+ '  unsuccessful attempts. Try the hint button.');
	  if (jQuery.trim(data) === "<p id='right'>Right</P>") {
	  $("#answertest" ).html("<p id='right'><span class='glyphicon glyphicon-ok'></span> "+ rightanswer +"</P>");
	  $("#answertest" ).append('Well done! You got it. It took you ' +counter+ ' attempt(s)');
	  $("#guess").addClass("disableClickbtn");
      $("#answerinput").addClass("disableClick");
	  $("#answerinput").blur();
      $('#answerinput').on("keypress", "form", function(event) { //stops user submitting using enter key.
        return event.keyCode != 13;
        });	  
	  }
	  //if wrong say incorrect and suggest the hint.
	  if (jQuery.trim(data) === "<p id='wrong'>Wrong</P>") {
	  $("#answertest" ).html("<p id='wrong'> <span class='glyphicon glyphicon-remove'></span> "+ wronganswer +"</P>");	  
	  $("#answertest" ).append('Having trouble? Try the hint.');
	 }
     }
	 }	
        });
     return false;
     });
	
//Show hint
$("#hintBut").click(function(){
    $("#hint").show();
});


	