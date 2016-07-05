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
	<p />
	<p />
	<footer class="w3-container w3-round w3-border w3-brown">
	<div class="w3-container w3-center">
		<a class="w3-btn w3-round-large" href="./index.html"> <img
			border="0" alt="Home" src="assets/images/HomeSBC.jpg" width="100"
			height="30"> </a>
	</div>
	</footer>

</body>
<?php
/***************************************
 $Revision:: 91                         $: Revision of last commit
 $LastChangedBy::                       $: Author of last commit
 $LastChangedDate:: 2011-05-11 11:31:55#$: Date of last commit
 ***************************************/
/*
 Collaborators/
 register.php
 tjs 101012

 file version 1.02

 release version 1.06
 -- Table: members

 -- DROP TABLE members;

 CREATE TABLE members
 (
 id serial NOT NULL,
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
 CONSTRAINT memberspk PRIMARY KEY (id),
 CONSTRAINT emailaddress UNIQUE (emailaddress),
 CONSTRAINT username UNIQUE (username)
 )
 WITH (
 OIDS=FALSE
 );
 ALTER TABLE members
 OWNER TO thomassoucy;

 */

date_default_timezone_set ( "America/New_York" );

require_once( "common.inc.php" );
require_once( "Kaba.class.php" );
require_once( "Guns.class.php" );

if ( isset( $_POST["action"] ) and $_POST["action"] == "register" ) {
	processForm();
}

function displayForm( $errorMessages, $missingFields, $member ) {
	//displayPageHeader( "Sign up for the book club!" );
	displayPageHeader( "Sign up as Collogistics collaborator!" );

	if ( $errorMessages ) {
		foreach ( $errorMessages as $errorMessage ) {
			echo $errorMessage;
		}
	} else {
		?>
<p>Thanks for choosing to join Collogistics.</p>
<p>To register, please fill in your details below and click Send
	Details.</p>
<p>Fields marked with an asterisk (*) are required.</p>
		<?php } ?>

<form action="register.php" method="post" style="margin-bottom: 50px;">
	<div style="width: 30em;">
		<input type="hidden" name="action" value="register" /> <label
			for="username" <?php validateField( "username", $missingFields ) ?>>Choose
			a username *</label> <input type="text" name="username" id="username"
			value="<?php echo $member->getValueEncoded( "username" ) ?>" /> <label
			for="password1" <?php if ( $missingFields ) echo ' class="error"' ?>>Choose
			a password *</label> <input type="password" name="password1"
			id="password1" value="" /> <label for="password2"
			<?php if ( $missingFields ) echo ' class="error"' ?>>Retype password
			*</label> <input type="password" name="password2" id="password2"
			value="" /> <label for="passwordMnemonicQuestion">Specify password
			mnemonic question</label> <input type="text"
			name="passwordMnemonicQuestion" id="passwordMnemonicQuestion"
			value="<?php echo $member->getValueEncoded( "passwordMnemonicQuestion" ) ?>" />

		<label for="passwordMnemonicAnswer">Specify password mnemonic answer</label>
		<input type="text" name="passwordMnemonicAnswer"
			id="passwordMnemonicAnswer"
			value="<?php echo $member->getValueEncoded( "passwordMnemonicAnswer" ) ?>" />

		<label for="emailAddress"
		<?php validateField( "emailAddress", $missingFields ) ?>>Email
			address *</label> <input type="text" name="emailAddress"
			id="emailAddress"
			value="<?php echo $member->getValueEncoded( "emailAddress" ) ?>" /> <label
			for="firstName" <?php validateField( "firstName", $missingFields ) ?>>First
			name *</label> <input type="text" name="firstName" id="firstName"
			value="<?php echo $member->getValueEncoded( "firstName" ) ?>" /> <label
			for="lastName" <?php validateField( "lastName", $missingFields ) ?>>Last
			name *</label> <input type="text" name="lastName" id="lastName"
			value="<?php echo $member->getValueEncoded( "lastName" ) ?>" /> <label
			<?php validateField( "gender", $missingFields ) ?>>Your gender: *</label>
		<label for="genderMale">Male</label> <input type="radio" name="gender"
			id="genderMale" value="m"
			<?php setChecked( $member, "gender", "m" )?> /> <label
			for="genderFemale">Female</label> <input type="radio" name="gender"
			id="genderFemale" value="f"
			<?php setChecked( $member, "gender", "f" )?> /> <label
			for="primarySkillArea">What's your primary skill?</label> <select
			name="primarySkillArea" id="primarySkillArea" size="1">
			<?php foreach ( $member->getSkills() as $value => $label ) { ?>
			<option value="<?php echo $value ?>"
			<?php setSelected( $member, "primarySkillArea", $value ) ?>>
				<?php echo $label ?>
			</option>
			<?php } ?>
		</select> <label for="otherSkills">What are your other interests?</label>
		<textarea name="otherSkills" id="otherSkills" rows="4" cols="50">
		<?php echo $member->getValueEncoded( "otherSkills" ) ?>
		</textarea>

		<div style="clear: both;">
			<input type="submit" name="submitButton" id="submitButton"
				value="Send Details" /> <input type="reset" name="resetButton"
				id="resetButton" value="Reset Form" style="margin-right: 20px;" />
		</div>

	</div>
</form>
<br />
<a href="admin.php">Site Admin</a>
		<?php
		displayPageFooter();
}

