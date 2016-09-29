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
<script>
//var $collaboratorLogsInfo = null;
var collaboratorLogsInfo = new Array();

/*
 *   id serial NOT NULL,
 memberid integer NOT NULL,
 topicid integer NOT NULL,
 numattempts smallint NOT NULL,
 startaccess timestamp without time zone NOT NULL DEFAULT now(),
 log character varying(1028) NOT NULL,
 stopaccess
 */
function CollaboratorLogInfo(id, memberid, topicid, numattempts, startaccess, log, stopaccess, handle, phone, email, sponsorid, selected) {
	this.id = id;
	this.memberid = memberid;
	this.topicid = topicid;
	this.numattempts = numattempts;
	this.startaccess = startaccess;
	//this.isInactive = isInactive;
	this.startaccess = startaccess;
	this.log = log;
	this.stopaccess = stopaccess;
	this.handle = handle;
	if (phone == null) {
		this.phone = 'unknown';
	} else {
		this.phone = phone;
	}
	this.email = email;
	this.sponsorid = sponsorid;
	this.selected = selected;
}

function insertCollaboratorLogInfo(id, memberid, topicid, numattempts, startaccess, log, stopaccess, handle, phone, email, sponsorid, selected) {
	//console.log("inserting memberid " + memberid);
	logInfo = new CollaboratorLogInfo(id, memberid, topicid, numattempts, startaccess, log, stopaccess, handle, phone, email, sponsorid, selected);
	collaboratorLogsInfo.push(logInfo);
}

function selectColloboratorLogInfoByMember(memberid) {
	var len = collaboratorLogsInfo.length;
	var i = 0;
	//console.log("selectColloboratorLogInfoByMember len " + len);
	var selectedCollaboratorLogInfo = null;
	while (i < len) {
		var collaboratorLogInfo = collaboratorLogsInfo[i++];
		console.log("selectColloboratorLogInfoByMember memberid " + collaboratorLogInfo.memberid);
		if (collaboratorLogInfo.memberid == memberid) {
			collaboratorLogInfo.selected = true;
			selectedCollaboratorLogInfo = collaboratorLogInfo;
		} else {
			collaboratorLogInfo.selected = false;			
		}
	}
	return selectedCollaboratorLogInfo;
}

function displayFormContents(memberid) {
	
	//console.log("displayFormContents memberid " + memberid);
	var selectedCollaboratorLogInfo = selectColloboratorLogInfoByMember(memberid);
	//console.log("displayFormContents memberid " + selectedCollaboratorLogInfo.memberid);
	var html = '<input type="hidden" name="logid" id="logid"';
		html += ' value="' + selectedCollaboratorLogInfo.id + '" />';
		html += '<input type="hidden" name="topicid" id="topicid"';
		html += ' value="' + selectedCollaboratorLogInfo.topicid + '" />';
			//var html = '<label for="phone" >Phone';
	html += '<label for="phone" >Phone';
	html += '</label><input type="text" name="phone" id="phone"';
	html += ' value="' + selectedCollaboratorLogInfo.phone + '" disabled />';
	html += '<label for="email" >Email';
	html += '</label><input type="text" name="email" id="email"';
	html += ' value="' + selectedCollaboratorLogInfo.email + '" disabled />';
	html += '<label for="topicid" >Topic';
	html += '</label><input type="text" name="lasttopicid" id="lasttopicid"';
	//html += ' value="' + selectedCollaboratorLogInfo.topicid + '" disabled />';
	html += ' value="' + selectedCollaboratorLogInfo.topicid + '" disabled />';
	html += '<label for="log" >Log';
	html += '</label><input type="textarea" name="log" id="log"';
	html += ' value="' + selectedCollaboratorLogInfo.log + '" />';
	html += '<label for="closelog" >Close Log?';
	html += '</label><input type="checkbox" name="closelog" id="closelog"';
	//html += ' value="false" />';
	//html += ' value=false />';
	//html += ' />';
	html += ' value="on" checked />';
	html += '<br/>';


	html += '<br/>';
	html += '<p />';
	html += '<div style="clear: both;">';
	html += '<input type="submit" name="submitButton" id="submitButton"';
	html += 'value="Send Details" /> <input type="reset" name="resetButton"';
	html += 'id="resetButton" value="Reset Form" style="margin-right: 20px;" />';
	html += '</div>';
	html += '<br/>';
	
	//console.log("html " + html);			 
	//$('#memberContactLogForm').append($(html));
	//$('#memberContactLogForm').append(html);
	//$("memberContactLogForm").append(html);
	//var el = document.querySelector( "#main, #basic, #exclamation" );
	//var form = document.findElementById("memberContactLogForm");
	//var form = document.querySelector("#memberContactLogForm");
	//var form = document.getElementById("#memberContactLogForm");
	var form = document.getElementById("memberContactLogForm");
	form.innerHTML = html;
	//console.log("appended html...");
	
}
</script>
</head>

