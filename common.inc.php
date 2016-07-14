<?php
/***************************************
$Revision:: 148                        $: Revision of last commit
$LastChangedBy::                       $: Author of last commit
$LastChangedDate:: 2011-10-31 11:39:02#$: Date of last commit
***************************************/
/*
Collaborators/
common.inc.php
tjs 101012

file version 1.01 

release version 1.12
*/

require_once( "config.php" );
require_once( "Member.class.php" );
//require_once( "Ad.class.php" );
//require_once( "LogEntry.class.php" );

function displayPageHeader( $pageTitle, $membersArea = false ) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
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
	<div class="w3-container w3-brown">
    <h1><?php echo $pageTitle?></h1>
    </div>
    <div class="w3-container w3-round w3-border w3-sand"> 
    
<?php
}

function displayPageFooter() {
?>
</div>
	<footer class="w3-container w3-round w3-border w3-brown">
	<div class="w3-container w3-center">
		<a style="margin: 10px 0 10px 0"; class="w3-btn w3-round-large" href="./index.html"> <img
			border="0" alt="Home" src="assets/images/HomeSBC.jpg" width="100"
			height="30"> </a>
	</div>
	</footer>
  </body>
</html>
<?php
}

function validateField( $fieldName, $missingFields ) {
  if ( in_array( $fieldName, $missingFields ) ) {
    echo ' class="error"';
  }
}

function setChecked( DataObject $obj, $fieldName, $fieldValue ) {
  if ( $obj->getValue( $fieldName ) == $fieldValue ) {
    echo ' checked="checked"';
  }
}

function setSelected( DataObject $obj, $fieldName, $fieldValue ) {
  if ( $obj->getValue( $fieldName ) == $fieldValue ) {
    echo ' selected="selected"';
  }
}

function checkLogin() {
  session_start();
  if ( !$_SESSION["member"] or !$_SESSION["member"] = Member::getMember( $_SESSION["member"]->getValue( "id" ) ) ) {
    $_SESSION["member"] = "";
    header( "Location: login.php" );
    exit;
  } else {
    $logEntry = new LogEntry( array (
      "memberid" => $_SESSION["member"]->getValue( "id" ),
      "pageurl" => basename( $_SERVER["PHP_SELF"] )
    ) );
    $logEntry->record();
  }
}


?>