function processForm() {
	//	echo "processForm... ";
	$requiredFields = array( "username", "password", "emailAddress", "firstName", "lastName", "gender" );
	$missingFields = array();
	$errorMessages = array();
	// tjs 141114
	//$d=mktime(1, 1, 1, 12, 31, 1970);
	//echo "Created date is " . date("Y-m-d h:i:sa", $d);

	// debug
	//$handle = $_POST["handle"];
	//$username = $_POST["username"];
	//echo "Handle is " . $handle . " username is " . $username;
	$handleUsername = '';
	$handleFound = false;
	$memberPassword = '';
	$sponsorId = "";
	$requirePasswords = true;
	if (isset( $_POST["handle"] )) {
		$handleFound = true;
		$handleUsername = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["handle"] );
	} else if (isset( $_POST["username"] )) {
		$handleUsername = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["username"] );
	} else {
		// TODO generate unique word based on timestamp
		$handleUsername = 'unique';
	}
	if (isset( $_POST["sponsor"] )) {
		$requirePasswords = false;
		$sponsorUsername = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["sponsor"] );
		//echo "Sponsor Username is " . $sponsorUsername;
		//  $sponsor = '';
		//$sponsorid = 11;
		if ( !$sponsor = Member::getByUsername( $sponsorUsername ) ) {
		 //if ( !$sponsor = Member::getMember( $sponsorid ) ) {
		 //  displayPageHeader( "Error" );
			echo "Member not found using Sponsor Username of " . $sponsorUsername;
			//displayPageFooter();
			// exit;
		} else {
			$memberPassword = $sponsor->getValue('password');
			//echo "Member password is " . $memberPassword;
			$sponsorId = $sponsor->getValue('id');
		}
	} else if (isset( $_POST["password1"] ) and isset( $_POST["password2"] ) and $_POST["password1"] == $_POST["password2"] ) {
		$memberPassword = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["password1"] );
	} else {
		$memberPassword = $handleUsername;
	}
	//echo "Handle Username is " . $handleUsername . " Member Password is " . $memberPassword;

	//TODO see related comments in controller.
	//    "username" => isset( $_POST["username"] ) ? preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["username"] ) : "",

	$member = new Member( array(
    	"username" => $handleUsername,
    	"password" => $memberPassword,
  		"firstname" => isset( $_POST["firstName"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["firstName"] ) : "",
    	"lastname" => isset( $_POST["lastName"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["lastName"] ) : "",
    	"street1" => isset( $_POST["street1"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["street1"] ) : "",
      	"street2" => isset( $_POST["street2"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["street2"] ) : "",
        "city" => isset( $_POST["city"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["city"] ) : "",
          "statename" => isset( $_POST["stateName"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["stateName"] ) : "",
          "phone" => isset( $_POST["phone"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["phone"] ) : "",
    	"joindate" => date("Y-m-d", "2016-06-30"),
  		"gender" => isset( $_POST["gender"] ) ? preg_replace( "/[^mf]/", "", $_POST["gender"] ) : "",
    	"primaryskillarea" => isset( $_POST["primarySkillArea"] ) ? preg_replace( "/[^a-zA-Z]/", "", $_POST["primarySkillArea"] ) : "",
    	"emailaddress" => isset( $_POST["emailAddress"] ) ? preg_replace( "/[^ \@\.\-\_a-zA-Z0-9]/", "", $_POST["emailAddress"] ) : "",
    	"otherskills" => isset( $_POST["otherSkills"] ) ? preg_replace( "/[^ \'\,\.\-a-zA-Z0-9]/", "", $_POST["otherSkills"] ) : "",
    	"registered" => date("Y-m-d"),
   		"lastlogindate" => date("Y-m-d"),
    	"confidential" => "1",
 		 "remindergap" => "12",
    	"intentionaldonor" => "0",
     	"subscriber" => "0",
    	"passwordmnemonicquestion" => isset( $_POST["passwordMnemonicQuestion"] ) ? preg_replace( "/[^a-zA-Z]/", "", $_POST["passwordMnemonicQuestion"] ) : "",
    	"passwordmnemonicanswer" => isset( $_POST["passwordMnemonicAnswer"] ) ? preg_replace( "/[^a-zA-Z]/", "", $_POST["passwordMnemonicAnswer"] ) : "",
    	"isinactive" => "0",
          "zip5" => isset( $_POST["zip5"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["zip5"] ) : "",
         "zip4" => isset( $_POST["zip4"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["zip4"] ) : ""
  
      ) );
              //echo "Created date is " . date("Y-m-d h:i:sa", $d);

     foreach ( $requiredFields as $requiredField ) {
         if ( !$member->getValue( $requiredField ) ) {
              		$missingFields[] = $requiredField;
              	}
     }
              /*
               if ( $missingFields ) {
               echo "missing fields... ";
               $errorMessages[] = '<p class="error">There were some missing fields in the form you submitted. Please complete the fields highlighted below and click Send Details to resend the form.</p>';
               }
               */

              //if ( !isset( $_POST["password1"] ) or !isset( $_POST["password2"] ) or !$_POST["password1"] or !$_POST["password2"] or ( $_POST["password1"] != $_POST["password2"] ) ) {
      if ( $requirePasswords and (!isset( $_POST["password1"] ) or !isset( $_POST["password2"] ) or !$_POST["password1"] or !$_POST["password2"] or ( $_POST["password1"] != $_POST["password2"] ) )) {
              	$errorMessages[] = '<p class="error">Please make sure you enter your password correctly in both password fields.</p>';
      }

      if (Member::getByUsername( $member->getValue( "username" ) ) ) {
              	//echo "username exists... ";
              	$errorMessages[] = '<p class="error">A member with that username already exists in the database. Please choose another username.</p>';
      }

              //if ( Member::getByEmailAddress( $member->getValue( "emailAddress" ) ) ) {
      if ( Member::getByEmailAddress( $member->getValue( "emailaddress" ) ) ) {
              	//echo "email exists... ";
              	$errorMessages[] = '<p class="error">A member with that email address already exists in the database. Please choose another email address, or contact the webmaster to retrieve your password.</p>';
      }

      if ( $errorMessages ) {
              	//displayForm( $errorMessages, $missingFields, $member );
      } else {
              	//echo "inserting... ";
          $member->insert();
              	//displayThanks();
          if ($handleFound) {
              //echo "inserting into kaba... ";

              		/*
              		 *   derived sponsor id given sponsor username (above)
              		 derive kaba member id given kaba member username
              		 use temp sergeantid = 1

              		 insert into kaba (gun owner desiring KABA rights)
              		 //TODO ensure sponsorId NOT in kaba already!
              		 * NB the system daemons detects the sergeatId of one and reassigns a real sergeant
              		 */
          		if ( $kabaMember = Member::getByUsername( $handleUsername ) ) {
              		$kabaMemberId = $kabaMember->getValue('id');
              			//echo "kabaMemberId " . $kabaMemberId . " sponsorId " . $sponsorId;
              			$kaba = new Kaba( array(
    						"memberid" => $kabaMemberId,
    						"sponsorid" => $sponsorId,
  							"sergeantid" => "1",
    						"isinactive" => "0",
              				"handle" => $handleUsername 
              			) );
              			$kaba->insert();

              			//echo "constructing guns... ";
              			// insert initial gun information...
              			$gunInfo = new Guns( array(
    						"memberid" => $kabaMemberId,
    						"gunname" => isset( $_POST["gunname"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["gunname"] ) : "",
              			"shortname" => isset( $_POST["shortname"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["shortname"] ) : "",
  							"make" => isset( $_POST["make"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["make"] ) : "",
  							"model" => isset( $_POST["model"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["model"] ) : "",
    					  	"serialnumber" => isset( $_POST["serialnumber"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["serialnumber"] ) : "",
  							 "description" => isset( $_POST["description"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["description"] ) : "",
    					  	"caliber" => isset( $_POST["caliber"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["caliber"] ) : "",
  							"createddate" => isset( $_POST["createddate"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["createddate"] ) : "",
    					  	"isforsale" => isset( $_POST["isforsale"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["isforsale"] ) : "",
  							 "isinactive" => "0"
              			));
              			//echo "inserting into guns... ";
              			$gunInfo->insert();
              			// 			) );

              		}
              	}
              }
}

function displayThanks() {
	displayPageHeader( "Thanks for registering!" );
	?>
<p>Thank you, you are now a registered member of Collogistics.</p>
<br />
<a href="admin.php">Site Admin</a>
<br />
<a href="index.php">Home</a>
	<?php
	displayPageFooter();
}

?>
</html>
