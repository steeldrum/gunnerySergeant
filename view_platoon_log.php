<?php
/***************************************
$Revision:: 55                         $: Revision of last commit
$LastChangedBy::                       $: Author of last commit
$LastChangedDate:: 2011-03-02 13:40:21#$: Date of last commit
***************************************/
/*
Collaborators/
view_platoon_log.php

file version 1.00 

release version 1.06
*/

require_once( "common.inc.php" );
require_once( "config.php" );
require_once( "CollaborationLog.class.php" );
//require_once( "LogEntry.class.php" );

$id = isset( $_REQUEST["id"] ) ? (int)$_REQUEST["id"] : 0;
//$sergeantid = isset( $_GET["sergeantid"] ) ? preg_replace( "/[^0-9]/", "", $_GET["sergeantid"] ) : "";
$sergeantid = isset( $_REQUEST["sergeantid"] ) ? (int)$_REQUEST["sergeantid"] : 0;
$handle = isset( $_REQUEST["handle"] ) ? $_REQUEST["handle"] : "";
//echo "view_platoon_log id $id sergeant $sergeantid handle $handle ";

if ( !$log = CollaborationLog::getCollaborationLog( $id ) ) {
  displayPageHeader( "Error" );
  echo "<div>Log not found.</div>";
  displayPageFooter();
  exit;
}

if ( isset( $_POST["action"] ) and $_POST["action"] == "Save Changes" ) {
  saveLog();
} elseif ( isset( $_POST["action"] ) and $_POST["action"] == "Delete Log" ) {
  deleteLog();
} else {
  displayForm( array(), array(), $log );
}

function displayForm( $errorMessages, $missingFields, $log ) {
	global $handle;
	global $sergeantid;
 // $logEntries = LogEntry::getLogEntries( $member->getValue( "id" ) );
  //echo " displayForm got member id?";
  displayPageHeader( "View platoon member log: " . $handle );

  if ( $errorMessages ) {
    foreach ( $errorMessages as $errorMessage ) {
      echo $errorMessage;
    }
  }

  $start = isset( $_REQUEST["start"] ) ? (int)$_REQUEST["start"] : 0;
  $order = isset( $_REQUEST["order"] ) ? preg_replace( "/[^ a-zA-Z]/", "", $_REQUEST["order"] ) : "startaccess";
?>
    <form action="view_platoon_log.php" method="post" style="margin-bottom: 50px;">
      <div style="width: 30em;">
        <input type="hidden" name="sergeantid" id="sergeantid" value="<?php echo $sergeantid; ?>" />
        <input type="hidden" name="handle" id="handle" value="<?php echo $handle; ?>" />
        <input type="hidden" name="id" id="id" value="<?php echo $log->getValueEncoded( "id" ) ?>" />
        <input type="hidden" name="start" id="start" value="<?php echo $start ?>" />
        <input type="hidden" name="order" id="order" value="<?php echo $order ?>" />
        <input type="textarea" name="log" id="log" value="<?php echo $log->getValueEncoded( "log" ) ?>" />

        <div style="clear: both;">
          <input type="submit" name="action" id="saveButton" value="Save Changes" />
          <input type="submit" name="action" id="deleteButton" value="Delete Log" style="margin-right: 20px;" />
        </div>
      </div>
    </form>

    <div style="width: 30em; margin-top: 20px; text-align: center;">
      <a href="view_platoon_logs.php?sergeantid=<?php echo $sergeantid ?>&amp;start=<?php echo $start ?>&amp;order=<?php echo $order ?>">Back</a>
    </div>

<?php
  displayPageFooter();
}

