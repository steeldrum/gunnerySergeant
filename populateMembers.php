<?php
date_default_timezone_set ( "America/New_York" );

require_once( "common.inc.php" );
require_once( "Kaba.class.php" );
require_once( "Guns.class.php" );

displayPageHeader( "Populate Members with test data..." );

$rootName = "sponsor";
$counterStart = 100;
$insertCount = 10;
$tableName = "Members";

if ( isset( $_GET["rootname"] )) {
$rootName = $_GET["rootname"];
}

if ( isset( $_GET["counterStart"] )) {
$counterStart = $_GET["counterStart"];
}

if ( isset( $_GET["insertCount"] )) {
$insertCount = $_GET["insertCount"];
}

if ( isset( $_GET["tableName"] )) {
$tableName = $_GET["tableName"];
}

?>
   <p>The <?php echo $tableName ?> will be populated using:</p>
   <ul>
   <li>Root member name <?php echo $rootName ?></li>
   <li>Starting at <?php echo $counterStart ?></li>
   <li>Inserting <?php echo $insertCount ?> new members</li>
   </ul>

<?php
 $states  = array( "AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DE", "DC", "FL", "GA", "HI", "ID", "IL", "IN", "IA", "KS", "KY", "LA", "ME", "MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", "NJ", "NM", "NY", "NC", "ND", "OH", "OK", "OR", "PA", "PR", "RI", "SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA", "WV", "WI", "WY");
 $sexes = array("m", "f");
 
 //echo "states 40th element is " . $states[40] . "\n";
// members (id, username, password, firstname, lastname, street1, street2, city, statename, zip, phone, joindate, gender, primaryskillarea, emailaddress, handle, otherskills, registered, lastlogindate, confidential, remindergap, intentionaldonor, subscriber, passwordmnemonicquestion, passwordmnemonicanswer, isinactive) FROM stdin;
/*
 * id serial NOT NULL,
  username character varying(30) NOT NULL,
  password character(41) NOT NULL,
  firstname character varying(30) NOT NULL,
  lastname character varying(30) NOT NULL,
  street1 character varying(30) NOT NULL,
  street2 character varying(30) NOT NULL,
  city character varying(30) NOT NULL,
  statename character varying(2) NOT NULL,
  phone character varying(10) NOT NULL,
  joindate date NOT NULL,
  gender sex NOT NULL,
  primaryskillarea skills,
  emailaddress character varying(50) NOT NULL,
  otherskills text,
  registered date,
  lastlogindate date,
  confidential smallint,
  remindergap smallint,
  intentionaldonor smallint,
  subscriber smallint,
  passwordmnemonicquestion character varying(64) DEFAULT NULL::character varying,
  passwordmnemonicanswer character varying(15) DEFAULT NULL::character varying,
  isinactive smallint,
  zip5 character varying(5) NOT NULL,
  zip4 character varying(4),

 */
if ($tableName == "Members") {
	//echo "Inserting $insertCount new rows into table $tableName starting with $counterStart using root $rootName\n";
	for ($i = $counterStart; $i < $counterStart + $insertCount; $i++) {
		$username = $rootName . strval($i);
		$password = $username;
		$firstname = "First" . $username;
		$lastname = "Last" . $username;
		$street1 = "Street1" . $username;
		$street2 = "";
		$city = "City" . $username;
		$randomNumber = rand ( 0 , count($states) - 1);
		//echo "random state is $randomNumber\n";
		$statename = $states[$randomNumber];
		$randomNumber = rand ( 10000 , 99999);
		$zip5 = $randomNumber;
		$randomNumber = rand ( 1000 , 9999);
		$zip4 = $randomNumber;
		$randomNumber = rand ( 1000000000 , 9999999999);
		$phone = $randomNumber;		
		$now = date("Ymd");
		$joindate = $now;
		$randomNumber = rand ( 0 , 1);
		$gender = $sexes[$randomNumber];
		$primaryskillarea = 'other';
		$now = date("YmdHis");
		//$emailaddress = $now . "@collogistics.com";
		//$randiomNumber = rand ( 0 , 9999999999);		
		//$emailaddress = $randiomNumber . "@gunnerysergeant.org";
		$emailaddress = $username . "@gunnerysergeant.org";
		$otherskills = 'otherskills';
		$registered = $joindate;
		$lastlogindate = $joindate;
		$confidential = 1;
		$remindergap = 12;
		$intentionaldonor = 0;
		$subscriber = 0;
		$passwordmnemonicquestion = "Mother In Law Last Name?";
		$passwordmnemonicanswer = "wife's maiden!";
		$isinactive = 0;
		
		//echo "Creating new member with username $username\n";
		$member = new Member( array(
    	"username" => $username,
    	"password" => $password,
  		"firstname" => $firstname,
    	"lastname" => $lastname, 
    	"street1" => $street1,
      	"street2" => $street2,
        "city" => $city,
          "statename" => $statename,
          "phone" => $phone,
    	"joindate" => $joindate,
  		"gender" => $gender,
    	"primaryskillarea" => $primaryskillarea,
    	"emailaddress" => $emailaddress,
    	"otherskills" => $otherskills,
    	"registered" => $registered,
   		"lastlogindate" => $lastlogindate,
    	"confidential" => "1",
 		 "remindergap" => "12",
    	"intentionaldonor" => "0",
     	"subscriber" => "0",
    	"passwordmnemonicquestion" => $passwordmnemonicquestion,
    	"passwordmnemonicanswer" => $passwordmnemonicanswer,
    	"isinactive" => "0",
          "zip5" => $zip5,
         "zip4" => $zip4  
         ) );
        // echo "Ready to insert new member " . $member->getValue('username'). "\n";
         $member->insert();
	}
	echo "Inserted $insertCount new rows into table $tableName starting with $counterStart using root $rootName\n";
	  displayPageFooter();	
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