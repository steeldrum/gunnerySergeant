<?php
/***************************************
 $Revision:: 156                        $: Revision of last commit
 $LastChangedBy::                       $: Author of last commit
 $LastChangedDate:: 2011-11-18 13:51:23#$: Date of last commit
 ***************************************/
/*
 Collaborators/
 Member.class.php
 tjs 101012

 file version 1.00

 release version 1.06
 */

require_once "DataObject.class.php";

date_default_timezone_set ( "America/New_York" );

class Member extends DataObject {

	protected $data = array(
    "id" => "",
    "username" => "",
    "password" => "",
    "firstname" => "",
    "lastname" => "",
    "street1" => "",
	    "street2" => "",
        "city" => "",
	        "statename" => "",
    "phone" => "",
	"joindate" => "",
    "gender" => "",
    "primaryskillarea" => "",
    "emailaddress" => "",
    "otherskills" => "",
    "registered" => "",
    "lastlogindate" => "",
    "confidential" => "",
    "remindergap" => "",
    "intentionaldonor" => "",
    "subscriber" => "",
    "passwordmnemonicquestion" => "",
    "passwordmnemonicanswer" => "",
    "isinactive" => "",
   "zip5" => "",
    "zip4" => ""
    );

    // tjs 101012
    // "favoriteGenre" => "",

    //	primarySkillArea	ENUM( 'accounting', 'administration', 'architecture', 'art',
    // 'clergy', 'contracting', 'culinary', 'education', 'engineering', 'health',
    // 'labor', 'legal', 'management', 'music', 'politics', 'professional', 'retailing',
    // 'software', 'trades', 'other' ) NOT NULL,

    // tjs 160805
    //private $_skills = array(
    protected $_skills = array(
    "accounting" => "Accounting",
    "administration" => "Administration",
    "architecture" => "Architecture",
    "art" => "Art",
    "clergy" => "Clergy",
    "contracting" => "Contracting",
    "culinary" => "Culinary",
    "education" => "Education",
    "engineering" => "Engineering",
    "health" => "Health",
    "labor" => "Labor",
    "legal" => "Legal",
    "management" => "Management",
    "music" => "Music",
    "politics" => "Politics",
    "professional" => "Professional",
    "retailing" => "Retailing",
    "software" => "Software",
    "trades" => "Trades",
    "other" => "Other"
    );

    
    public static function getMembers( $startRow, $numRows, $order ) {
     //echo "connecting...";
    	$conn = parent::connect();
    	// tjs 130719 for postgreSQL conversion
     //echo "connected...";
    	//$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_MEMBERS . " ORDER BY $order LIMIT :startRow, :numRows";
    	$sql = "SELECT * FROM " . TBL_MEMBERS . " ORDER BY $order OFFSET :startRow LIMIT :numRows";
    	$rowCount = 0;

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":startRow", $startRow, PDO::PARAM_INT );
      $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
      $st->execute();
      $members = array();
      foreach ( $st->fetchAll() as $row ) {
      	$members[] = new Member( $row );
      	// tjs 130719
      	$rowCount++;
      }
      //echo "rowCount $rowCount";
      // tjs 130719
      //$st = $conn->query( "SELECT found_rows() as totalRows" );
      //$row = $st->fetch();
      parent::disconnect( $conn );
      //return array( $members, $row["totalRows"] );
     // $totalRows = Member::getMemberCount();
      //$totalRows = 74;
      //echo " totalRows $totalRows";
      return array( $members, $rowCount );
      //return array( $members, $rowCount, $totalRows );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    }

    public static function getMember( $id ) {
    	$conn = parent::connect();
    	$sql = "SELECT * FROM " . TBL_MEMBERS . " WHERE id = :id";

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id", $id, PDO::PARAM_INT );
      $st->execute();
      $row = $st->fetch();
      parent::disconnect( $conn );
      if ( $row ) return new Member( $row );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    }