<!-- 3. Display the application -->
<body
	style="background: url(images/salmonFallsPotHoles1DPI72.jpg) no-repeat center fixed; background-size: cover;">
	<br />
	<p />
	<p />

</body>
<?php
//echo "query.php starting...";

date_default_timezone_set ( "America/New_York" );

require_once( "common.inc.php" );
require_once( "CollaborationLog.class.php" );
require_once( "AccessLog.class.php" );
//require_once( "query.php" );

$sergeantid = $_GET["sergeantid"];
$collaboratorLogsInfo = null;
if ( isset( $_POST["action"] ) and $_POST["action"] == "log" ) {
	//echo "processForm...";
	processForm();
	//tjs 160914
	//processForm($collaboratorLogsInfo);
	//processForm($collaboratorLogsInfo, $sergeantid);
} else {
	//echo "queryForPlatoonInfo...";
	//$collaboratorLogsInfo = queryForPlatoonInfo($sergeantid);		
	//queryForPlatoonInfo($sergeantid);		
	queryForPlatoonInfo($sergeantid, 0);		
		//$count = count($collaboratorLogsInfo);
		//echo "main count $count ";
	//echo "displayErrors...";
	//displayErrors();
	//displayForm( array(), array(), $collaboratorLogsInfo );
	displayForm( array(), array(), $collaboratorLogsInfo, $sergeantid );
}

