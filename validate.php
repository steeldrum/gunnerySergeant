<?php

date_default_timezone_set ( "America/New_York" );

require_once( "common.inc.php" );
require_once( "Kaba.class.php" );
require_once( "Guns.class.php" );

require_once( "xmlResponse.php" );

//include('./httpful.phar');

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

	case 'checkSponsorUsername':
		// ...
		// set the $retval message, and the $passed variable to true or false
		// TODO ensure sponsor doesn't sponsor any other private...
		$memberUsername = $_POST['value'];
		if ($member = Member::getByUsername( $memberUsername ) ) {
			//echo "username exists... ";
			//$retval = "A member with that username already exists in the database. Please choose another username.";
			$passed = true;
			$retval = "A member with that username will be asked to sponsor you!";
			$propertyId = "valid_sponsorusername";
			// OK so far but what if this sponsor already agreed to sponsor some other gun owner?
			$sponsorId = $member->getValue('id');
			if ($kaba = Kaba::getSponsoredKaba( $sponsorId ) ) {
				$passed = false;
				$kabaHandle = $kaba->getValue('handle');
				$retval = "Sorry. The sponsor with username $memberUsername is now sponsoring another gun owner with the handle $kabaHandle!";
			}
		} else {
			$retval = "Sorry. There is no member with that username to sponsor you!";
		}

		break;

			case 'checkMemberUsername':
		// ...
		// set the $retval message, and the $passed variable to true or false
		// TODO ensure sponsor doesn't sponsor any other private...
		$memberUsername = $_POST['value'];
		if ($member = Member::getByUsername( $memberUsername ) ) {
			//echo "username exists... ";
			//$retval = "A member with that username already exists in the database. Please choose another username.";
			$passed = true;
			$retval = "$memberUsername is a valid username of a member who has previously enlisted!";
			
			/*
			$retval = "A member with that username will be asked to sponsor you!";
			$propertyId = "valid_sponsorusername";
			// OK so far but what if this sponsor already agreed to sponsor some other gun owner?
			$sponsorId = $member->getValue('id');
			if ($kaba = Kaba::getSponsoredKaba( $sponsorId ) ) {
				$passed = false;
				$kabaHandle = $kaba->getValue('handle');
				$retval = "Sorry. The sponsor with username $memberUsername is now sponsoring another gun owner with the handle $kabaHandle!";
			}*/
		} else {
			$retval = "Sorry. There is no member with that username!";
		}

		break;
		
	case 'checkHandle':
		// ...
		// set the $retval message, and the $passed variable to true or false
		// TODO ensure sponsor doesn't sponsor any other private...
		$valuePosted = $_POST['value'];
		//echo "validate checkHandle value " . $valuePosted;
		// parse the CamelCased words
		$keywords = preg_split("/(?=[A-Z])/", $valuePosted);
		 
		//$passed = true;
		$propertyId = "valid_handle";
		//$retval = "$valuePosted words: ";

		$allWordsPermitted = true;
		foreach ($keywords as $item) {
			$wordPermitted = checkWord($item);
			if (!$wordPermitted) {
				$allWordsPermitted = false;
				break;
			}
			//$retval .= "$item|";
			//$retval = $item;
		}

		if (!$allWordsPermitted) {
			$retval = "Sorry. A handle cannot contain inappropriate wording!";
		} else {
			// now ensure the handle hasn't already been used (within the same zip code)
			$passed = true;
			$retval = "The specified handle is OK to use!";
		}
		/*
		 *
		 $memberUsername = $_POST['value'];
		 if ($member = Member::getByUsername( $memberUsername ) ) {
		 //echo "username exists... ";
		 //$retval = "A member with that username already exists in the database. Please choose another username.";
		 $passed = true;
		 $retval = "A member with that username will be asked to sponsor you!";
		 $propertyId = "valid_sponsorusername";
		 // OK so far but what if this sponsor already agreed to sponsor some other gun owner?
		 $sponsorId = $member->getValue('id');
		 if ($kaba = Kaba::getSponsoredKaba( $sponsorId ) ) {
		 $passed = false;
		 $kabaHandle = $kaba->getValue('handle');
		 $retval = "Sorry. The sponsor with username $memberUsername is now sponsoring another gun owner with the handle $kabaHandle!";
		 }
		 } else {
		 $retval = "Sorry. There is no member with that username to sponsor you!";
		 }
		 */
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

function checkWord ($word) {
	$wordPermitted = true;
	$tabooWords = array("boobs", "cock", "cunt", "faggot", "fuck", "kike", "nigger", "piss", "prick", "pussy", "shit", "slut", "tits", "whore", "yid");
	foreach($tabooWords as $tabooWord) {
		$pos = strripos($word, $tabooWord);
		if ($pos === false) {
			continue;
		} else {
			$wordPermitted = false;
			break;
		}
	}	 
	return $wordPermitted;
}
?>