    // tjs 140206
    public static function isMemberAdmin( $memberId ) {
    	// hack for test:
    	if ($memberId == 1) {
    		return true;
    	} else {
    		return false;
    	}
    }

    // tjs 160722
    public static function isSponsorMember( $memberId ) {
    	$conn = parent::connect();
    	$sql = "SELECT * FROM " . TBL_KABAS . " WHERE sponsorId = :id";

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id", $memberId, PDO::PARAM_INT );
      $st->execute();
      $row = $st->fetch();
      parent::disconnect( $conn );
      if ( $row ) return true;
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    	return false;
    }

    public static function isSergeantMember( $memberId ) {
    	$conn = parent::connect();
    	$sql = "SELECT * FROM " . TBL_SERGEANTS . " WHERE memberId = :id";

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id", $memberId, PDO::PARAM_INT );
      $st->execute();
      $row = $st->fetch();
      parent::disconnect( $conn );
      if ( $row ) return true;
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    	return false;
    }

    public static function isKabaMember( $memberId ) {
    	$conn = parent::connect();
    	$sql = "SELECT * FROM " . TBL_KABAS . " WHERE memberId = :id";

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id", $memberId, PDO::PARAM_INT );
      $st->execute();
      $row = $st->fetch();
      parent::disconnect( $conn );
      if ( $row ) return true;
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    	return false;
    }

    /*
     * sponsoredPrivate
certifiedPrivate
PFC
sponsoredSergeant
sergeant
sponsor
booster
    */
    public static function getMemberRole( $memberId ) {
    		// TBD isAdmin? this is temp code...
    	if ($memberId == 1) {
    			return 'admin';
    		} else 
    	if (Member::isSponsorMember( $memberId )) {
    		return 'sponsor';
    	} else if (Member::isSergeantMember( $memberId )) {
    		if (Member::isKabaMember( $memberId )) {
    			return 'sponsoredSergeant';
    		} else {
    			return 'sergeant';
    		}
    	} else if (Member::isKabaMember( $memberId )) {
    		$member = Member::getMember( $memberId );
    		$firstname = $member->getValue('firstname');
    		if ($firstname == 'unknown') {
    			$email = $member->getValue('emailaddress');
    			$email = preg_replace('/\d+/', '', $email);    			
    			if ($email == '@gunnerysergeant.org') {
    				return 'sponsoredPrivate';
    			} else {
    				return 'certifiedPrivate';
    			}
    		} else {
    			return 'PFC';
    		}
    	} else {
    			return 'booster';
    	}
    }
    
