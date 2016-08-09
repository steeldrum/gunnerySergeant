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

//echo " memberProfileManager";

date_default_timezone_set ( "America/New_York" );

require_once( "common.inc.php" );
require_once( "Kaba.class.php" );
require_once( "Guns.class.php" );
require_once( "Sergeant.class.php" );
// tjs 160727
require_once( "query.php" );

if ( isset( $_POST["action"] ) and $_POST["action"] == "update" ) {
	//echo "processForm...";
	processForm();
} else {
	//displayForm( array(), array(), new Member( array() ) );
	//echo " display form...";
	displayForm( array(), array(), new Member( array() ), new Kaba( array() ), new Member( array() ), new Guns( array() ), $_GET["role"], $_GET["option"], $_GET["token"] );
	 
	//echo "displayErrors...";
	//displayErrors();
}

//function displayForm( $errorMessages, $missingFields, $member ) {
function displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $guns, $role, $option, $token) {
	
	if ($token < 0) {
		displayPageHeader( "Member services login for the Gunnery Sergeant Organization!" );
	} else {
	//displayPageHeader( "Sign up for the book club!" );
		displayPageHeader( "Member services management of the Gunnery Sergeant Organization!" );
	}
	
	if ( $errorMessages ) {
		foreach ( $errorMessages as $errorMessage ) {
			echo $errorMessage;
		}
	} else if ($token < 0) {
		?>
<p>Member Login for the Gunnery Sergeant Organization.</p>		
		<?php } else { ?>
<p>Members of the Gunnery Sergeant Organization have the opportunity to manage services.</p>
<?php if ($role != 'unknown' && $option == 0) { ?>
<p>Your profile can be altered with appropriate options for your role: <?php echo $role; ?>.</p>
<?php } ?>
<p>To manage your service or update your profile, please fill in your details below and click Send Details.</p>
<p>Fields marked with an asterisk (*) are required.</p>
		<?php } ?>

<form action="memberProfileManager.php" method="post" style="margin-bottom: 50px;">
	<div style="width: 30em;">
		<input type="hidden" name="action" value="update" />
		 <input type="hidden" name="role" value="<?php echo $role; ?>" />
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
			
			<?php if ($token < 0) { ?>
				
		<label for="username"
		<?php validateField( "username", $missingFields ) ?>>Username
			*</label>
		<p>
			<input type="text" name="username" id="username"
				value="<?php echo $member->getValueEncoded( "username" ) ?>"
				onchange="callAjax('checkMemberUsername', this.value, this.id);" />&nbsp;<input
				class="valid" id="valid_username" type="checkbox" disabled
				name="valid_username">
		</p>
		<div class="rsp_message" id="rsp_username">
			<!-- -->
		</div>
			
			 <label
			for="password" <?php if ( $missingFields ) echo ' class="error"' ?>>Password
			 *</label> <input type="password" name="password"
			id="password" value="" />
					
		<?php } else if ($token > 0) {	
			if ($member = Member::getMember( $token ) ) {		?>
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
		<p>Welcome <?php echo $member->getValue('firstname'); ?></p>
<?php switch ($option) { 
	case 0: ?>
		<label>Choose a task:
			*</label> 
<!-- select option based on role choises:
 sponsoredPrivate
certifiedPrivate
PFC
sponsoredSergeant
sergeant
sponsor
booster
 -->
<?php switch ($role) { 
    case 'sponsoredPrivate':
        //echo "sponsoredPrivate";
        ?>
<label class="radioLabel">Edit Guns</label>
            <input class="radioInput" type="radio" name="task" value="9" disabled/>
        
        <?php
        break;
    case 'certifiedPrivate':
        //echo "certifiedPrivate";
        ?>
<label class="radioLabel">Edit Guns</label>
    <input class="radioInput" type="radio" name="task" value="9" disabled/>
        
        <?php
        break;
            case 'PFC':
        //echo "PFC";
        ?>
<label class="radioLabel">Edit Guns</label>
    <input class="radioInput" type="radio" name="task" value="9" disabled/>
        
        <?php
        break;
            case 'sponsoredSergeant':
        //echo "sponsoredSergeant";
        ?>
<label class="radioLabel">Log Conversation</label>
    <input class="radioInput" type="radio" name="task" value="12" disabled/>
<label class="radioLabel">View Platoon</label>
    <input class="radioInput" type="radio" name="task" value="11"/>
<label class="radioLabel">View Logs</label>
    <input class="radioInput" type="radio" name="task" value="10" disabled/>
<label class="radioLabel">Edit Guns</label>
    <input class="radioInput" type="radio" name="task" value="9" disabled/>
        
        <?php
        break;
            case 'sergeant':
        //echo "sergeant";
        ?>
 <label class="radioLabel">Log Conversation</label>
    <input class="radioInput" type="radio" name="task" value="12" disabled/>
<label class="radioLabel">View Platoon</label>
    <input class="radioInput" type="radio" name="task" value="11"/>
<label class="radioLabel">View Logs</label>
    <input class="radioInput" type="radio" name="task" value="10" disabled/>
         
        <?php
        break;
            case 'sponsor':
        //echo "sponsor";
        ?>
<label class="radioLabel">Remove Sponsorship</label>
    <input class="radioInput" type="radio" name="task" value="13" disabled/>
        
        <?php
        break;
            case 'booster':
        //echo "booster";
        break;
            case 'admin':
        //echo "admin";
        ?>
<label class="radioLabel">Assign Member GS</label>
    <input class="radioInput" type="radio" name="task" value="21"/>
<label class="radioLabel">View/Edit Members</label>
    <input class="radioInput" type="radio" name="task" value="22"/>
        
        <?php
        break;        
} ?>

<label class="radioLabel">Change Prefs</label>
    <input class="radioInput" type="radio" name="task" value="8" disabled/>

<label class="radioLabel">Change Skills</label>
    <input class="radioInput" type="radio" name="task" value="7" disabled/>

<label class="radioLabel">Change Email</label>
    <input class="radioInput" type="radio" name="task" value="6"/>

<label class="radioLabel">Change Phone</label>
    <input class="radioInput" type="radio" name="task" value="5"/>

<label class="radioLabel">Change Address</label>
<input class="radioInput" type="radio" name="task" value="4" checked/>

<label class="radioLabel">Change Name</label>
<input class="radioInput" type="radio" name="task" value="3"/>

<label class="radioLabel">Change Password</label>
<input class="radioInput" type="radio" name="task" value="2" disabled/>

<label class="radioLabel">Resign</label>
<input class="radioInput" type="radio" name="task" value="98" disabled/>

<label class="radioLabel">Sign Off</label>
<input class="radioInput" type="radio" name="task" value="99"/>

<br/>

<?php break;
	case 1:
	if ($role == 'booster') {
	?>
<p>Collaborator requesting promotion to become a Gunnery Sergeant...</p>
<?php } else if ($role == 'PFC') { ?>
			<p>Private (PFC) requesting promotion to become a Gunnery Sergeant...</p>
<?php } ?>
<p>To request becomming a GS, please fill in your details below and click Send Details.</p>
<p>Fields marked with an asterisk (*) are required.</p>
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
		
			<?php break;  // end option 1
			case 2: ?>
					<input type="hidden" name="task" value="2" />
			<?php 
			
			break;
			case 3: //Change Name ?>
			 <label
			for="firstName" <?php validateField( "firstName", $missingFields ) ?>>First
			name *</label> <input type="text" name="firstName" id="firstName"
			value="<?php echo $member->getValueEncoded( "firstName" ) ?>" /> 
			<label
			for="lastName" <?php validateField( "lastName", $missingFields ) ?>>Last
			name *</label> <input type="text" name="lastName" id="lastName"
			value="<?php echo $member->getValueEncoded( "lastName" ) ?>" />
			<?php 
			
			break;
			case 4: ?>
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
							<label for="zip5" <?php validateField( "zip5", $missingFields ) ?>>Zip
			code *</label> <input type="text" name="zip5" id="zip5"
			value="<?php echo $member->getValueEncoded( "zip5" ) ?>"
			onchange="this.value = /^([0-9]{5})$/.test(this.value)? this.value : ''; valid_zip5.checked = this.value;" />&nbsp;<input
			class="valid" type="checkbox" disabled name="valid_zip5" />
					
			<?php 
			
			break;
			case 5: ?>
			<label for="phone" <?php validateField( "phone", $missingFields ) ?>>Phone
			 *</label> <input type="text" name="phone" id="phone"
			value="<?php echo $member->getValueEncoded( "phone" ) ?>"
			onchange="this.value = /^\D?(\d{3})\D?\D?(\d{3})\D?(\d{4})$/.test(this.value)? this.value.replace(/[^0-9]+/g, '') : ''; valid_phone.checked = this.value;" />&nbsp;<input
			class="valid" type="checkbox" disabled name="valid_phone" />
			<?php 
			
			break;
			case 6: ?>
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
		<?php 
			
			break;
			case 7: ?>
					<input type="hidden" name="task" value="7" />
			<?php 
			
			break;
			case 8: ?>
					<input type="hidden" name="task" value="8" />
			<?php 
			
			break;
			case 9: ?>
					<input type="hidden" name="task" value="9" />
			<?php 
			
			break;
			case 10: ?>
					<input type="hidden" name="task" value="10" />
			<?php 
			
			break;
			
			//View Platoon
			case 11: ?>
					<input type="hidden" name="task" value="11" />
			<?php 
			queryForSergeantPlatoon($token);
			
			break;
			case 12: ?>
					<input type="hidden" name="task" value="12" />
			<?php 
			
			break;
			case 13: ?>
					<input type="hidden" name="task" value="13" />
			<?php 
			
			break;
			case 21: ?>
			<p>To assign gun owner to sergeant, specify the common zip code and owner, sergeant respective handles.</p>
					<input type="hidden" name="task" value="21" />
					
			<?php 
			queryForKabaSergeantMatches();
			
			break;
			case 22: ?>
			<script>
				memberServices('admin', 22);
			</script>
			
			<?php 
			case 98: ?>
					<input type="hidden" name="task" value="98" />
			<?php 
			
			break;
			case 99: ?>
					<input type="hidden" name="task" value="99" />
			<?php 
			break;
} // end options ?>


			<?php } // end found member ?>
					
			<?php } // end token > 0 ?>
		
		<div style="clear: both;">
		
		<?php if ($option == 11) { ?>
			<input type="submit" name="submitButton" id="submitButton"
				value="Done" /> 
		<?php } else { ?>
			<input type="submit" name="submitButton" id="submitButton"
				value="Send Details" /> <input type="reset" name="resetButton"
				id="resetButton" value="Reset Form" style="margin-right: 20px;" />
		<?php } ?>
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
	$role = $_POST["role"];
	$option = $_POST["option"];
	$token = $_POST["token"];
	$loggedIn = true;
	$requiredFields = array();
	$missingFields = array();
	$errorMessages = array();
	$errorNumber = 0;
	if ($token < 0) {
		$loggedIn = false;
		$requiredFields = array( "username", "password" );		
	} else {
		// logged in choosing a task...
		//echo " processForm option $option\n";
		switch($option) {
			case 0:
				$requiredFields = array( "task");
			if (isset( $_POST["task"] )) {
				$option = $_POST["task"];
				//echo " processForm task $option\n";
				if ($option == 99) {
					$role = 'unknown';
					$option = 0;
					$token = -1;
					//displayForm( $errorMessages, $missingFields, new Member( array() ), new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, $option, $token );					
				}				
				displayForm( $errorMessages, $missingFields, new Member( array() ), new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, $option, $token );					
			} else {
				$errorMessages[] = '<p class="error">Please make sure you enter your task option correctly.</p>';				
			}
         	//displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $gunInfo, $role, $option, $token );
         	break;

         	//Change Password
         	case 2:
         	displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $gunInfo, $role, $option, $token );
         	break;

         	//Change Name
         	case 3:
         		if ( $member = Member::getMember( $token ) ) {
         		  	$newFirstname = isset( $_POST["firstName"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["firstName"] ) : "unknown";
         		  	$oldFirstname = $member->getValueEncoded( "firstName" );
    				$newLastname = isset( $_POST["lastName"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["lastName"] ) : "unknown";
					//echo " processForm new first $newFirstname old name $oldFirstname\n";
    				$member->setFirstName($newFirstname);
         		 	$member->setLastName($newLastname);
					//echo " processForm member firstname now " . $member->getValueEncoded( "firstName" );
    				//echo " processForm update...\n";
         		 	$member->update();
         		 	// back to options         		 	
         			displayForm( $errorMessages, $missingFields, $member, new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, 0, $token );
         		} else {
					displayForm( $errorMessages, $missingFields, new Member( array() ), new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, 0, $token );					
         		}
         	break;

         	//Change Address
         	case 4:
         		if ( $member = Member::getMember( $token ) ) {
         			$newStreet1 = isset( $_POST["street1"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["street1"] ) : "unknown";
         			$newStreet2 = isset( $_POST["street2"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["street2"] ) : "unknown";
         			$newCity = isset( $_POST["city"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["city"] ) : "unknown";
         			$newStateName = isset( $_POST["statename"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["statename"] ) : "";
        			$newZip5 = isset( $_POST["zip5"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["zip5"] ) : "00000";
    				$member->setStreet1($newStreet1);
        			$member->setStreet2($newStreet2);
    				$member->setCity($newCity);
        			$member->setStateName($newStateName);
    				$member->setZip5($newZip5);
        			$member->update();    				    				
         			displayForm( $errorMessages, $missingFields, $member, new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, 0, $token );
         		} else {
					displayForm( $errorMessages, $missingFields, new Member( array() ), new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, 0, $token );					
         		}
			break;         	
         	//Change Phone
         	case 5:
         		if ( $member = Member::getMember( $token ) ) {
         			$newPhone = isset( $_POST["phone"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["phone"] ) : "unknown";
    				$member->setPhone($newPhone);
        			$member->update();    				    				
         			displayForm( $errorMessages, $missingFields, $member, new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, 0, $token );
         		} else {
					displayForm( $errorMessages, $missingFields, new Member( array() ), new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, 0, $token );					
         		}
         	break;
         	
         	//Change Email
         	case 6:
         		if ( $member = Member::getMember( $token ) ) {
         			$now = date("YmdHis");
					$postedEmailAddress = $now . "@gunnerysergeant.org";
	 				if ( isset( $_POST["emailAddress"] ) ) {
	 					$postedEmailAddress = preg_replace( "/[^ \@\.\-\_a-zA-Z0-9]/", "", $_POST["emailAddress"] );
	 				}
					//echo " processForm new email $postedEmailAddress\n";
	 				         			//$newEmail = isset( $_POST["emailAddress"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["emailAddress"] ) : "unknown";
    				//$member->setEmail($newEmail);
	 				$member->setEmail($postedEmailAddress);
        			$member->update();    				    				
         			displayForm( $errorMessages, $missingFields, $member, new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, 0, $token );
         		} else {
					displayForm( $errorMessages, $missingFields, new Member( array() ), new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, 0, $token );					
         		}
         	break;
         	
         	//Change Skills
         	case 7:
         	displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $gunInfo, $role, $option, $token );
         	break;
         	
         	//Change Prefs
         	case 8:
         	displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $gunInfo, $role, $option, $token );
         	break;
         	
         	//Edit Guns
         	case 9:
         	displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $gunInfo, $role, $option, $token );
         	break;
         	
         	//View Logs
         	case 10:
         	displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $gunInfo, $role, $option, $token );
         	break;
         	
         	//View Platoon
         	case 11:
         		if ( $member = Member::getMember( $token ) ) {
         			displayForm( $errorMessages, $missingFields, $member, new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, 0, $token );
         		} else {
					displayForm( $errorMessages, $missingFields, new Member( array() ), new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, 0, $token );					
         		}
         		break;
         	
         	//Log Conversation
         	case 12:
         	displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $gunInfo, $role, $option, $token );
         	break;
         	
         	//Remove Sponsorship
         	case 13:
         	displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $gunInfo, $role, $option, $token );
         	break;
         	/*
         	case 14:
         	displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $gunInfo, $role, $option, $token );
         	break;
         	
         	case 15:
         	displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $gunInfo, $role, $option, $token );
         	break;
         	*/
         	//Assign Member GS
         	case 21:
	 			if ( isset( $_POST["zip"] ) ) {
	 					//          "zip5" => isset( $_POST["zip5"] ) ? preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["zip5"] ) : "",	 					
	 				$zip = preg_replace( "/[^ \@\.\-\_a-zA-Z0-9]/", "", $_POST["zip"] );
	 				if (isset( $_POST["sarge"] )) {
						$sarge = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["sarge"] );
	 					if (isset( $_POST["kaba"] )) {
							$kaba = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["kaba"] );
							Kaba::updateGSIDByHandleZipCodeGSHandle( $kaba, $zip, $sarge );							
						} 
	 				} 
	 			}
         		if ( $member = Member::getMember( $token ) ) {
         			displayForm( $errorMessages, $missingFields, $member, new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, 0, $token );
         		} else {
					displayForm( $errorMessages, $missingFields, new Member( array() ), new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, 0, $token );					
         		}
	 		break;         	         	

	 		//View/Edit Members
         	case 22:

	 		break;         	         	
	 		
		    //Resign
         	case 98:
         	displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $gunInfo, $role, $option, $token );
         	break;         	         	
		
		    //Sign Off
         	case 99:
         	displayForm( $errorMessages, $missingFields, $member, $kaba, $sponsor, $gunInfo, $role, $option, $token );
         	break;         	         	
		}
	}
	//echo "processForm role $role option $option token $token logged in? $loggedIn\n";
	
	//$requiredFields = array( "username", "password", "emailAddress", "firstName", "lastName", "zip5", "gender" );
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
	// tjs 160715
	//if (isset( $_POST["handle"] ) && $role == 'private') {
	if (isset( $_POST["handle"] ) && $role == 'private') {
		$handleFound = true;
		$handleName = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["handle"] );
		$handleUsername = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["handle"] ) . preg_replace( "/[^ \'\-a-zA-Z0-9]/", "", $_POST["zip5"] );
	} else if (isset( $_POST["handle"] ) && $role == 'sergeant' && (integer) $token > 0) {
		$handleFound = true;
		$handleName = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["handle"] );
		if ( $member = Member::getMember( (integer) $token ) ) {
			$zip5 = $member->getValue('zip5');
		}		
		$handleUsername = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["handle"] ) . $zip5;
		
		if (Kaba::findHandleByZipCode($handleName, $zip5)) {
         	$errorMessages[] = '<p class="error">A member with that handle already exists for the same zip code in the database. Please choose another handle.</p>';
         	$errorNumber += 16;
         } else {
         	if (Sergeant::getByHandle( $handleName )) {
         		$errorMessages[] = '<p class="error">A sergeant with that handle already exists in the database. Please choose another handle.</p>';
         		$errorNumber += 64;         		
         	} else {
          		$sergeant = new Sergeant( array(
    						"memberid" => $token,
  							"platooncap" => "10",
    						"isinactive" => "0",
              				"handle" => $handleName 
          		) );
          		$sergeant->insert();
          		displayThanks($role, $option, $token, $loggedIn);         		
         	}
         }
		
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
	} else if (isset( $_POST["password"] ) ) {
		$memberPassword = preg_replace( "/[^ \-\_a-zA-Z0-9]/", "", $_POST["password"] );
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
	
	 //echo "processForm handleUsername $handleUsername\n";
     if ( $member = Member::getByUsername( $handleUsername ) ) {
     	//TODO
		//echo " processForm token before retrieved id $token\n";
     	if ((integer) $token < 0) {
     		$token = $member->getValue('id');
			//echo " processForm token $token\n";
     	}
     }

     if ($loggedIn) {
         //echo "Created date is " . date("Y-m-d h:i:sa", $d);

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

 
         	//displayForm( $errorMessages, $missingFields, $member );
         } else {
         	//echo "inserting... ";
          $member->update();
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


          	}  // kabaMember exists
          } // handle found
          displayThanks($role, $option, $token, $loggedIn);
         } // no errors
     } else { // not loggedIn yet
     	//tjs160722
     	//possible role unknown...
     	echo " processForm before role derived id $token role $role\n";    		
     	if ($role == 'unknown') {
     		$role = Member::getMemberRole($token);
     		$option = 0;
     		//TODO
     		//echo " processForm token after retrieved id $token role $role\n";    		
     	}
     	displayForm( array(), array(), new Member( array() ), new Kaba( array() ), new Member( array() ), new Guns( array() ), $role, $option, $token );    	
     }
}


function displayThanks($role, $option, $token, $loggedIn) {
	displayPageHeader( "Thanks for updating your profile!" );
	?>
<p>Thank you, your changes have been completed and processed by the GunnerySergeant Organization!</p>
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
<?php if ($option == 1) { ?>
<p>Your promotion request to become a Gunnery Sergeant (GS) is being processed.</p>
<p>NOTE: At this time Gunnery Sergeant Organization, being a beta site, is not actively recruiting volunteer GS staffers!
The progress of the beta can be tracked via wiki <a class="w3-btn w3-round-large" href="https://collogistics.collogistics.com:3443">Collogistics.org</a>.</p>

<?php } else if ($option == 2) { ?>

<?php } else { ?>
<p>You have chosen to enlist as a Gunnery Sergeant (GS).</p>
<p>NOTE: At this time Gunnery Sergeant Organization, being a beta site, has not recruited the volunteer GS staffers!
The progress of the beta can be tracked via wiki <a class="w3-btn w3-round-large" href="https://collogistics.collogistics.com:3443">Collogistics.org</a>.</p>
<?php } ?>

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