function saveLog() {
	/*
  $requiredFields = array( "username", "emailaddress", "firstname", "lastname", "joindate", "gender" );
  $missingFields = array();
  $errorMessages = array();

  //tjs 160805
  $today = date("Y-m-d");
  
  $member = new Member( array(
    "id" => isset( $_POST["memberId"] ) ? (int) $_POST["memberId"] : "",
    "username" => isset( $_POST["username"] ) ? preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["username"] ) : "",
    "password" => isset( $_POST["password"] ) ? preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["password"] ) : "",
    "emailaddress" => isset( $_POST["emailAddress"] ) ? preg_replace( "/[^ \@\.\-\_a-zA-Z0-9]/", "", $_POST["emailAddress"] ) : "",
    "firstname" => isset( $_POST["firstName"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["firstName"] ) : "",
    "lastname" => isset( $_POST["lastName"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["lastName"] ) : "",
    "joindate" => isset( $_POST["joinDate"] ) ? preg_replace( "/[^\-0-9]/", "", $_POST["joinDate"] ) : "",
    "gender" => isset( $_POST["gender"] ) ? preg_replace( "/[^mf]/", "", $_POST["gender"] ) : "",
    //"primaryskillarea" => isset( $_POST["primarySkillArea"] ) ? preg_replace( "/[^a-zA-Z]/", "", $_POST["favoriteGenre"] ) : "",
  "primaryskillarea" => isset( $_POST["primarySkillArea"] ) ? preg_replace( "/[^a-zA-Z]/", "", $_POST["primarySkillArea"] ) : "",
    "otherskills" => isset( $_POST["otherSkills"] ) ? preg_replace( "/[^ \'\,\.\-a-zA-Z0-9]/", "", $_POST["otherSkills"] ) : "",
   //TODO ensure copied first...
  "registered" => $today,
  "lastlogindate" => $today,
    "confidential" => 0,
  "remindergap" => 12,
    "intentionaldonor" => 0,
    "subscriber" => 0,
  "passwordmnemonicquestion" => isset( $_POST["passwordMnemonicQuestion"] ) ? preg_replace( "/[^a-zA-Z]/", "", $_POST["passwordMnemonicQuestion"] ) : "",
    "passwordmnemonicanswer" => isset( $_POST["passwordMnemonicAnswer"] ) ? preg_replace( "/[^a-zA-Z]/", "", $_POST["passwordMnemonicAnswer"] ) : "",
   // "isinactive" => ""
  "isinactive" => 0

  ) );

  foreach ( $requiredFields as $requiredField ) {
    if ( !$member->getValue( $requiredField ) ) {
      $missingFields[] = $requiredField;
    }
  }

  if ( $missingFields ) {
    $errorMessages[] = '<p class="error">There were some missing fields in the form you submitted. Please complete the fields highlighted below and click Save Changes to resend the form.</p>';
  }

  if ( $existingMember = Member::getByUsername( $member->getValue( "username" ) ) and $existingMember->getValue( "id" ) != $member->getValue( "id" ) ) {
    $errorMessages[] = '<p class="error">A member with that username already exists in the database. Please choose another username.</p>';
  }

  if ( $existingMember = Member::getByEmailAddress( $member->getValue( "emailaddress" ) ) and $existingMember->getValue( "id" ) != $member->getValue( "id" ) ) {
    $errorMessages[] = '<p class="error">A member with that email address already exists in the database. Please choose another email address.</p>';
  }

  if ( $errorMessages ) {
    displayForm( $errorMessages, $missingFields, $member );
  } else {
    $member->update();
    */
    displaySuccess();
  //}
}

function deleteLog() {
	/*
  $member = new Member( array(
    "id" => isset( $_POST["memberId"] ) ? (int) $_POST["memberId"] : "",
  ) );
  LogEntry::deleteAllForMember( $member->getValue( "id" ) );
  $member->delete();
  */
  displaySuccess();
}

function displaySuccess() {
  $start = isset( $_REQUEST["start"] ) ? (int)$_REQUEST["start"] : 0;
  $order = isset( $_REQUEST["order"] ) ? preg_replace( "/[^ a-zA-Z]/", "", $_REQUEST["order"] ) : "handle";
  displayPageHeader( "Changes saved" );
?>
    <p>Your changes have been saved. <a href="view_platoon_logs.php?sergeantid=<?php echo $sergeantid ?>&amp;start=<?php echo $start ?>&amp;order=<?php echo $order ?>">Return to log list</a></p>
<?php
  displayPageFooter();
}

?>

