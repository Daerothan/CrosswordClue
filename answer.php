<?php  
//connect to database and check answer
include('dbconnect.php');  
$currentDate = date('Y/m/d');
$answerinput = ($_POST['answer_text']);  
$result = $db->query("select clueAnswer from crypticClue WHERE clueAnswer = '$answerinput' AND clueDate = '". $currentDate ."'");
//if correct return right else return wrong
if (mysqli_num_rows($result) > 0)
{	
echo "<p id='right'>Right</P>";
}  
	else
	{
	echo "<p id='wrong'>Wrong</P>";		
	}
    //close connection  
	mysqli_close($db);
?> 
