<?php

//global $gunCount;
//global $gunCount = 'unknown';
$gunCount = 'unknown';

date_default_timezone_set ( "America/New_York" );

require_once( "common.inc.php" );
require_once( "Kaba.class.php" );
require_once( "Guns.class.php" );

if ( isset( $_POST["action"] ) and $_POST["action"] == "search" ) {
	processForm();
}


function processForm() {
	global  $gunCount;
	
	//	echo "processForm... ";
	$requiredFields = array( "handle", "gshandle" );
	$missingFields = array();
	$errorMessages = array();

	$handle = '';
	$handleFound = false;
	$gshandle = '';

	if (isset( $_POST["handle"] )) {
		$handleFound = true;
		$handle = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["handle"] );
		//echo "Handle is " . $handle;
	} else {
		// TODO error handling
		
	}
	if (isset( $_POST["gshandle"] ) and $handleFound) {
		$gshandle = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["gshandle"] );
		//echo "Handle is " . $handle . " GS handle is " . $gshandle;
		$conn = connect();
              	// SELECT count(serialnumber) FROM guns g, kabas k, sergeants s WHERE g.memberid = k.memberid AND k.handle = 'fillythekid' AND k.sergeantid = s.memberid AND s.handle = 'mastersergeant';
              	
              	$sql = "SELECT count(serialnumber) FROM " . TBL_GUNS . " g, " . TBL_KABAS . " k, " . TBL_SERGEANTS . " s WHERE g.memberid = k.memberid AND k.handle = '$handle' AND k.sergeantid = s.memberid AND s.handle = '$gshandle'";
		//echo " sql is " . $sql;
              	
              	try {
              		$rows = array();
              		$st = $conn->prepare( $sql );
              		$st->execute();
              		//$row = $st->fetch();
					//echo "Result is " . $row;
					/*
					foreach ( $st->fetchAll() as $row ) {
						//echo "Result is " . $row;
						rows[] = $row;
					}*/	
              		/*				              		
             		$rows = $st->fetchAll();
              		disconnect( $conn );
              		$sizeOfRows = sizeof($rows);
              		echo " sizeOfRows " . $sizeOfRows;
              			foreach ( $rows as $row ) {
              				echo "Result is " . $row;
              			}
              			*/
              		$row = $st->fetch();
              		//echo "Result is " . $row["serialnumber"];
              		//echo "Result is " . $row["count"];
              		$count = $row["count"];
		//echo "The Gun Owner with Handle " . $handle . " who has a Gunnery Sergeant with handle of " . $gshandle . " has enlisted and reported possesion of " . $count . " guns...";
		//$result = "The Gun Owner with Handle " . $handle . " who has a Gunnery Sergeant with handle of " . $gshandle . " has enlisted and reported possesion of " . $count . " guns...";
		$gunCount = $handle . " (who has a Gunnery Sergeant with handle of " . $gshandle . ") has enlisted and reported possesion of " . $count . " guns...";
		//echo $gunCount;
		//showResult();
		// e.g. show result...unknownshown result...
              	} catch ( PDOException $e ) {
              		disconnect( $conn );
              		die( "Query failed: " . $e->getMessage() );
              	}
	} else {
		// TODO error handling
	}

}

function connect() {
    try {
    	// tjs 130719 - conversion to postgreSQL
      $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
    	//$conn = new PDO( DB_DSN, DB_HOST, DB_USERNAME, DB_PASSWORD );
      $conn->setAttribute( PDO::ATTR_PERSISTENT, true );
      $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
      // tjs 140209
      $conn->setAttribute( PDO::ATTR_TIMEOUT, 30);
    } catch ( PDOException $e ) {
      die( "Connection failed: " . $e->getMessage() );
    }

    return $conn;
  }

function disconnect( $conn ) {
    $conn = "";
  }

  function showResult() {
  	global  $gunCount;
  	//echo "show result...";
  	echo $gunCount;
  	//echo "shown result...";
  }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>gunnerySergeant.org</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="viewport"
	content="width=device-width, initial-scale=1, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="gunnerysergeant">
<meta name="mobile-web-app-capable" content="yes">
<link rel="mask-icon" href="/owl.svg" color="#990000">
<link href="/favicon.ico" rel="icon" type="image/x-icon" />
<link rel="apple-touch-icon-precomposed" sizes="152x152"
	href="assets/images/icons/favicon52x152.png">
<link rel="apple-touch-icon-precomposed" sizes="120x120"
	href="assets/images/icons/favicon20x120.png">
<link rel="apple-touch-icon-precomposed" sizes="76x76"
	href="assets/images/icons/favicon76x76.png">
<link rel="apple-touch-icon-precomposed"
	href="assets/images/icons/favicon57x57.png">
<link rel="shortcut icon"
	href="assets/images/icons/apple-touch-icon.png">
<link rel="shortcut icon" sizes="128x128"
	href="assets/images/icons/icon-128x128.png">
<link rel="shortcut icon" sizes="57x57"
	href="assets/images/icons/icon-57x57.png">
<link rel="stylesheet" href="assets/style/style.css">
<link rel="stylesheet" href="assets/style/w3.css" />
<link rel="stylesheet" href="assets/style/w3-theme-khaki.css">
<link href="assets/style/common.css" rel="stylesheet" />
<link href="assets/style/phone.css" rel="stylesheet" media="screen" />
<link href="assets/style//tablet.css" rel="stylesheet"
	media="screen and (min-device-width: 380px)" />
<link href="assets/style/desktop.css" rel="stylesheet"
	media="screen and (min-device-width: 480px)" />
<script src="core/w3data.js"></script>
<script src="core/jquery-2.1.0.js"></script>
<script src="core/underscore.js"></script>
<script src="core/tools.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet"
	href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<!-- jQuery library -->
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script
	src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script src="core/controller.js"></script>
</head>

<!-- 3. Display the application -->
<body
	style="background: url(images/salmonFallsPotHoles1DPI72.jpg) no-repeat center fixed; background-size: cover;">
	<div class="w3-container w3-brown">
		<h1>&nbsp;&nbsp;Enlistment into the Gunnery Sergeant Organization!</h1>
	</div>
	<br />
	  <div class="w3-container w3-sand">
<p>The Gun Owner with handle&nbsp;<?php showResult() ?></p>	

</div>
	<p />
	<p />
	<footer class="w3-container w3-round w3-border w3-brown">
	<div class="w3-container w3-center">
		<a style="margin: 10px 0 10px 0"; class="w3-btn w3-round-large" href="./index.html"> <img
			border="0" alt="Home" src="assets/images/HomeSBC.jpg" width="100"
			height="30"> </a>
	</div>
	</footer>

</body>


</html>
