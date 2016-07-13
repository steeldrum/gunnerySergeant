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
	function getNodeValue(parent, tagName)
	  {
	    var node = parent.getElementsByTagName(tagName)[0];
	    return (node && node.firstChild) ? node.firstChild.nodeValue : false;
	  };

	 function callAjax(method, value, target) {
	        console.log("callAjax method " + method + " value " + value + " target " + target);
	   	var request = $.ajax({
	        url: "./validate.php",
	        type: "post",
	        data: {
	        method: method,
	        value: value,
	        target: target
	    	}
	    	});    
	    
	    // Callback handler that will be called on success
	    request.done(function (response, textStatus, jqXHR){
	        // Log a message to the console
	        //console.log("callAjax done worked...");
	        console.log("callAjax done worked and textStatus " + textStatus);
	    	// received XML response
	    	if(response == null) {
	      		window.console.log("Invalid XML response - please check the Ajax response data for invalid characters or formatting");
	    	}
	    	console.log("callAjax done response " + response);
	    	/*
	    	  xmlDoc = $.parseXML( xml ),
	  $xml = $( xmlDoc ),
	  $title = $xml.find( "title" );
	  */
	//var oParser = new DOMParser();
	//var oDOM = oParser.parseFromString(response, "text/xml");
	    	//var response  = responseXML.documentElement;
	    	var commands = response.getElementsByTagName('command');
	    	//var commands = oDOM.getElementsByTagName('command');
	    	console.log("callAjax done commands length " + commands.length);
	    	for(var i=0; i < commands.length; i++) {
	      		method = commands[i].getAttribute('method');
	    		console.log("callAjax done method " + method);
	      switch(method)
	      {
	        case 'alert':
	          var message = getNodeValue(commands[i], 'message');
	          window.alert(message);
	          break;

	        case 'setvalue':
	          var target = getNodeValue(commands[i], 'target');
	          var value = getNodeValue(commands[i], 'value');
	          if(target && value !== false) {
	            document.getElementById(target).value = value;
	          }
	          break;

	        case 'setdefault':
	          var target = getNodeValue(commands[i], 'target');
	          if(target) {
	            document.getElementById(target).value = document.getElementById(target).defaultValue;
	          }
	          break;

	        case 'focus':
	          var target = getNodeValue(commands[i], 'target');
	          if(target) {
	            document.getElementById(target).focus();
	          }
	          break;

	        case 'setcontent':
	          var target = getNodeValue(commands[i], 'target');
	          var content = getNodeValue(commands[i], 'content');
	          var append = getNodeValue(commands[i], 'append');
	          console.log("setcontent target " + target + " content " + content + " append " + append);
	          if(target && (content !== false)) {
	            var el = document.getElementById(target);
	            if(el) {
	              if(append !== false) {
	                var newcontent = document.createElement("div");
	                newcontent.innerHTML = content;
	                while(newcontent.firstChild) {
	                  el.appendChild(newcontent.firstChild);
	                }
	              } else {
	                el.innerHTML = content;
	              }
	            } else {
	              console.log("Cannot target missing element: " + target);
	            }
	          }
	          break;

	        case 'setstyle':
	          var target = getNodeValue(commands[i], 'target');
	          var property = getNodeValue(commands[i], 'property');
	          var value = getNodeValue(commands[i], 'value');
	          if(target && property && (value !== false)) {
	            document.getElementById(target).style[property] = value;
	          }
	          break;

	        case 'setproperty':
	          var target = getNodeValue(commands[i], 'target');
	          var property = getNodeValue(commands[i], 'property');
	          var value = getNodeValue(commands[i], 'value');
	          console.log("setproperty target " + target + " property " + property + " value " + value);
	          if(value == "true") value = true;
	          if(value == "false") value = false;
	          if(target && document.getElementById(target)) {
	            document.getElementById(target)[property] = value;
	          }
	          break;

	        case 'callback':
	          var idx = 1;
	          var param = getNodeValue(commands[i], "param" + idx++);
	          while(param) {
	            callbackParams.push(param);
	            param = getNodeValue(commands[i], "param" + idx++);
	          }
	          break;

	        default:
	          window.console.log("Unrecognised method '" + method + "' in processReqChange()");

	      } // switch

	    } // for
	 	});
	    // Callback handler that will be called on failure
	    request.fail(function (jqXHR, textStatus, errorThrown){
	        // Log the error to the console
	        console.error(
	            "The following error occurred: "+
	            textStatus, errorThrown
	        );
	    });
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
	//echo "processForm...";
	processForm();
} else {
	//displayForm( array(), array(), new Member( array() ) );
	displayForm( array(), array(), new Member( array() ), new Kaba( array() ), new Member( array() ), new Guns( array() ), $_GET["role"], $_GET["option"] );
	 
	//echo "displayErrors...";
	//displayErrors();
}

