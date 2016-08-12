<?php
/*
 Collaborators/
 CollaborationLog.class.php
 tjs 160810

 file version 1.00

 */

require_once "DataObject.class.php";

//require_once( "Utility.class.php" );

date_default_timezone_set ( "America/New_York" );

class CollaborationLog extends DataObject {

/*
  id serial NOT NULL,
  memberid integer NOT NULL,
  topicid integer NOT NULL,
  numattempts smallint NOT NULL,
  startaccess timestamp without time zone NOT NULL DEFAULT now(),
  log character varying(1028) NOT NULL,
  stopaccess timestamp without time zone NOT NULL DEFAULT now(),

 */	
	  protected $data = array(
  // tjs 130725
    "id" => "",
	"memberid" => "",
    "topicid" => "",
    "numattempts" => "",
    "startaccess" => ""
    "log" => "",
    "stopaccess" => "",
	 "handle" => "" 
    );

    //public static function getCollaborationLogs( $startRow, $numRows, $order ) {
    public static function getCollaborationLogs( $startRow, $numRows, $order, $sergeantid, $kabaid ) {
     //echo "connecting...";
    	$conn = parent::connect();
    	// tjs 130719 for postgreSQL conversion
     //echo "connected...";
    	//$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_MEMBERS . " ORDER BY $order LIMIT :startRow, :numRows";
    	$sql = "SELECT c.id, c.memberid, c.topicid, c.numattempts, c.startaccess, c.log, c.stopaccess, k.handle FROM collaborationlog c, kabas k WHERE c.memberid = k.memberid ORDER BY $order OFFSET :startRow LIMIT :numRows";
     if (!is_null($sergeantid)) {
    	$sql = "SELECT  c.id, c.memberid, c.topicid, c.numattempts, c.startaccess, c.log, c.stopaccess, k.handle FROM collaborationlog c, kabas k WHERE c.memberid = k.memberid AND c.memberid IN (SELECT memberid FROM kabas WHERE sergeantid = :sergeantid) ORDER BY $order OFFSET :startRow LIMIT :numRows";     	
     } else if (!is_null($kabaid)) {
    	//$sql = "SELECT * FROM collaborationlog c, kabas k WHERE c.memberid=k.memberid AND k.memberid = :memberid ORDER BY $order OFFSET :startRow LIMIT :numRows";     	
     	$sql = "SELECT  c.id, c.memberid, c.topicid, c.numattempts, c.startaccess, c.log, c.stopaccess, k.handle FROM collaborationlog c, kabas k WHERE c.memberid = k.memberid AND c.memberid = :memberid ORDER BY $order OFFSET :startRow LIMIT :numRows";     	
     }
    	$rowCount = 0;

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":startRow", $startRow, PDO::PARAM_INT );
      $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
      if (!is_null($sergeantid)) {
			$st->bindValue( ":sergeantid", $sergeantid, PDO::PARAM_INT );
      }
      if (!is_null($kabaid)) {
			$st->bindValue( ":memberid", $kabaid, PDO::PARAM_INT );
      }
      $st->execute();
      $logs = array();
      foreach ( $st->fetchAll() as $row ) {
      	$logs[] = new CollaborationLog( $row );
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
      return array( $logs, $rowCount );
      //return array( $members, $rowCount, $totalRows );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    }

    public static function getCollaborationLog( $id ) {
    	$conn = parent::connect();
    	//$sql = "SELECT * FROM collaborationlog WHERE id = :id";
    	$sql = "SELECT c.id, c.memberid, c.topicid, c.numattempts, c.startaccess, c.log, c.stopaccess, k.handle FROM collaborationlog c, kabas k WHERE c.memberid = k.memberid AND c.id = :id";

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id", $id, PDO::PARAM_INT );
      $st->execute();
      $row = $st->fetch();
      parent::disconnect( $conn );
      if ( $row ) return new CollaborationLog( $row );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    }

    //TODO by sergeant, kaba ids...
    
    public function insert() {
    	$conn = parent::connect();
    	// tjs 141114 - remove password function
    	$sql = "INSERT INTO collaborationlog (
              memberid,
              topicid,
 			numattempts,
 			startaccess,
 			log,
 			stopaccess
            ) VALUES (
              :memberid,
              :topicid,
			:numattempts,
			:startaccess,
			:log,
			:stopaccess
             )";

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":memberid", $this->data["memberid"], PDO::PARAM_STR );
      $st->bindValue( ":topicid", $this->data["topicid"], PDO::PARAM_STR );
      $st->bindValue( ":numattempts", $this->data["numattempts"], PDO::PARAM_STR );
      $st->bindValue( ":startaccess", $this->data["startaccess"], PDO::PARAM_STR );
      $st->bindValue( ":log", $this->data["log"], PDO::PARAM_STR );
      $st->bindValue( ":stopaccess", $this->data["stopaccess"], PDO::PARAM_STR );
      $st->execute();
      parent::disconnect( $conn );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    }
    
/*
   
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
       	return $roleMember;
      }

static function role_compare($a, $b) {
	//echo " role_compare...";
    //$arole = $a['role'];
    $arole = $a->role;
    $brole = $b->role;
    echo " arole $arole brole $brole";
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
      	//Utility::orderBy($roleMembers, 'getValue(\'role\') ASC');
      	Utility::orderBy($roleMembers, 'getValue(\'role\') ASC, getValue(\'lastname\') ASC');
      	//echo " end usort"; 
      	
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
*/


}

?>