//function displayForm( $errorMessages, $missingFields, $sergeantid) {
//function displayForm( $errorMessages, $missingFields, $collaboratorLogsInfo) {
function displayForm( $errorMessages, $missingFields, $collaboratorLogsInfo, $sergeantid) {

//$sergeantid = isset( $_GET["sergeantid"] ) ? preg_replace( "/[^0-9]/", "", $_GET["sergeantid"] ) : "";

displayPageHeader( "Add/Edit GunnerySergeant platoon log" );

/*
 *         <select name="primarySkillArea" id="primarySkillArea" size="1">
        <?php foreach ( $member->getSkills() as $value => $label ) { ?>
          <option value="<?php echo $value ?>"<?php setSelected( $member, "primaryskillarea", $value ) ?>><?php echo $label ?></option>
        <?php } ?>
        </select>

 */

?>
<form action="add_edit_platoon_member_log.php" method="post" style="margin-bottom: 50px;">
<input type="hidden" name="action" value="log" />
<input type="hidden" name="sarge" value="<?php echo $sergeantid; ?>" />
<label for="platoonMemberHandle">Handle</label>
<br/>
<?php
//echo "sergeantid $sergeantid";
//$selectedCollaboratorLogInfo = queryForPlatoonInfo($sergeantid);
//$collaboratorLogsInfo = queryForPlatoonInfo($sergeantid);
$selectedMemberid = 0;
		echo '<select name="platoonLogInfo" id="platoonLogInfo" size="1" onchange="displayFormContents(this.value);">';
		foreach ( $collaboratorLogsInfo as $collaboratorLogInfo ) {
			echo '<option value="' . $collaboratorLogInfo['memberid'] .'" '; 

		   if ($collaboratorLogInfo['selected'] == true) {
				echo ' selected ';
				$selectedMemberid = $collaboratorLogInfo['memberid'];
				//$selectedCollaboratorLogInfo = $collaboratorLogInfo;
			}			
			echo '>' . $collaboratorLogInfo['handle'] . '</option>';
		}
		echo "</select><p/>";

		foreach ( $collaboratorLogsInfo as $collaboratorLogInfo ) { 
			if ($collaboratorLogInfo['selected'] == true) {
				//echo ' selected  with memberid ' . $collaboratorLogInfo['memberid'];
			}
			
			?>
<script>
insertCollaboratorLogInfo(<?php echo $collaboratorLogInfo['id']; ?>, <?php echo $collaboratorLogInfo['memberid']; ?>, <?php echo $collaboratorLogInfo['topicid']; ?>, <?php echo $collaboratorLogInfo['numattempts']; ?>, '<?php echo $collaboratorLogInfo['startaccess']; ?>', '<?php echo $collaboratorLogInfo['log']; ?>', '<?php echo $collaboratorLogInfo['stopaccess']; ?>', '<?php echo $collaboratorLogInfo['handle']; ?>', '<?php echo $collaboratorLogInfo['phone']; ?>', '<?php echo $collaboratorLogInfo['email']; ?>', null, <?php echo $collaboratorLogInfo['selected']; ?>);
</script>
<?php 		
		}
		//echo " selectedMemberid $selectedMemberid ";
?>
<div id="memberContactLogForm" />

<script>
displayFormContents(<?php echo $selectedMemberid ?>);
</script>		 


</form>

<?php
displayPageFooter();
}
/*
 * CREATE OR REPLACE VIEW platoon_members_info AS 
 SELECT k.memberid,
    k.handle,
    m.phone,
    m.emailaddress AS email,
    k.sponsorid AS sponsor,
    k.sergeantid AS sargeid
   FROM members m,
    kabas k
  WHERE k.isinactive = 0 AND k.memberid = m.id;
 */
