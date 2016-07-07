<?php

date_default_timezone_set ( "America/New_York" );

require_once( "common.inc.php" );
require_once( "Kaba.class.php" );
require_once( "Guns.class.php" );

require_once( "xmlResponse.php" );

//require_once( "xmlResponse.class.php" );

// check that all POST variables have been set

  if(!isset($_POST['method']) || !$method = $_POST['method']) exit;
  if(!isset($_POST['value']) || !$value = $_POST['value']) exit;
  if(!isset($_POST['target']) || !$target = $_POST['target']) exit;
  
  $passed = false;
  $retval = '';
// tjs 160707
$propertyId = '';
  
  //echo " memberUsername " . $memberUsername;
//echo " validate initial passed? " . $passed;

  switch($method) {
    case 'checkUsername':
      // ...
      // set the $retval message, and the $passed variable to true or false
     	$memberUsername = $_POST['value'];
    	if (Member::getByUsername( $memberUsername ) ) {
              	//echo "username exists... ";
              	//$retval = "A member with that username already exists in the database. Please choose another username.";
      	$retval = "A member with that username already exists!";
      } else {
      	$passed = true;
      	$retval = "Username is valid!";
      	$propertyId = "valid_username";
      }
    	
      break;

    case 'checkEmail':
      // ...
      // set the $retval message, and the $passed variable to true or false
      // ...
      //$retval = "email syntax must include at sign!";
           	$memberEmail = $_POST['value'];
    	if (Member::getByEmailAddress( $memberEmail ) ) {
              	//echo "username exists... ";
              	//$retval = "A member with that username already exists in the database. Please choose another username.";
      	$retval = "A member with that email address already exists!";
      } else {
      	$passed = true;
      	$retval = "Email is valid!";
      	$propertyId = "valid_email";
      }
    	
      break;

    default: exit;
  }

  //echo " validate final passed? " . $passed;
  
 // include "class.xmlResponse.php";
//  include "class.xmlresponse.php";
 // echo " validate retval " . $retval;
 //echo " validate retval htmlentities " . htmlentities($retval);
// echo " validate class.xmlResponse.php ";
 
     $xml = new xmlResponse();
  //echo " validate new xmlResponse done...";
$xml->start();

if (!$passed) {
 $xml->command('setcontent',
    array('target' => "rsp_$target", 'content' => htmlentities($retval))
    );

     $xml->command('setstyle',
    array('target' => "rsp_$target", 'property' => 'color', 'value' => 'red')
    );
} else {
 $xml->command('setcontent',
	array('target' => "rsp_$target", 'content' => htmlentities($retval))
    );

     $xml->command('setstyle',
    array('target' => "rsp_$target", 'property' => 'color', 'value' => 'green')
    );
	
    if (strlen($propertyId) > 0) {
     $xml->command('setproperty',
     array('target' => $propertyId, 'property' => 'checked', 'value' => 'true')
    );
    	
    }
}  
    $xml->endxml();

?>