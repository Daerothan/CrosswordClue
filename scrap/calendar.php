<?php
include_once('CalendarFunctions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="utf-8">
     <title>Clue of the day</title>
     <link rel="stylesheet" href="css/bootstrap.css">
	 <link rel="stylesheet" href="css/stylesheet.css">
	 <link type="text/css" rel="stylesheet" href="css/calendarstyle.css"/>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	 <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">  
</head>
<body>
	<div id="wrap">
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
                 <li><a href="index.php">Home</a>
                 </li>
                 <li><a href="calendar.php">Calendar</a>
                 </li>
                 <li><a href="about.html">About us</a>
                 </li>
            </ul>
        </div>
      </div>
	  </div>   
  </nav>
  <div class="container clueCon introtxt">
       <br>
	   <br>
	   <div class="row">
	        <div class="col-md-2">
	        </div>
	        <div class="col-md-8 col-sm-12 text-center">
                <p id="calDescription"> Select a date using the calendar below to access previous cryptic clues.</p>
            </div>
	        <div class="col-md-2">
	        </div>
	   </div>
  </div>			
  <div class="container clueCon">
	    <div class="row">
	         <div class="col-md-2">
	          </div>
	         <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" id="calendar_div">
                <?php echo getCalender(); ?>
             </div>
	         <div class="col-md-2">
	         </div>
	     </div>
  </div>	
	<br>
	<br>
  </body>
</html>