// tjs 160929
//function queryForPlatoonInfo($sargeId) {
function queryForPlatoonInfo($sargeId, $userSelectedMemberId) {
	// tjs 160914
	global $collaboratorLogsInfo;
	//SELECT * FROM platoon_members_by_sergeant WHERE sargeid = 1;
	//$selectedCollaboratorLogInfo = null;
	//echo "query sargeId $sargeId ";
	//echo "query sargeId $sargeId userSelectedMemberId $userSelectedMemberId ";
	
	$conn = connect();
	$sql = 'SELECT * FROM platoon_members_info WHERE sargeid = :sergeantid';
	//echo " sql is " . $sql;

	try {
		$rows = array();
		$st = $conn->prepare( $sql );
		$st->bindValue( ":sergeantid", $sargeId, PDO::PARAM_INT );
		//echo "binding done...";
		
		$st->execute();
		foreach ( $st->fetchAll() as $row ) {
			//echo "row member " . $row['memberid'];
			$rows[] = $row;
 		}		
		disconnect( $conn );
		$openLogMemberid = 0;
		$initialLogMemberid = 0;
		// tjs 160916
		$reopenedLogMemberid = 0;
		$collaboratorLogInfo = array();
		$collaboratorLogsInfo = array();
		$collaboratorLogs = refreshCollaborationLogs($rows);
		foreach ( $collaboratorLogs as $collaboratorLog ) {

			$memberid = $collaboratorLog->getValue('memberid');
			$numattempts = $collaboratorLog->getValue('numattempts');
			$startaccess = $collaboratorLog->getValue('startaccess');
			$stopaccess = $collaboratorLog->getValue('stopaccess');
			$handle = $collaboratorLog->getValue('handle');
			
			//echo "queryForPlatoonInfo memberid $memberid numattempts $numattempts startaccess $startaccess stopaccess $stopaccess handle $handle ";
			
			$collaboratorLogInfo['id'] = $collaboratorLog->getValue('id');
			//echo "queryForPlatoonInfo logid " . $collaboratorLogInfo['id'];
			$collaboratorLogInfo['memberid'] = $memberid;
			$collaboratorLogInfo['topicid'] = $collaboratorLog->getValue('topicid');
			$collaboratorLogInfo['numattempts'] = $numattempts;
			$collaboratorLogInfo['startaccess'] = $startaccess;
			$collaboratorLogInfo['log'] = $collaboratorLog->getValue('log');
			$collaboratorLogInfo['stopaccess'] = $stopaccess;
			$collaboratorLogInfo['handle'] = $handle;
			// tjs 160909
			$collaboratorLogInfo['selected'] = false;
			// tjs 160911
			//$collaboratorLogInfo['closed'] = false;
			foreach ( $rows as $row ) {
	//echo "queryForPlatoonInfo row memberid " . $row['memberid'] . " ";
				if ($row['memberid'] == $memberid) {
					$collaboratorLogInfo['phone'] = $row['phone'];
					$collaboratorLogInfo['email'] = $row['email'];
					$collaboratorLogInfo['sponsorid'] = $row['sponsorid'];
				}
			}
			if ($openLogMemberid == 0) {
				if ($numattempts > 0) {
					$openLogMemberid = $memberid;
				}				
			}
			if ($initialLogMemberid == 0) {
				if ($numattempts == 0) {
					$initialLogMemberid = $memberid;
				}				
			}
			// tjs 160916
			if ($reopenedLogMemberid == 0) {
				$reopenedLogMemberid = $memberid;
			}			
			$collaboratorLogsInfo[] = $collaboratorLogInfo;
		}
		
		//$selectedMemberid = 0;
		$selectedMemberid = $userSelectedMemberId;
		if ($selectedMemberid == 0) {
			if ($openLogMemberid  > 0) {
				$selectedMemberid = $openLogMemberid;
			} else if ($initialLogMemberid > 0){
				$selectedMemberid = $initialLogMemberid;
			} else {
				$selectedMemberid = $reopenedLogMemberid;
			}
		}
		//echo "query selectedMemberid $selectedMemberid ";
		// replace element
		$key = 0;
		$value = null;
		$count = count($collaboratorLogsInfo);
		//echo "query count $count ";
		for ($i = 0; $i < $count; $i++) {
			$collaboratorLogInfo = $collaboratorLogsInfo[$i];
			
			if ($collaboratorLogInfo['memberid'] == $selectedMemberid) {
				$collaboratorLogInfo['selected'] = true;
				//echo "query loop selected " . $collaboratorLogInfo['selected'];
				
				$key = $i;
				$value = $collaboratorLogInfo;
				
			}
			
		}
		
		if ($value != null) {
			$collaboratorLogsInfo[$key] = $value;
			// tjs 160916
			//echo "for key $key handle is " . $collaboratorLogsInfo[$key]['handle'] . " selected is " . $collaboratorLogsInfo[$key]['selected'] . " ";
			//echo "for key $key handle is " . $collaboratorLogsInfo[$key]['handle'] . " selected is " . $collaboratorLogsInfo[$key]['selected'] . " phone is " . $collaboratorLogsInfo[$key]['phone'] . " ";
		}
		
	} catch ( PDOException $e ) {
		disconnect( $conn );
		die( "Query failed: " . $e->getMessage() );
	}
	//return $selectedCollaboratorLogInfo;	
	//return $collaboratorLogsInfo;	
	return;	
}

/*
 * CREATE TABLE collaborationlog
(
  id serial NOT NULL,
  memberid integer NOT NULL,
  topicid integer NOT NULL,
  numattempts smallint NOT NULL,
  startaccess timestamp without time zone NOT NULL DEFAULT now(),
  log character varying(1028) NOT NULL,
  stopaccess timestamp without time zone NOT NULL DEFAULT now(),

 */
