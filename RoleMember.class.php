<?php
/***************************************
 $Revision:: 156                        $: Revision of last commit
 $LastChangedBy::                       $: Author of last commit
 $LastChangedDate:: 2011-11-18 13:51:23#$: Date of last commit
 ***************************************/
/*
 Collaborators/
 RoleMember.class.php
 tjs 101012

 file version 1.00

 release version 1.06
 */

require_once "DataObject.class.php";

require_once( "Utility.class.php" );

date_default_timezone_set ( "America/New_York" );

class RoleMember extends Member {

   function __construct($ar) {
       parent::__construct($ar);
       //print "In SubClass constructor\n";
       $roleData = array(
    "role" => "",
    "handle" => ""
    );
       array_merge ($data, $roleData);
   }
   
  public static function getMember( $id ) {
  	//echo " id $id in RoleMember::getMember";
  	$member = Member::getMember( $id );
  	//echo " id obtained member!";
  	//$roleMember = new RoleMember($member);
  	$roleMember = self::copyMember($member);
  	//echo " copied member!";
      	$role = self::getMemberRole( $id );
//echo " role $role";
      	$roleMember->setRole($role);
  	return $roleMember;
  	/*
  	$role = self::getMemberRole( $id );
  	//self::setRole($role);
  	//echo " role $role set";
  	$roleMember = Member::getMember( $id );
  	self::setRole($role);
  	echo " role $role set";
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
    	*/
    }

