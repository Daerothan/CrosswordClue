<?php
//Start session to hold clue details
session_start();
//Function requested by Ajax
if(isset($_POST['func']) && !empty($_POST['func'])){
	switch($_POST['func']){
		case 'getCalender':
			getCalender($_POST['year'],$_POST['month']);
			break;
		case 'getEvents':
			getEvents($_POST['date']);
			break;
		default:
			break;
	}
}
//Get calendar full HTML
//bit below , clicking the button allows you to go back further or forwards further than intended
function getCalender($year = '',$month = '')
{
	$dateYear = ($year != '')?$year:date("Y");
	$dateMonth = ($month != '')?$month:date("m");
	$date = $dateYear.'-'.$dateMonth.'-01';
	$currentMonthFirstDay = date("N",strtotime($date));
	$totalDaysOfMonth = cal_days_in_month(CAL_GREGORIAN,$dateMonth,$dateYear);
	$totalDaysOfMonthDisplay = ($currentMonthFirstDay == 7)?($totalDaysOfMonth):($totalDaysOfMonth + $currentMonthFirstDay);
	$boxDisplay = ($totalDaysOfMonthDisplay <= 35)?35:42;
?>
	<div id="calender_section">
	  <div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10 col-sm-12 col-xs-12">
		<h2 id="calHeader">
        	<a class="prev" href="javascript:void(0);" onclick="getCalendar('calendar_div','<?php echo date("Y",strtotime($date.' - 1 Month')); ?>','<?php echo date("m",strtotime($date.' - 1 Month')); ?>');"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            <select name="month_dropdown" class="month_dropdown dropdown"><?php echo getAllMonths($dateMonth); ?></select>
			<select name="year_dropdown" class="year_dropdown dropdown"><?php echo getYearList($dateYear); ?></select>
            <a class="next" href="javascript:void(0);" onclick="getCalendar('calendar_div','<?php echo date("Y",strtotime($date.' + 1 Month')); ?>','<?php echo date("m",strtotime($date.' + 1 Month')); ?>');"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
        </h2>
		</div>
		<div class="col-md-1">
		</div>		
		</div>
		<div class="row">
		<div class="col-md-1">
		</div>
		<div id="event_list" class="col-md-10 none"></div>
		<div class="col-md-1">
		</div>
		</div>
		<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10 col-sm-12 col-xs-12">
		<div id="calender_section_top">
			<ul>
				<li>Sun</li>
				<li>Mon</li>
				<li>Tue</li>
				<li>Wed</li>
				<li>Thu</li>
				<li>Fri</li>
				<li>Sat</li>
			</ul>
		</div>
		</div>
		<div class="col-md-1">
		</div>
		</div>
		<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10 col-sm-12 col-xs-12">
		<div id="calender_section_bot">
			<ul> 			
			<?php 
				$dayCount = 1; 
				for($cb=1;$cb<=$boxDisplay;$cb++){
					if(($cb >= $currentMonthFirstDay+1 || $currentMonthFirstDay == 7) && $cb <= ($totalDaysOfMonthDisplay)){
						//Current date
						$currentDate = $dateYear.'-'.$dateMonth.'-'.$dayCount;
						$eventNum = 0;
						$calendarDateBox = $dayCount.'-'.$dateMonth.'-'.$dateYear;
						//Include db configuration file
						include 'dbconnect.php';
						//Get number of events based on the current date
						$result = $db->query("SELECT clueText FROM crypticClue WHERE clueDate = '".$currentDate."' AND status = 1");
						$eventNum = $result->num_rows;
						//Define date cell color
						switch (strtotime($currentDate)) {
                                    case strtotime($currentDate) == strtotime(date("Y-m-d")):
                                    echo '<li date="'.$currentDate.'" class="grey date_cell" onclick="getEvents(\''.$currentDate.'\');" ">';
                                    break;
                                    case strtotime($currentDate) <= strtotime(date("Y-m-d")) && $eventNum > 0  :
                                    echo '<li date="'.$currentDate.'" class="light_sky date_cell" onclick="getEvents(\''.$currentDate.'\');">';
                                    break;
                                    case strtotime($currentDate) > strtotime (date("Y-m-d")) :
                                    echo '<li date="'.$currentDate.'" class="date_cell blank">';
                                    break;
                                    default:
                                    echo '<li date="'.$currentDate.'" class="date_cell">';
                                    }
						$ratingBox = $db->query("SELECT difficulty FROM crypticClue WHERE clueDate = '".$currentDate."' AND status = 1");
						$countR = mysqli_num_rows($ratingBox);
						$output = '';
						if($countR == 0) {
			$output = '';
		} else {
			while($row = mysqli_fetch_array($ratingBox)){
				$rate = $row['difficulty'];				
				$output .= $rate;	
			}
		}		
						//Date cell
						echo '<span>';
						echo $dayCount;
						echo '<a href="javascript:;" onclick="getEvents(\''.$currentDate.'\');"></a>';
						echo '</span>';					
						$dayCount++;
			?>
			<?php }else{ ?>
				<li><span>&nbsp;</span></li>
			<?php } } ?>			
			</ul>
		</div>
		</div>
		<div class="col-md-1">
		</div>
	</div>
	<script type="text/javascript">
	//AJAX functions and Calendar dropdown Jquery
		function getCalendar(target_div,year,month){
			$.ajax({
				type:'POST',
				url:'CalendarFunctions.php',
				data:'func=getCalender&year='+year+'&month='+month,
				success:function(html){
					$('#'+target_div).html(html);
				}
			});
		}		
		function getEvents(date){
			$.ajax({
				type:'POST',
				url:'CalendarFunctions.php',
				data:'func=getEvents&date='+date,
				success:function(html){
					$('#event_list').html(html);
					$('#event_list').show("fast");
				}
			});
		}
				
		$(document).ready(function(){

			$('.month_dropdown').on('change',function(){
				getCalendar('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
			});
			$('.year_dropdown').on('change',function(){
				getCalendar('calendar_div',$('.year_dropdown').val(),$('.month_dropdown').val());
			});
			$(document).click(function(){
				$('#event_list').hide("fast");
			});
		});
	</script>
<?php
}
//Get months options list.
function getAllMonths($selected = ''){
	$options = '';
	
	$dateMonth = ($month != '')?$month:date("m");
	$startDate = $dateMonth - 3;
	for($i=$startDate;$i<=$dateMonth;$i++)
	{
		$value = ($i < 10)?'0'.$i:$i;
		$selectedOpt = ($value == $selected)?'selected':'';
		$options .= '<option value="'.$value.'" '.$selectedOpt.' >'.date("F", mktime(0, 0, 0, $i+1, 0, 0)).'</option>';
	}
	return $options;
}
//Get years options list.
function getYearList($selected = ''){
	$options = '';
	for($i=2017; $i<=2017; $i++) // Must change second value each year to access new clues 
	{
		$selectedOpt = ($i == $selected)?'selected':'';
		$options .= '<option value="'.$i.'" '.$selectedOpt.' >'.$i.'</option>';
	}
	return $options;
}

//Get events by date
function getEvents($date = ''){
	//Include db configuration file
	include 'dbconnect.php';
	$eventListHTML = '';
	$_SESSION['clueDate'] = $date?$date:date("Y-m-d");
	//Get events based on the current date
	$result = $db->query("SELECT clueText, difficulty, clueAnswer, clueHint FROM crypticClue WHERE clueDate = '".$date."' AND status = 1");
	
	if($result->num_rows > 0){
		$eventListHTML = '<h2>Clue on '.date("l, d M Y",strtotime($_SESSION['clueDate'])).'</h2>';
		$eventListHTML .= '<div class="row">';
		$eventListHTML .= '<hr>';
		$eventListHTML .= '<br>';
		$eventListHTML .= '<div class="col-md-12">';
		while($row = $result->fetch_assoc()){ 
		$eventListHTML .= '<div class="text-center"> <p>'.$row['clueText'].' </p></div>';
		$eventListHTML .= '</div>';
		$eventListHTML .= '</div>';
		$eventListHTML .= '<div class="row">';
		$eventListHTML .= '<div class="col-md-12 text-center">';
		$multiplier = 5 - $row['difficulty'];
        $eventListHTML .= '<p id="calDifficulty">Difficulty: ';
		$eventListHTML .= ''.str_repeat("<span class='glyphicon glyphicon-star'></span>",$row["difficulty"]).'';
		$eventListHTML .= ''.str_repeat("<span class='glyphicon glyphicon-star-empty'></span>",$multiplier).'';
		$eventListHTML .= '</p>';
		$eventListHTML .= '</div>';
		$eventListHTML .= '</div>';
		$eventListHTML .= '<div class="row">';
		$eventListHTML .= '<div class="col-md-12 text-center">';
		$eventListHTML .= '<div>';
		$eventListHTML .= '<a href="pastclues.php" class="btn btn-primary" id="" role="button">Go to clue</a>';
		$eventListHTML .= '</div>';	
        $eventListHTML .= '</div>';
		$eventListHTML .= '</div>';
        $eventListHTML .= '<br>';		
		$_SESSION['difficulty'] = $row['difficulty'];
		$_SESSION['clueText'] = $row['clueText'];
		$_SESSION['clueAnswer'] = $row['clueAnswer'];
		$_SESSION['clueHint'] = $row['clueHint'];
		$eventListHTML .= '</ul>';		
        }		
	}
	echo $eventListHTML;
}
?>