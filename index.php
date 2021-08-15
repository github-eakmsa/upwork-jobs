<?php
session_start();

if(!isset($_SESSION['access_token'])) {
	header('Location: google-login.php');
	exit();	
}

require_once('google-calendar-api.php');
$capi = new GoogleCalendarApi();
?>
<!DOCTYPE html>
<html>
<head>
  <title>
    Google Calendar Client App
  </title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.1.9/jquery.datetimepicker.min.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.1.9/jquery.datetimepicker.min.js"></script>
</head>

<body>

<!--  app title -->
<div>
  <h1>Google Caldendar Events</h1>
</div>

<!-- add event btn -->
<div>
  <a href="add-event.php">Add Event</a>
</div>

<!-- list of calendar -->
<div>
<b>Calendar List</b>
<?php
$eventsList = $capi -> GetCalendarsList($_SESSION['access_token']);
if (!empty($eventsList)) {
  ?> 
  <ol>
  <?php
  foreach ($eventsList as $eventObj) {
  ?>
  <li><?php print_r($eventObj); ?></li>
  <?php
  }  
  ?> 
  </ol>
  <?php
} else {
  ?> 
  <p>no calendar found.</p>
  <?php
}
?>
</div>

<!-- list of events -->
<div>
<b>Events List</b>
<?php
$eventsList = $capi -> GetEventsList($_SESSION['access_token'], "primary");
if (!empty($eventsList)) {
  foreach ($eventsList as $eventObj) {
    if (is_array($eventObj) && sizeof($eventObj) >= 2) {
      ?> 
      <ol>
      <?php
      foreach ($eventObj as $eventObj2) {
        ?>
        <li>
          <?php 
      print_r($eventObj2['summary']); 
      ?>
    </li>
    <?php
    }
    ?> 
    </ol>
    <?php
  }
  }  
} else {
  ?> 
  <p>no event found.</p>
  <?php
}
?>
</div>


</body>
</html>