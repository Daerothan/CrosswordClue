<?php
// connect to the database
require_once('dbconnect.php');
// start session to get clue details
session_start();
?>
<!-- include google analytics file -->
<?php include_once("analyticstracking.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="utf-8">
     <title>Clue of the day</title>
     <link rel="stylesheet" href="css/bootstrap.css">
	 <link rel="stylesheet" href="css/stylesheet.css">
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">  
</head>
<body>
    <header>
		<div id="head">
			<a href="http://www.napier.ac.uk/"><img class="titleright" src="images/napierLogo.jpg" alt="Edinburgh Napier University Logo"/></a>
		</div>
	</header>
	<nav class="navbar navbar-default" role="navigation">
		<div class="mynav">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>                   
			</button>
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">Clue of the Day</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav">
						<li><a href="index.php">Home</a></li>
						<li><a href="calendar.php">Calendar</a></li>
						<li><a href="about.html">About us</a></li>
					</ul>
				</div>
			</div>
	  </div>   
    </nav>	
  <div class="container clueCon introtxt">
	 <div class="row">
	     <div class="col-md-3 col-sm-3">
	     </div>
	 <div class="col-md-6 col-sm-6 col-xs-12">
          <h1> Welcome</h1>
              <p> Try and answer the daily cryptic clue below. The clue of the day is machine 
			      generated using a language algorithm. After three attempts you have the option 
			      of a hint button. Return each day for a new clue.
			  </p>
     </div>
	     <div class="col-md-3 col-sm-3">
	     </div>
	 </div>
  </div>
  <br>	
  <div class="container clueCon">
     <div class="row">  
	      <div class="col-md-3 col-sm-3">
	      </div>
	      <div class="col-md-6 col-sm-6">
	          <div id="clueback">
	             <br>
	             <div class="row">	        
                     <div class="col-md-2">	
                     </div>
                     <div class="col-md-4 col-xs-6 clueCenter">	            
                         <div class="icon-date">                  
                             <h3><?php echo date("M",strtotime($_SESSION['clueDate'])); ?></h3>                  
                             <h4><?php echo date("d",strtotime($_SESSION['clueDate'])); ?></h4> 
                         </div>
	                 </div>
	                 <div class="col-md-4 col-xs-6 clueCenter">		    			  
	                     <h4>Difficulty</h4>
						 <!-- difficulty rating. Uses string repeat. Multiplier for solid stars is dificulty rating -->
						 <!-- Multiplier for empty stars is  $multiplier 5 - difficulty rating from Session -->
						 <?php $multiplier = 5 - $_SESSION['difficulty'] ?> 
	                     <?php echo str_repeat('<span class="glyphicon glyphicon-star"></span> ',$_SESSION['difficulty']); ?>
				         <?php echo str_repeat('<span class="glyphicon glyphicon-star-empty"></span> ',$multiplier); ?>	            
	                 </div>
			         <div class="col-md-2">	
                     </div>
	              </div>
		          <br>
	              <div class="row">	   
	                  <div class="col-md-12 col-xs-12 clueCenter">
	                      <h4><?php echo $_SESSION['clueText']; ?></h4>
			              <span id="hint"><b>Hint:</b> <?php echo $_SESSION['clueHint']; ?></span>
	                  </div>
	              </div>
	             <div class="row">
	                 <div class="col-md-3">
		             </div>
	                 <div class="col-md-6 col-xs-12">
	                     <form class="clueForm">
                             <input type="text" id="answerinput" class="form-control" placeholder="Enter answer here..." required autofocus>
                             <br>
					         <div id="answertest"></div>				  					  
					         <br>
                             <button class="btn btn-primary btn-block" id="guess">Guess</button>
                         </form>
	                     <br>
	                 </div>
		             <div class="col-md-3">
		             </div>
	             </div>
	          </div>
	     </div>
	     <div class="col-md-3 col-sm-3">
	     </div>
		 </div>
		 <br>
	     <div class="row">
	         <div class="col-md-3 col-sm-3">
	         </div>
	         <div class="col-md-3 col-sm-3 col-xs-6 clueCenter">
	             <h4>Attempts: <span class="badge badge-default" id="numattempts">0</span></h4>
	         </div>
	         <div class="col-md-3 col-sm-3 col-xs-6 clueCenter">
	             <button type="submit" id="hintBut" class="btn btn-primary" onclick="javascript:showSpan();"><span class="glyphicon glyphicon-search"></span> Hint</button>
	         </div>
		     <div class="col-md-3 col-sm-3">
	         </div>  
	     </div>
  </div>
<script src="js/scriptspast.js"></script>   
</body>
</html>