function refreshCollaborationLogs($rows) {
	$collaborationLogs = array();
		foreach ( $rows as $row ) {
			$memberid = $row['memberid'];
			$handle = $row['handle'];
			//echo "refreshCollaborationLogs memberid $memberid";
			$collaborationLogs[] = findLastCollaborationLog($memberid, $handle);
 		}
 	return $collaborationLogs;				
}

function findLastCollaborationLog($memberid, $handle) {
	//echo "findLastCollaborationLog memberid $memberid";
	list( $collaborationLog, $rowCount ) = CollaborationLog::getLastCollaborationLog( $memberid, $handle );
	//list( $collaborationLog, $rowCount ) = CollaborationLog::getLastCollaborationLog( $memberid);
	//echo "findLastCollaborationLog rowCount $rowCount";
	if ($rowCount == 0) {
		// need to add a log, create new empty one...
		$topicid = 1;
		return insertCollaborationLog($memberid, $handle, $topicid);
	} else {
		//echo "findLastCollaborationLog have rowcount...";
		//echo "findLastCollaborationLog numattempts " . $collaborationLog->getValue('numattempts');
		if ($collaborationLog->getValue('numattempts') >= 0) {
			return $collaborationLog;
		} else {
			// log had been closed, create new empty one...
			$closedTopicid = $collaborationLog->getValue('topicid');
			$maxTopicid = 0;
			//$topicids = LogEntry::getLogEntries(1);
			$topicids = AccessLog::getLogEntries(1);
			foreach ( $topicidsrow as $topicidrow ) {
				$id = $topicidrow->getValue('id');
				if ($id > $maxTopicid) {
					$maxTopicid = $topicid;
				}
	 		}
	 		$topicid = $closedTopicid++;
	 		if ($topicid > $maxTopicid)	{
	 			$topicid = 1;
	 		}					
			return insertCollaborationLog($memberid, $handle, $topicid);
		}
	} 					
}

/*
 * 	  protected $data = array(
    "id" => "",
	"memberid" => "",
    "topicid" => "",
    "numattempts" => "",
    "startaccess" => "",
    "log" => "",
    "stopaccess" => "",
	 "handle" => "" 
    );

 */