    public static function getByUsername( $username ) {
    	$conn = parent::connect();
    	$sql = "SELECT * FROM " . TBL_MEMBERS . " WHERE username = :username";

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":username", $username, PDO::PARAM_STR );
      $st->execute();
      $row = $st->fetch();
      parent::disconnect( $conn );
      if ( $row ) return new Member( $row );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    }

    public static function getByEmailAddress( $emailAddress ) {
    	$conn = parent::connect();
    	$sql = "SELECT * FROM " . TBL_MEMBERS . " WHERE emailaddress = :emailAddress";

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":emailAddress", $emailAddress, PDO::PARAM_STR );
      $st->execute();
      $row = $st->fetch();
      parent::disconnect( $conn );
      if ( $row ) return new Member( $row );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    }

    public function getGenderString() {
    	return ( $this->data["gender"] == "f" ) ? "Female" : "Male";
    }

    //public function getFavoriteGenreString() {
    public function getPrimarySkillAreaString() {
    	return ( $this->_skills[$this->data["primaryskillarea"]] );
    }

    public function getSkills() {
    	return $this->_skills;
    }

    // tjs 111811
    public function setIsSelectableForSite($torf) {
    	$this->data["isselectableforsite"] = $torf;
    }
    
    //tjs 160725
    public function setFirstName($firstName) {
    	$this->data["firstname"] = $firstName;
    }
    public function setLastName($lastName) {
    	$this->data["lastname"] = $lastName;
    }
    public function setStreet1($street1) {
    	$this->data["street1"] = $street1;
    }
    public function setStreet2($street2) {
    	$this->data["street2"] = $street2;
    }
    public function setCity($city) {
    	$this->data["city"] = $city;
    }
    public function setStateName($stateName) {
    	$this->data["statename"] = $stateName;
    }
    public function setZip5($zip5) {
    	$this->data["zip5"] = $zip5;
    }
    public function setPhone($phone) {
    	$this->data["phone"] = $phone;
    }
    public function setEmail($email) {
    	$this->data["emailaddress"] = $email;
    }
    
    public function insert() {
    	$conn = parent::connect();
    	// tjs 141114 - remove password function
    	$sql = "INSERT INTO " . TBL_MEMBERS . " (
              username,
              password,
              firstname,
              lastname,
			street1,
			street2,
			city,
			statename,
			phone,
			joindate,
              gender,
              primaryskillarea,
              emailaddress,
              otherskills,
			registered,
			lastlogindate,
			confidential,
			remindergap,
			intentionaldonor,
			subscriber,
			passwordmnemonicquestion,
			passwordmnemonicanswer,
			isinactive,
			zip5,
			zip4
            ) VALUES (
              :username,
              :password,
              :firstName,
              :lastName,
              :street1,
                            :street2,
              :city,
                                          :stateName,
                            :phone,
                                          :joinDate,
              :gender,
              :primarySkillArea,
              :emailAddress,
              :otherSkills,
			:registered,
			:lastLoginDate,
			:confidential,
			:reminderGap,
			:intentionalDonor,
			:subscriber,
			:passwordMnemonicQuestion,
			:passwordMnemonicAnswer,
			:isInactive,
			:zip5,
			:zip4
             )";

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":username", $this->data["username"], PDO::PARAM_STR );
      $st->bindValue( ":password", $this->data["password"], PDO::PARAM_STR );
      $st->bindValue( ":firstName", $this->data["firstname"], PDO::PARAM_STR );
      $st->bindValue( ":lastName", $this->data["lastname"], PDO::PARAM_STR );
      $st->bindValue( ":street1", $this->data["street1"], PDO::PARAM_STR );
      $st->bindValue( ":street2", $this->data["street2"], PDO::PARAM_STR );
      $st->bindValue( ":city", $this->data["city"], PDO::PARAM_STR );
      $st->bindValue( ":stateName", $this->data["statename"], PDO::PARAM_STR );
      $st->bindValue( ":phone", $this->data["phone"], PDO::PARAM_STR );
      $st->bindValue( ":joinDate", $this->data["joindate"], PDO::PARAM_STR );
      $st->bindValue( ":gender", $this->data["gender"], PDO::PARAM_STR );
      $st->bindValue( ":primarySkillArea", $this->data["primaryskillarea"], PDO::PARAM_STR );
      $st->bindValue( ":emailAddress", $this->data["emailaddress"], PDO::PARAM_STR );
      $st->bindValue( ":otherSkills", $this->data["otherskills"], PDO::PARAM_STR );
      $st->bindValue( ":registered", $this->data["registered"], PDO::PARAM_STR );
      $st->bindValue( ":lastLoginDate", $this->data["lastlogindate"], PDO::PARAM_STR );
      $st->bindValue( ":confidential", $this->data["confidential"], PDO::PARAM_STR );
      $st->bindValue( ":reminderGap", $this->data["remindergap"], PDO::PARAM_STR );
      $st->bindValue( ":intentionalDonor", $this->data["intentionaldonor"], PDO::PARAM_STR );
      $st->bindValue( ":subscriber", $this->data["subscriber"], PDO::PARAM_STR );
      $st->bindValue( ":passwordMnemonicQuestion", $this->data["passwordmnemonicquestion"], PDO::PARAM_STR );
      $st->bindValue( ":passwordMnemonicAnswer", $this->data["passwordmnemonicanswer"], PDO::PARAM_STR );
      $st->bindValue( ":isInactive", $this->data["isinactive"], PDO::PARAM_STR );
      $st->bindValue( ":zip5", $this->data["zip5"], PDO::PARAM_STR );
      $st->bindValue( ":zip4", $this->data["zip4"], PDO::PARAM_STR );
      $st->execute();
      parent::disconnect( $conn );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    }

    public function update() {
    	$conn = parent::connect();
    	// tjs 141114
    	//$passwordSql = $this->data["password"] ? "password = password(:password)," : "";
    	$passwordSql = $this->data["password"] ? "password = :password," : "";
    	$sql = "UPDATE " . TBL_MEMBERS . " SET
              username = :username,
              $passwordSql
              firstname = :firstName,
              lastname = :lastName,
              street1 = :street1,
              street2 = :street2,
              city = :city,
              statename = :stateName,
              phone = :phone,
              joindate = :joinDate,
              gender = :gender,
              primaryskillarea = :primarySkillArea,
              emailaddress = :emailAddress,
              otherskills = :otherSkills,
              registered = :registered,
              lastlogindate = :lastLoginDate,
              confidential = :confidential,
              remindergap = :reminderGap,
              intentionaldonor = :intentionalDonor,
              subscriber = :subscriber,
              passwordmnemonicquestion = :passwordMnemonicQuestion,
              passwordmnemonicanswer = :passwordMnemonicAnswer,
              isinactive = :isInactive,
              zip5 = :zip5,
              zip4 = :zip4
              
            WHERE id = :id";

              try {
              	$st = $conn->prepare( $sql );
              	$st->bindValue( ":id", $this->data["id"], PDO::PARAM_INT );
              	$st->bindValue( ":username", $this->data["username"], PDO::PARAM_STR );
              	if ( $this->data["password"] ) $st->bindValue( ":password", $this->data["password"], PDO::PARAM_STR );
              	$st->bindValue( ":firstName", $this->data["firstname"], PDO::PARAM_STR );
              	$st->bindValue( ":lastName", $this->data["lastname"], PDO::PARAM_STR );
              	$st->bindValue( ":street1", $this->data["street1"], PDO::PARAM_STR );
              	$st->bindValue( ":street2", $this->data["street2"], PDO::PARAM_STR );
              	$st->bindValue( ":city", $this->data["city"], PDO::PARAM_STR );
              	$st->bindValue( ":stateName", $this->data["statename"], PDO::PARAM_STR );
              	$st->bindValue( ":phone", $this->data["phone"], PDO::PARAM_STR );
              	$st->bindValue( ":joinDate", $this->data["joindate"], PDO::PARAM_STR );
              	$st->bindValue( ":gender", $this->data["gender"], PDO::PARAM_STR );
              	$st->bindValue( ":primarySkillArea", $this->data["primaryskillarea"], PDO::PARAM_STR );
              	$st->bindValue( ":emailAddress", $this->data["emailaddress"], PDO::PARAM_STR );
              	$st->bindValue( ":otherSkills", $this->data["otherskills"], PDO::PARAM_STR );
              	$st->bindValue( ":registered", $this->data["registered"], PDO::PARAM_STR );
              	$st->bindValue( ":lastLoginDate", $this->data["lastlogindate"], PDO::PARAM_STR );
              	$st->bindValue( ":confidential", $this->data["confidential"], PDO::PARAM_STR );
              	$st->bindValue( ":reminderGap", $this->data["remindergap"], PDO::PARAM_STR );
              	$st->bindValue( ":intentionalDonor", $this->data["intentionaldonor"], PDO::PARAM_STR );
              	$st->bindValue( ":subscriber", $this->data["subscriber"], PDO::PARAM_STR );
              	$st->bindValue( ":passwordMnemonicQuestion", $this->data["passwordmnemonicquestion"], PDO::PARAM_STR );
              	$st->bindValue( ":passwordMnemonicAnswer", $this->data["passwordmnemonicanswer"], PDO::PARAM_STR );
              	$st->bindValue( ":isInactive", $this->data["isinactive"], PDO::PARAM_STR );
              	$st->bindValue( ":zip5", $this->data["zip5"], PDO::PARAM_STR );
              	$st->bindValue( ":zip4", $this->data["zip4"], PDO::PARAM_STR );
              	$st->execute();
              	parent::disconnect( $conn );
              } catch ( PDOException $e ) {
              	parent::disconnect( $conn );
              	die( "Query failed: " . $e->getMessage() );
              }
    }

    //tjs110318
    public function updatePassword( $newPassword ) {
    	$conn = parent::connect();
    	//$passwordSql = $this->data["password"] ? "password = password(:password)," : "";
    	// tjs 141114
    	//$passwordSql = $newPassword ? "password = password(:password)" : "";
    	$passwordSql = $newPassword ? "password = :password" : "";
    	$sql = "UPDATE " . TBL_MEMBERS . " SET
    	$passwordSql
            WHERE id = :id";

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id", $this->data["id"], PDO::PARAM_INT );
      //if ( $this->data["password"] ) $st->bindValue( ":password", $this->data["password"], PDO::PARAM_STR );
      if ( $newPassword ) $st->bindValue( ":password", $newPassword, PDO::PARAM_STR );
      $st->execute();
      parent::disconnect( $conn );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    }

    public function delete() {
    	$conn = parent::connect();
    	$sql = "DELETE FROM " . TBL_MEMBERS . " WHERE id = :id";

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id", $this->data["id"], PDO::PARAM_INT );
      $st->execute();
      parent::disconnect( $conn );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    }

    public function authenticate() {
    	$conn = parent::connect();
    	// tjs 130725 kludge pg lacka password function
    	//$sql = "SELECT * FROM " . TBL_MEMBERS . " WHERE username = :username AND password = password(:password)";
    	$sql = "SELECT * FROM " . TBL_MEMBERS . " WHERE username = :username";
    	// tjs 131101
    	$password = $this->data["password"];
    	//echo "password $password";
    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":username", $this->data["username"], PDO::PARAM_STR );
      //$st->bindValue( ":password", $this->data["password"], PDO::PARAM_STR );
      $st->execute();
      $row = $st->fetch();
      //tjs110307
      //parent::disconnect( $conn );
      //if ( $row ) return new Member( $row );
      $today = date("Y-m-d");
      if ( $row ) {
      	$member = new Member( $row );
      	//echo "member password ".$member->data["password"];
      	//echo "member password ".$member->data["password"]. " password ".$password;
      	//$torf = $member->data["password"] == $password;
      	$torf = trim($member->data["password"]) == trim($password);
      	//$torf = strcmp($member->data["password"], $password);
      	//echo "member password are equal? ".$torf;
      	//$pass = implode(str_split($password));
      	//$dbpass = implode(str_split($member->data["password"]));
      	//$torf = strcmp($pass, $dbpass);
      	//echo "member password are equal? ".$torf;

      	//if ($member->data["password"] == $password) {
      	if ($torf == 1) {
      		//echo "member password are equal: ".$member->data["password"]. " password ".$password;
      		$sql = "UPDATE " . TBL_MEMBERS . " SET
				  lastlogindate = :lastLoginDate
				WHERE id = :id";
      		$st = $conn->prepare( $sql );
      		//$st->bindValue( ":id", $member->id, PDO::PARAM_INT );
      		$st->bindValue( ":id", $member->data["id"], PDO::PARAM_INT );
      		$st->bindValue( ":lastLoginDate", $today, PDO::PARAM_STR );
      		$st->execute();
      		parent::disconnect( $conn );
      		//echo "member id ".$member->data["id"];
      		return $member;
      	}
      }
      parent::disconnect( $conn );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      // tjs 141114
      echo "query failed with ".$e->getMessage();
      die( "Query failed: " . $e->getMessage() );
    	}
    	return null;
    }

}

?>