//function displayForm( $errorMessages, $missingFields, $member ) {
function displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $guns, $role, $option) {
	//displayPageHeader( "Sign up for the book club!" );
	displayPageHeader( "Enlistment into the Gunnery Sergeant Organization!" );

	if ( $errorMessages ) {
		foreach ( $errorMessages as $errorMessage ) {
			echo $errorMessage;
		}
	} else {
		?>
<p>Thanks for choosing to join the GunnerySergeant Organization.</p>
<p>To enlist, please fill in your details below and click Send Details.</p>
<p>Fields marked with an asterisk (*) are required.</p>
		<?php } ?>

<form action="enlist.php" method="post" style="margin-bottom: 50px;">
	<div style="width: 30em;">
		<input type="hidden" name="action" value="register" /> <input
			type="hidden" name="role" value="<?php echo $role; ?>" /> <input
			type="hidden" name="option" value="<?php echo $option; ?>" />
	 <input
			type="hidden" name="passwordMnemonicQuestion"
			value="visit sponsor to reset" />
			 <input type="hidden"
			name="passwordMnemonicAnswer" value="sponsorhelp" />
			
			<?php if ($role != 'private') { ?>
				
		<label for="username"
		<?php validateField( "username", $missingFields ) ?>>Username
			*</label>
		<p>
			<input type="text" name="username" id="username"
				value="<?php echo $member->getValueEncoded( "username" ) ?>"
				onchange="callAjax('checkUsername', this.value, this.id);" />&nbsp;<input
				class="valid" id="valid_username" type="checkbox" disabled
				name="valid_username">
		</p>
		<div class="rsp_message" id="rsp_username">
			<!-- -->
		</div>
			
			 <label
			for="password1" <?php if ( $missingFields ) echo ' class="error"' ?>>Choose
			a password *</label> <input type="password" name="password1"
			id="password1" value="" /> <label for="password2"
			<?php if ( $missingFields ) echo ' class="error"' ?>>Retype password
			*</label> <input type="password" name="password2" id="password2"
			value="" />

		<label for="emailAddress"
		<?php validateField( "emailAddress", $missingFields ) ?>>Email
			address
			*</label>
		<p>
			<input type="text" name="emailAddress" id="email"
				value="<?php echo $member->getValueEncoded( "emailAddress" ) ?>"
				onchange="callAjax('checkEmail', this.value, this.id);" />&nbsp;<input
				class="valid" id="valid_email" type="checkbox" disabled
				name="valid_email">
		</p>
		<div class="rsp_message" id="rsp_email">
			<!-- -->
		</div>
			
			 <label
			for="firstName" <?php validateField( "firstName", $missingFields ) ?>>First
			name *</label> <input type="text" name="firstName" id="firstName"
			value="<?php echo $member->getValueEncoded( "firstName" ) ?>" /> 
			<label
			for="lastName" <?php validateField( "lastName", $missingFields ) ?>>Last
			name *</label> <input type="text" name="lastName" id="lastName"
			value="<?php echo $member->getValueEncoded( "lastName" ) ?>" />
			
		
		<?php } else {
				
			$now = date("YmdHis");
			$tempEmailAddress = $now . "@gunnerysergeant.org";
			?>

		<input type="hidden" name="username" value="unknown" /> <input
			type="hidden" name="street1" value="unknown" /> <input type="hidden"
			name="street2" value="unknown" /> <input type="hidden" name="city"
			value="unknown" /> <input type="hidden" name="stateName" value="XX" />
		<input type="hidden" name="phone" value="unknown" />
		 <input
			type="hidden" name="primarySkillArea" value="other" />
					 <input
			type="hidden" name="firstName" value="unknown" /> <input
			type="hidden" name="lastName" value="unknown" /> <input type="hidden"
			name="emailAddress" value="<?php echo $tempEmailAddress; ?>" /> <input
			type="hidden" name="shortname" value="shortname" /> <input
			type="hidden" name="isforsale" value="0" /> <input type="hidden"
			name="createddate" value="2016-07-11" />

			<?php } ?>

	<?php if ($role != 'private') { ?>		
		 <label
			for="street1" <?php validateField( "street1", $missingFields ) ?>>Street1
			 *</label> <input type="text" name="street1" id="street1"
			value="<?php echo $member->getValueEncoded( "street1" ) ?>" /> 

		 <label
			for="street2" <?php validateField( "street2", $missingFields ) ?>>Street2
			 *</label> <input type="text" name="street2" id="street2"
			value="<?php echo $member->getValueEncoded( "street2" ) ?>" /> 

		 <label
			for="city" <?php validateField( "city", $missingFields ) ?>>City
			 *</label> <input type="text" name="city" id="city"
			value="<?php echo $member->getValueEncoded( "city" ) ?>" /> 

		 <label
			for="statename" <?php validateField( "statename", $missingFields ) ?>>State
			 *</label> <input type="text" name="statename" id="statename"
			value="<?php echo $member->getValueEncoded( "statename" ) ?>" /> 

<?php } ?>

		<label for="zip5" <?php validateField( "zip5", $missingFields ) ?>>Zip
			code *</label> <input type="text" name="zip5" id="zip5"
			value="<?php echo $member->getValueEncoded( "zip5" ) ?>"
			onchange="this.value = /^([0-9]{5})$/.test(this.value)? this.value : ''; valid_zip5.checked = this.value;" />&nbsp;<input
			class="valid" type="checkbox" disabled name="valid_zip5" />

	<?php if ($role == 'booster'  && $option == 2) { ?>		
			 <label
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

<?php } else { ?>
		 <input
			type="hidden" name="primarySkillArea" value="other" />

<?php } ?>

	
	<?php if ($role == 'private') { ?>		
			 <label
			for="handle" <?php validateField( "handle", $missingFields ) ?>>Handle
			*</label>
		<p>
			<input type="text" name="handle" id="handle"
				value="<?php echo $kaba->getValueEncoded( "handle" ) ?>"
				onchange="callAjax('checkHandle', this.value, this.id);" />&nbsp;<input
				class="valid" id="valid_handle" type="checkbox" disabled
				name="valid_handle" />
		</p>
		<div class="rsp_message" id="rsp_handle">
			<!-- -->
		</div>
		<label for="sponsor"
		<?php validateField( "sponsor", $missingFields ) ?>>Sponsor Username
			*</label>
		<p>
			<input type="text" name="sponsor" id="sponsorusername"
				value="<?php echo $sponsor->getValueEncoded( "username" ) ?>"
				onchange="callAjax('checkSponsorUsername', this.value, this.id);" />&nbsp;<input
				class="valid" id="valid_sponsorusername" type="checkbox" disabled
				name="valid_sponsorusername">
		</p>
		<div class="rsp_message" id="rsp_sponsorusername">
			<!-- -->
		</div>
		<?php } ?>
		
		<label <?php validateField( "gender", $missingFields ) ?>>Your gender:
			*</label> <label for="genderMale">Male</label> <input type="radio"
			name="gender" id="genderMale" value="m"
			<?php setChecked( $member, "gender", "m" )?> /> <label
			for="genderFemale">Female</label> <input type="radio" name="gender"
			id="genderFemale" value="f"
			<?php setChecked( $member, "gender", "f" )?> /><br />
	
	<?php if ($role == 'private') { ?>		
			 <label
			for="gunname" <?php validateField( "gunname", $missingFields ) ?>>Gun
			Name *</label> <input type="text" name="gunname" id="gunname"
			value="<?php echo $guns->getValueEncoded( "gunname" ) ?>" /><br /> <label
			for="make" <?php validateField( "make", $missingFields ) ?>>Gun Make
			*</label> <input type="text" name="make" id="make"
			value="<?php echo $guns->getValueEncoded( "make" ) ?>" /><br /> <label
			for="model" <?php validateField( "model", $missingFields ) ?>>Gun
			Model *</label> <input type="text" name="model" id="model"
			value="<?php echo $guns->getValueEncoded( "model" ) ?>" /><br /> <label
			for="serialnumber"
			<?php validateField( "serialnumber", $missingFields ) ?>>Serial
			Number *</label> <input type="text" name="serialnumber"
			id="serialnumber"
			value="<?php echo $guns->getValueEncoded( "serialnumber" ) ?>" /><br />

		<label for="description"
		<?php validateField( "description", $missingFields ) ?>>Description *</label>
		<input type="text" name="description" id="description"
			value="<?php echo $guns->getValueEncoded( "description" ) ?>" /><br />

		<label for="caliber"
		<?php validateField( "caliber", $missingFields ) ?>>Caliber *</label>
		<input type="text" name="caliber" id="caliber"
			value="<?php echo $guns->getValueEncoded( "caliber" ) ?>" /><br />
		<br />
		<?php } ?>
		
		<div style="clear: both;">
			<input type="submit" name="submitButton" id="submitButton"
				value="Send Details" /> <input type="reset" name="resetButton"
				id="resetButton" value="Reset Form" style="margin-right: 20px;" />
		</div>

	</div>
</form>
<br />

		<?php
		displayPageFooter();
}