      public static function copyMember( $member ) {
      	$roleMember = new RoleMember($member);
      	$roleMember->data["id"] = $member->getValueEncoded( "id" );
      	$roleMember->data["username"] = $member->getValueEncoded( "username" );
      	$roleMember->data["emailaddress"] = $member->getValueEncoded( "emailaddress" );
      	$roleMember->data["firstname"] = $member->getValueEncoded( "firstname" );
      	$roleMember->data["lastname"] = $member->getValueEncoded( "lastname" );
      	$roleMember->data["street1"] = $member->getValueEncoded( "street1" );
      	$roleMember->data["street2"] = $member->getValueEncoded( "street2" );
      	$roleMember->data["city"] = $member->getValueEncoded( "city" );
      	$roleMember->data["statename"] = $member->getValueEncoded( "statename" );
      	$roleMember->data["zip5"] = $member->getValueEncoded( "zip5" );
      	$roleMember->data["phone"] = $member->getValueEncoded( "phone" );
      	$roleMember->data["joindate"] = $member->getValueEncoded( "joindate" );
      	$roleMember->data["gender"] = $member->getValueEncoded( "gender" );
      	//echo " copyMember primaryskillarea " . $member->getValueEncoded( "primaryskillarea" );
      	$roleMember->data["primaryskillarea"] = $member->getValueEncoded( "primaryskillarea" );
      	$roleMember->data["otherskills"] = $member->getValueEncoded( "otherskills" );
      	/*
      	 *			registered,
			lastlogindate,
			confidential,
			remindergap,
			intentionaldonor,
			subscriber,
			passwordmnemonicquestion,
			passwordmnemonicanswer,
			isinactive,
			zip4

      	 */
      	return $roleMember;
      }
   /**
* usort callback
*/
static function role_compare($a, $b) {
	//echo " role_compare...";
    //$arole = $a['role'];
    $arole = $a->role;
    $brole = $b->role;
    echo " arole $arole brole $brole";
    /*
    $brole = $b['role'];
    echo " arole $arole brole $brole";
    return strcmp($arole, $brole);
    */
    //if ($adist == $bdist) {
    // return 0;
     //}
     //return ($adist < $bdist) ? -1 : 1; 
             $al = strtolower($a->role);
        $bl = strtolower($b->role);
        if ($al == $bl) {
            return 0;
        }
        return ($al > $bl) ? +1 : -1;   
}

static function build_sorter($key) {
    return function ($a, $b) use ($key) {
        return strnatcmp($a[$key], $b[$key]);
    };
}
/*   
	protected $data = array(
    "role" => "",
    "handle" => ""
    );
*/    
    public static function getRoleMembers( $startRow, $numRows, $order ) {
     //echo "connecting...";
    	$conn = parent::connect();
    	// tjs 130719 for postgreSQL conversion
     //echo "connected...";
    	//$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_MEMBERS . " ORDER BY $order LIMIT :startRow, :numRows";
		$sql = "SELECT * FROM " . TBL_MEMBERS;
    	if ($order != "role") {
			$sql = "SELECT * FROM " . TBL_MEMBERS . " ORDER BY $order OFFSET :startRow LIMIT :numRows";    		
    	} 
    	$rowCount = 0;
//echo " sql $sql";
    	try {
      $st = $conn->prepare( $sql );
      if ($order != "role") {
      	$st->bindValue( ":startRow", $startRow, PDO::PARAM_INT );
      	$st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
      }
      $st->execute();
      $roleMembers = array();
      foreach ( $st->fetchAll() as $row ) {
      	//$roleMembers[] = new RoleMember( $row );
      	//echo " row:\n";
      	//print_r($row);
      	$roleMember = new RoleMember( $row );
      	$username = $roleMember->getValue('username');
      	//echo " username $username";
      	$id = (integer) $roleMember->getValue('id');
//echo " id $id";
      	$role = self::getMemberRole( $id );
//echo " role $role";
      	$roleMember->setRole($role);
      	      		//$temp = $roleMember['role'];
      	      		//$temp = $roleMember->getValue('role');
      	//echo " temp $temp";
      	$roleMembers[] = $roleMember;
      	// tjs 130719
      	$rowCount++;
      }
      //echo " order $order";
      if ($order == "role") { 
      	//$test = multi_sort($test, $key = 'points');
      	//echo " start usort";
      	/*
      	      	foreach($roleMembers as $roleMember){ 
      	      		$temp = $roleMember['role'];
      	      		echo " temp $temp";
      	      	}
      	      	*/
      	//usort($roleMembers, "role_compare");
      	//usort($a, array("TestObj", "cmp_obj"));
      	//usort($roleMembers, array("RoleMember", "role_compare"));
      	//usort($array, build_sorter('key_b'));
      	//usort($roleMembers, build_sorter('role'));
      	//usort($roleMembers, array("RoleMember", build_sorter('role')));
      	//Utility::orderBy($testAry, 'a ASC, b DESC');
      	//Utility::orderBy($roleMembers, 'role ASC');
      	//Utility::orderBy($objectAry, 'getCreationDate() DESC, getSubOrder() ASC');       	
      	//Utility::orderBy($roleMembers, 'role ASC');
      	//Utility::orderBy($roleMembers, '$roleMember->getValue(\'role\') ASC');
      	//Utility::orderBy($roleMembers, 'getValue(\'role\') ASC');
      	Utility::orderBy($roleMembers, 'getValue(\'role\') ASC, getValue(\'lastname\') ASC');
      	//echo " end usort"; 
      	/*
      	echo " start multi_sort";
      	$roleMembers = multi_sort($roleMembers, $key = 'role');
      	echo " end multi_sort"; 
      	*/
      	/*    	
      	$sortArray = array(); 
      	foreach($roleMembers as $roleMember){ 
    		foreach($roleMember as $key=>$value){ 
        		if(!isset($sortArray[$key])){ 
    			//if($key == $order && !isset($sortArray[$key])){ 
            		$sortArray[$key] = array(); 
        		} 
        		$sortArray[$key][] = $value; 
    		} 
		} 

		//$orderby = "role"; //change this to whatever key you want from the array 
		//array_multisort($sortArray[$orderby],SORT_ASC,$roleMembers); 
		array_multisort($sortArray[$order],SORT_ASC,$roleMembers); 
		//var_dump($roleMembers);
		*/
      	
		$rowCount = 0;
		$numRowCount = 0;
		$roleSegmentMembers = array();
      	foreach($roleMembers as $roleMember){
      		$rowCount++;
      		if ($rowCount >= $startRow) {
      			$numRowCount++;
      			if ($numRowCount <= $numRows) {
      				$roleSegmentMembers[] = $roleMember;
      			}
      		}
		}
		 		
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
      if ($order == "role") {
      	return array( $roleSegmentMembers, $rowCount );      	
      } else {
      	return array( $roleMembers, $rowCount );
      }
      //return array( $members, $rowCount, $totalRows );
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
    
    public function setRole($role) {
    	//echo " setRole $role";
    	$this->data["role"] = $role;
    	//echo " setRole done...";
    }


 /*
    function multi_sort($array, $akey)
	{  
  		function compare($a, $b)
  		{
    		 global $key;
     		return strcmp($a[$key], $b[$key]);
  		} 
  		usort($array, "compare");
 		 return $array;
	}
    */
}

?>