//TODO use current date...
function insertCollaborationLog($memberid, $handle, $topicid) {
	//echo "insertCollaborationLog memberid $memberid";
	// e.g. insertCollaborationLog memberid 55
				$now = date('Y-m-d H:i:s');
	
		$collaborationLog = new CollaborationLog( array(
    			"memberid" => $memberid,
    			"topicid" => $topicid,
              "numattempts" => 0,
  				//"startaccess" => date("Y-m-d", "2016-06-30"),
		"startaccess" => $now,
    		  	"log" => "",
  				//"stopaccess" => date("Y-m-d", "2016-06-30"),
		"stopaccess" => $now,
			"handle" => $handle
		));
		//echo "insertCollaborationLog object created...";
		// tjs 160916		
		//$collaborationLog = CollaborationLog::insertCollaborationLog($collaborationLog);
		$collaborationLog = CollaborationLog::insertCollaborationLog($collaborationLog, $handle);
		return $collaborationLog;
}
// tjs 160911
function processForm() {
//function processForm($collaboratorLogsInfo) {
//function processForm($collaboratorLogsInfo, $sergeantid) {
	//global $sergeantid;
	$sergeantid = null;
	if (isset( $_POST["sarge"] )) {
		//echo "processForm sarge set... ";
		//$log = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["log"] );
		$sergeantid = $_POST["sarge"];
		//echo "processForm sergeantid $sergeantid ";
	} 
	//echo "processForm sergeantid $sergeantid ";
	global $collaboratorLogsInfo;
	
	$logid = 0;
	if (isset( $_POST["logid"] )) {
		//echo "processForm logid set... ";
		//$log = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["log"] );
		$logid = $_POST["logid"];
	} 
	//echo " processForm logid: " . $logid;
	
	$log = '';
	//$closelog = '';
	$closelog = 'off';
	if (isset( $_POST["log"] )) {
		//echo "processForm log set... ";
		//$log = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["log"] );
		$log = $_POST["log"];
		//echo " processForm log: " . $log;
	} 
	if (isset( $_POST["closelog"] )) {
		//echo "processForm closelog set... ";
		//$closelog = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["closelog"] );
		$closelog =  $_POST["closelog"];
		//echo " processForm close log: " . $closelog;
	} 
	
	$topicid = 0;
	if (isset( $_POST["topicid"] )) {
		//echo "processForm topicid set... ";
		$topicid = $_POST["topicid"];
		//echo " processForm topicid: " . $topicid;
	} 
	
	$collaborationLog = CollaborationLog::getCollaborationLog($logid);
	//$oldLog = $collaborationLog->getValue('log');
	//$oldLog = $collaborationLog->getValueEncoded('log');
	$oldLog = $collaborationLog->getLog();
	//echo " processForm old log: " . $oldLog;
	//$needUpdate = false;
	$numattempts = $collaborationLog->getValue('numattempts');
	$stopaccess = $collaborationLog->getValue('stopaccess');
	if ($log != $oldLog) {
		//numattempts
		//$numattempts = 1;
		//$numattempts += $collaborationLog->getValue('numattempts');
		$numattempts += 1;
		//echo " processForm numattempts: " . $numattempts . " close? " . $closelog;
		if ($closelog == "on") {
			$numattempts *= -1;
			$stopaccess = date('Y-m-d H:i:s');
			$collaborationLog->setStopAccess($stopaccess);
					//$collaboratorLogInfo['closed'] = true;
		}
		//echo " processForm set numattempts $numattempts ";
		$collaborationLog->setNumAttempts($numattempts);
		$collaborationLog->setLog($log);
		//echo " processForm get topics... ";
		$topics = AccessLog::getLogEntries( 1 );
		$nextTopicid = 0;
		foreach ($topics as $topic) {
			$id = $topic->getValue('id');
			//echo " processForm access topic id: " . $id;
			if ($id == $topicid) {
				$nextTopicid = 1;
			} else if ($nextTopicid == 1) {
				$nextTopicid = $id;
				break;
			}			
		}
		//echo " processForm next topic id: " . $nextTopicid;
		$collaborationLog->setTopicId($nextTopicid);
		
		/*
		// replace element
		$key = 0;
		$value = null;
		$count = count($collaboratorLogsInfo);
		for ($i = 0; $i < $count; $i++) {
			$collaboratorLogInfo = $collaboratorLogsInfo[$i];
			
			if ($collaboratorLogInfo['id'] == $logid) {
				//echo "query loop selected " . $collaboratorLogInfo['selected'];			
				$key = $i;
				$value = $collaboratorLogInfo;					
			}				
		}			
		if ($value != null) {
			$value['log'] = $log;
			$value['topicid'] = $nextTopicid;
			$value['numattempts'] = $numattempts;
			$collaboratorLogsInfo[$key] = $value;
		}	
		*/		
		
		$collaborationLog->update();
	}
	//echo "processForm log: " . $log . " closed? " . $closelog;
	// e.g. processForm logid set... processForm logid: 4processForm log set... processForm closelog set... processForm log: qqqqq closed? on
	//displayPageFooter();
	//$sergeantid = null;
	//$collaboratorLogsInfo = queryForPlatoonInfo($sergeantid);
	// tjs 160929		
	//queryForPlatoonInfo($sergeantid);		
	queryForPlatoonInfo($sergeantid, 0);		
	
	//displayForm( array(), array(), $collaboratorLogsInfo );
	displayForm( array(), array(), $collaboratorLogsInfo, $sergeantid );
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


?>

</html>