function processForm() {
	//	echo "processForm... ";
	//$requiredFields = array( "username", "password", "emailAddress", "firstName", "lastName", "gender" );
	$requiredFields = array( "username", "password", "emailAddress", "firstName", "lastName", "zip5", "gender" );
	$missingFields = array();
	$errorMessages = array();
	$errorNumber = 0;
	$role = $_POST["role"];
	$option = $_POST["option"];
	// tjs 141114
	//$d=mktime(1, 1, 1, 12, 31, 1970);
	//echo "Created date is " . date("Y-m-d h:i:sa", $d);

	// debug
	//$handle = $_POST["handle"];
	//$username = $_POST["username"];
	//echo "Handle is " . $handle . " username is " . $username;
	$handleUsername = '';
	$handleName = '';
	$handleFound = false;
	$kabaMemberFound = false;
	$memberPassword = '';
	$sponsorId = "";
	$requirePasswords = true;
	//if (isset( $_POST["handle"] )) {
	if (isset( $_POST["handle"] ) && $role == 'private') {
		$handleFound = true;
		$handleName = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["handle"] );
		$handleUsername = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["handle"] ) . preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["zip5"] );
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
		if ( $sponsor = Member::getByUsername( $sponsorUsername ) ) {
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
			$now = date("YmdHis");
			$postedEmailAddress = $now . "@gunnerysergeant.org";
	 if ( isset( $_POST["emailAddress"] ) ) {
	 	$postedEmailAddress = preg_replace( "/[^ \@\.\-\_a-zA-Z0-9]/", "", $_POST["emailAddress"] );
	 	if ($role == 'private') {
	 		$postedEmailAddress = $handleUsername . "@gunnerysergeant.org";
	 	}
	 }
	
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
    	"emailaddress" => $postedEmailAddress,
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

         if ($handleFound) {
         	/*
      	    if (!$sponsor) {
      	    $sponsor = new Member( array() );
      	    }
      	    */
         	$kabaMemberId = 1;
         	//echo "kabaMemberId " . $kabaMemberId . " sponsorId " . $sponsorId;
         	$kaba = new Kaba( array(
    			"memberid" => $kabaMemberId,
    			"sponsorid" => $sponsorId,
  				"sergeantid" => "1",
    			"isinactive" => "0",
              	"handle" => $handleName 
         	) );

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
  				  
         }

         foreach ( $requiredFields as $requiredField ) {
         	if ( !$member->getValue( $requiredField ) ) {
         		$missingFields[] = $requiredField;
         	} else {
         		$field = $member->getValue( $requiredField );
         		if (strLen($field) == 0) {
         			$missingFields[] = $requiredField;
         		}
         	}
         }
         /*
          if ( $missingFields ) {
          echo "missing fields... ";
          $errorMessages[] = '<p class="error">There were some missing fields in the form you submitted. Please complete the fields highlighted below and click Send Details to resend the form.</p>';
          }
          */

         if ( $missingFields ) {
         	//echo "missing fields... ";
         	$errorMessages[] = '<p class="error">There were some missing fields in the form you submitted. Please complete the fields highlighted below and click Send Details to resend the form.</p>';
         	$errorNumber += 32;
         }
          
         //if ( !isset( $_POST["password1"] ) or !isset( $_POST["password2"] ) or !$_POST["password1"] or !$_POST["password2"] or ( $_POST["password1"] != $_POST["password2"] ) ) {
         if ( $requirePasswords and (!isset( $_POST["password1"] ) or !isset( $_POST["password2"] ) or !$_POST["password1"] or !$_POST["password2"] or ( $_POST["password1"] != $_POST["password2"] ) )) {
         	$errorMessages[] = '<p class="error">Please make sure you enter your password correctly in both password fields.</p>';
         	$errorNumber += 1;
         }

         if (Member::getByUsername( $member->getValue( "username" ) ) ) {
         	//echo "username exists... ";
         	if ($handleFound) {
         		$errorMessages[] = '<p class="error">A member in you zip code area with that handle already exists in the database. Please choose another handle.</p>';
         		$errorNumber += 2;
         	} else {
         		$errorMessages[] = '<p class="error">A member with that username already exists in the database. Please choose another username.</p>';
         		$errorNumber += 4;
         	}
         }

         //if ( Member::getByEmailAddress( $member->getValue( "emailAddress" ) ) ) {
         if ( Member::getByEmailAddress( $member->getValue( "emailaddress" ) ) ) {
         	//echo "email exists... ";
         	$errorMessages[] = '<p class="error">A member with that email address already exists in the database. Please choose another email address, or contact the webmaster to retrieve your password.</p>';
         	$errorNumber += 8;
         }

         // tjs 160709
         if (Kaba::findHandleByZipCode($handleName, $member->getValue( "zip5" ))) {
         	$errorMessages[] = '<p class="error">A member with that handle already exists for the same zip code in the database. Please choose another handle.</p>';
         	$errorNumber += 16;
         }

         //if ( $errorMessages ) {
         if ( $errorNumber > 0 ) {
      	   // displayForm( $errorMessages, $missingFields, $member );
      	   //displayForm( $errorMessages, $missingFields, $member, $sponsor, $kaba, $guns, $role, $option );
         	//, new Member( array() )
         	displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $gunInfo, $role, $option );

         	 
         	//echo "ERRORS errornumber " . $errorNumber;
         	/*
         	$errors = '<div class="w3-container w3-round w3-border w3-sand">';
         	$errors .= "<p>Errors detected (Use browser back button to correct form):</p>";
         	foreach($errorMessages as $error) {
         	$errors .= $error;
         	}
         	$errors .= "</div>";
         	*/
         	//echo "ERRORS " . $errors;
         	//echo  $errors;
         	//setcookie("errors", $errors);
         	//echo "ERROR Number " . $errorNumber;
         	//setcookie("errornumber", $errorNumber);
         	//echo " ERROR Number cookie set...";
         	/*
         	 $errors = '<div class="w3-container w3-round w3-border w3-sand">';
         	 $errors .= "<p>Errors detected (Use browser back button to correct form):</p>";
         	 foreach($errorMessages as $error) {
         	 $errors .= $error;
         	 }
         	 $errors .= "</div>";
         	 displayErrors($errors);*/
         	//displayErrors();
         	/*
         	<script>
         	<!--
         	location.replace("./enlist.html");
         	-->
         	</script>
         	*/
         	//displayForm( $errorMessages, $missingFields, $member );
         } else {
         	//echo "inserting... ";
          $member->insert();
          //displayThanks();
          if ($handleFound) {
          	//echo "inserting into kaba... ";
          	if ( $kabaMember = Member::getByUsername( $handleUsername ) ) {
          		$kabaMemberId = $kabaMember->getValue('id');
          		//echo "kabaMemberId " . $kabaMemberId . " sponsorId " . $sponsorId;
          		$kaba = new Kaba( array(
    						"memberid" => $kabaMemberId,
    						"sponsorid" => $sponsorId,
  							"sergeantid" => "1",
    						"isinactive" => "0",
              				"handle" => $handleName 
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
          displayThanks($role, $option);
         }
}

/*
 function displayErrors($errors) {
 foreach($errors as $error)	{
 echo $error;
 }
 }
 */
/*
 function displayErrors() {
 ?>
 <script>
 displayErrors();
 </script>
 <?php
 }
 */
function displayThanks($role, $option) {
	displayPageHeader( "Thanks for enlisting!" );
	?>
<p>Thank you, you are now an enlisted member of the GunnerySergeant Organization!</p>
<br />
<?php if ($role == 'private') { ?>
<?php if ($option == 1) { ?>
<p>
You have chosen to enlist as an 'uncertified' private.  This means that the only data
we have is your zip code and your handle (as well as information you supplied about
your gun).</p>
<p>
In the near future you will be assigned a GunnerySergeant (aka a GS).
</p>
<p>
Given your uncertified status, the GS can only reach you through your sponsor.
</p>
<p>
The GS will inform your sponsor the GS's own handle.  The GS will ask your sponsor
to convey the following information to you:
</p>
<ul>
<li>Your sponsor tells you the GS's handle.</li>
<li>Your sponsor asks you for a temporary password and resets your 'sign in' password to
the temporary one.</li>
<li>Your sponsor asks you to sign into gunnerysergeant.org (using the temporary password)
and then reset your password to a permanent password known only to you.</li>
<li>Your sponsor will suggest that you sign in and specify any additional guns you own
(in addition to the single gun specified during initial registration).</li>
</ul>
<p>
In the future all communications directed to you will be through your intermediary sponsor.
</p>
<p>
At any time, if you decide to become a certified private, you can sign in and change
your own profile.
</p>
<p>
A certified private must supply a means for direct communication from the GS.
Typically that means supply an email address and/or a phone number.
</p>
<p>
Once certified, the gun owner becomes eligible for benefits including:
</p>
<ul>
<li>Help from the GunnerySergeant Organization to locate any verified firearms you
own that become lost or stolen.</li>

<li>Partial insurance coverage for each gun listed that can be verified.</li>

<li>GunnerySergeant Organization offers private phone rebates for members that have an ISP
(Internet Service Provider).  Under certain plans, this benefit could reduce your
monthly fees (for example if you are charged for a phone, since the phone you
acquire thru us has no ISP related charges).</li>

<li>A member certificate that may be useful to present to retailers for appropriate discounts.</li>
</ul>
<?php } else if ($option == 2) { ?>
<p>You have chosen to enlist as an 'uncertified' private.</p>
<?php } else { ?>
<p>You have chosen to enlist as an 'first class' private (PFC).</p>

<?php } ?>

<?php } else if ($role == 'booster') { ?>
<?php if ($option == 1) { ?>
<p>You have chosen to enlist as a donor.</p>
<p>By default your profile settings are:</p>
<ul>
<li>We will likely send you 'reminder' solicitations for a donation yearly.</li>
<li>We will not share your contact information with like nonprofits.</li>
<li>We will not mail or email periodic news about our web site.</li>
</ul>
<p/>
<p>NOTE: At this time Gunnery Sergeant Organization cannot accept monitary contributions!
We are in the process of establishing ourselves as a nonprofit entity.</p>
<?php } else { ?>
<p>You have chosen to enlist as a collaborator.</p>
<p>The next step is that we will review your skill set and make suggestions about tasks where you could help us.  Our most pressing needs are: </p>
<ul>
<li>We need help to establish ourselves as a nonprofit.</li>
<li>We need a mailing address.</li>
<li>We currently are completely unfunded, so we need volunteers for roles that should typically be paid positions.</li>
</ul>
<p/>
<p>NOTE: At this time Gunnery Sergeant Organization coordinates tasks via
email, phone and our host provider's wiki <a class="w3-btn w3-round-large" href="https://collogistics.collogistics.com:3443">Collogistics.org</a>.</p>

<?php } ?>
<?php } else if ($role == 'sergeant') { ?>
<p>You have chosen to enlist as a Gunnery Sergeant (GS).</p>
<p>NOTE: At this time Gunnery Sergeant Organization, being a beta site, has not recruited the volunteer GS staffers!
The progress of the beta can be tracked via wiki <a class="w3-btn w3-round-large" href="https://collogistics.collogistics.com:3443">Collogistics.org</a>.</p>

<?php } else if ($role == 'sponsor') { ?>
<p>You have chosen to enlist as a sponsor.</p>
<p>The next step is to inform your friend (who owns a gun) what username you have specified for yourself.  Here's some steps: </p>
<ul>
<li>The friend can then enlist by simply specifying your handle and a few other facts (including information about his or her gun).</li>
<li>Alternately you could enlist your friend provided you know some details about his or her's gun.</li>
<li>If the friend enlists as an 'uncertified private', then, after enlistment, you can sign into his or her's account and change the password to some mutually agreed temporary (but secret) password.
Once changed the friend can sign in at any time and change the password to a permanent secret password known only to the friend.</li>
<li>The friend is always assigned a Gunnery Sergeant (aka GS).  The friend is typically direcly notified the handle for the GS.  However if the friend is an 'uncertified private' that information is passed to you (to convey to your friend).</li>
<li>The GS periodically contacts your friend directly. They never know each other's names. The handle is used for addressing each other (both have a handle).
An exception to this is for 'uncertified privates'.  In that case the GS can only communicate to your friend through you (an intermediary).  The GS never knows a think about you such as your username, email, phone, etc.  The GS can simply 'trigger' the system to send you information and/or make queries.</li>
</ul>
<p/>
<p>NOTE: At this time Gunnery Sergeant Organization, being a beta site, has not recruited the volunteer GS staffers!
The progress of the beta can be tracked via wiki <a class="w3-btn w3-round-large" href="https://collogistics.collogistics.com:3443">Collogistics.org</a>.</p>

<?php } ?>
	<?php
	displayPageFooter();
}

?>
</html>
