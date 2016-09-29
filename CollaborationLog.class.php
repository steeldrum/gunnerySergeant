<?php
/*
 Collaborators/
 CollaborationLog.class.php
 tjs 160810

 file version 1.00

 */

require_once "DataObject.class.php";

require_once( "Utility.class.php" );

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
	  // tjs 130725
	  protected $data = array(
    "id" => "",
	"memberid" => "",
    "topicid" => "",
    "numattempts" => "",
    "startaccess" => "",
    "log" => "",
    "stopaccess" => "",
	 "handle" => "" 
    );

    public static function getCollaborationLog( $id ) {
		$conn = parent::connect();
		$sql = "SELECT * FROM collaborationlog WHERE id = :id";

		try {
			$st = $conn->prepare( $sql );
			$st->bindValue( ":id", $id, PDO::PARAM_INT );
			$st->execute();
			$row = $st->fetch();
			//echo "getCollaborationLog id $id row id " . $row['id'];
			parent::disconnect( $conn );
			if ( $row ) return new CollaborationLog( $row );
		} catch ( PDOException $e ) {
			parent::disconnect( $conn );
			die( "Query failed: " . $e->getMessage() );
		}
	}
    
    //public static function getCollaborationLogs( $startRow, $numRows, $order ) {
    // e.g order startaccess
    public static function getCollaborationLogs( $startRow, $numRows, $order, $sergeantid, $kabaid ) {
     //echo "connecting...";
     
    	$conn = parent::connect();
    	// tjs 130719 for postgreSQL conversion
     //echo "connected...";
    	//$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_MEMBERS . " ORDER BY $order LIMIT :startRow, :numRows";
    	$sql = "SELECT c.id, c.memberid, c.topicid, c.numattempts, c.startaccess, c.log, c.stopaccess, k.handle FROM collaborationlog c, kabas k WHERE c.memberid = k.memberid ORDER BY $order OFFSET :startRow LIMIT :numRows";
     if (!is_null($sergeantid)) {
     	// tjs 160919
    	//$sql = "SELECT  c.id, c.memberid, c.topicid, c.numattempts, c.startaccess, c.log, c.stopaccess, k.handle FROM collaborationlog c, kabas k WHERE c.memberid = k.memberid AND c.memberid IN (SELECT memberid FROM kabas WHERE sergeantid = :sergeantid) ORDER BY $order OFFSET :startRow LIMIT :numRows";     	
    	$sql = "SELECT  c.id, c.memberid, c.topicid, c.numattempts, c.startaccess, c.log, c.stopaccess, k.handle FROM collaborationlog c, kabas k WHERE c.memberid = k.memberid AND c.memberid IN (SELECT memberid FROM kabas WHERE sergeantid = :sergeantid)";     	
     } /* else if (!is_null($kabaid)) {
    	//$sql = "SELECT * FROM collaborationlog c, kabas k WHERE c.memberid=k.memberid AND k.memberid = :memberid ORDER BY $order OFFSET :startRow LIMIT :numRows";     	
     	$sql = "SELECT  c.id, c.memberid, c.topicid, c.numattempts, c.startaccess, c.log, c.stopaccess, k.handle FROM collaborationlog c, kabas k WHERE c.memberid = k.memberid AND c.memberid = :memberid ORDER BY $order OFFSET :startRow LIMIT :numRows";     	
     } */
     //echo "sql $sql";
    	$rowCount = 0;

    	try {
      $st = $conn->prepare( $sql );
      if (is_null($sergeantid)) {
        $st->bindValue( ":startRow", $startRow, PDO::PARAM_INT );
      	$st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
      }
      if (!is_null($sergeantid)) {
			$st->bindValue( ":sergeantid", $sergeantid, PDO::PARAM_INT );
      }
      /*
      if (!is_null($kabaid)) {
			$st->bindValue( ":memberid", $kabaid, PDO::PARAM_INT );
      }
      */
      $st->execute();
      $logs = array();
      foreach ( $st->fetchAll() as $row ) {
      	// tjs 160825
      	$logs[] = new CollaborationLog( $row );
      	//$log = new CollaborationLog( $row );
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
     // echo " totalRows $totalRows";
      //return array( $logs, $rowCount );
      if (!is_null($sergeantid)) {
      	Utility::orderBy($logs, 'getValue(\'startaccess\') ASC');
      	$sortArray = array(); 
      	foreach($logs as $log){ 
    		foreach($log as $key=>$value){ 
        		if(!isset($sortArray[$key])){ 
    			//if($key == $order && !isset($sortArray[$key])){ 
            		$sortArray[$key] = array(); 
        		} 
        		$sortArray[$key][] = $value; 
    		} 
		} 
      	array_multisort($sortArray[$order],SORT_ASC,$logs);
      	
      	$rowCount = 0;
		$numRowCount = 0;
		$segmentLogs = array();
      	foreach($logs as $log){
      		$rowCount++;
      		if ($rowCount >= $startRow) {
      			$numRowCount++;
      			if ($numRowCount <= $numRows) {
      				$segmentLogs[] = $log;
      			}
      		}
		}
      	return array( $segmentLogs, $rowCount );      	
      } else {
      	return array( $logs, $rowCount );
      }
		
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    	
    	//$logs = array();
    	//return array( $logs, $rowCount );
    }
    
    public static function getLastCollaborationLog( $memberid, $handle ) {
     //echo "connecting...";
     
    	$conn = parent::connect();
    	// tjs 130719 for postgreSQL conversion
     //echo "connected...";
    	//$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_MEMBERS . " ORDER BY $order LIMIT :startRow, :numRows";
    	$sql = "SELECT * FROM collaborationlog WHERE memberid = :memberid ORDER BY stopaccess DESC";

     //echo "sql $sql";
    	$rowCount = 0;

    	try {
      $st = $conn->prepare( $sql );

	  $st->bindValue( ":memberid", $memberid, PDO::PARAM_INT );

      $st->execute();
      //$logs = array();
      $log = null;
      foreach ( $st->fetchAll() as $row ) {
      	// tjs 160825
      	//$logs[] = new CollaborationLog( $row );
      	$log = new CollaborationLog( $row );
      	$log -> setHandle($handle);
      	//$log = new CollaborationLog( $row );
      	
      	//echo "getLastCollaborationLog numattempts " . $log->getValue('numattempts');
      	
      	// tjs 130719
      	$rowCount++;
      	// just last one needed
      	break;
      }
      //echo "rowCount $rowCount";
      // tjs 130719
      //$st = $conn->query( "SELECT found_rows() as totalRows" );
      //$row = $st->fetch();
      parent::disconnect( $conn );
      //return array( $members, $row["totalRows"] );
     // $totalRows = Member::getMemberCount();
      //$totalRows = 74;
      //echo " totalRows $rowCount";
      //return array( $logs, $rowCount );
      //echo "getLastCollaborationLog numattempts from returned log " . $log->getValue('numattempts') . " rowCount $rowCount handle " . $log->getValue('handle');
      return array( $log, $rowCount );
      //return array( $members, $rowCount, $totalRows );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    	
    	//$logs = array();
    	//return array( $logs, $rowCount );
    }
    
    // tjs 160916
    //public static function insertCollaborationLog( $collaborationLog ) {
    public static function insertCollaborationLog( $collaborationLog, $handle ) {
    // echo "insertCollaborationLog...";
    // this->insert($collaborationLog);
    //echo "insertCollaborationLog memberid " . $collaborationLog['memberid'];
    // echo "insertCollaborationLog memberid " . $collaborationLog->getValue('memberid');
     // e.g. insertCollaborationLog memberid 55
    	//CollaborationLog::insert($collaborationLog);
    	// tjs 160914
    	//$collaborationLog-> insert();
     $id = $collaborationLog->insert();
    	//this->insert($collaborationLog);
    //echo "insertCollaborationLog inserted...";
     //echo "insertCollaborationLog inserted with id $id ";
    	$conn = parent::connect();
    	// tjs 130719 for postgreSQL conversion
     //echo "connected...";
    	//$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_MEMBERS . " ORDER BY $order LIMIT :startRow, :numRows";
   //	$sql = "SELECT * FROM collaborationlog WHERE id = SELECT MAX(id) FROM collaborationlog";
    	//$sql = "SELECT MAX(id) FROM collaborationlog";
 /*   	
$sql = "SELECT currval('collaborationlog_id_seq') AS lastinsertid";
     echo "sql $sql";

    	try {
      $st = $conn->prepare( $sql );

      $st->execute();
      $id = $st->fetch();
      */
      //echo "insertCollaborationLog last id " . $id;
    	try {
      
      $sql = "SELECT * FROM collaborationlog WHERE id = :id";
      $st = $conn->prepare( $sql );
      $st->bindValue( ":id", $id, PDO::PARAM_INT );
      
      $st->execute();
      
      //$logs = array();
      //$log = null;
      
      $row = $st->fetch();
      parent::disconnect( $conn );
      //if ( $row ) return new CollaborationLog( $row );
      if ( $row ) {
      	$log = new CollaborationLog( $row );
      	$log -> setHandle($handle);
      	return $log;
      }
      
      /*
      foreach ( $st->fetchAll() as $row ) {
      	// tjs 160825
      	//$logs[] = new CollaborationLog( $row );
      	$log = new CollaborationLog( $row );
      	//$log = new CollaborationLog( $row );
      	// tjs 130719
      	// just last one needed
      	break;
      }
      */
      //echo "rowCount $rowCount";
      // tjs 130719
      //$st = $conn->query( "SELECT found_rows() as totalRows" );
      //$row = $st->fetch();
      //parent::disconnect( $conn );
      //return array( $members, $row["totalRows"] );
     // $totalRows = Member::getMemberCount();
      //$totalRows = 74;
      //return array( $logs, $rowCount );
      //return $log;
      //return array( $members, $rowCount, $totalRows );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    	
    	//$logs = array();
    	//return array( $logs, $rowCount );
    }
    
    public static function getNextTopicid( $memberid ) {
     //echo "connecting...";
     
    	$conn = parent::connect();
    	// tjs 130719 for postgreSQL conversion
     //echo "connected...";
    	//$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM " . TBL_MEMBERS . " ORDER BY $order LIMIT :startRow, :numRows";
    	$sql = "SELECT topicid FROM collaborationlog WHERE memberid = :memberid ORDER BY stopaccess DESC";

     //echo "sql $sql";
    	//$rowCount = 0;

    	try {
      $st = $conn->prepare( $sql );

	  $st->bindValue( ":memberid", $memberid, PDO::PARAM_INT );

      $st->execute();
      //$logs = array();
      $topicid = 0;
      foreach ( $st->fetchAll() as $row ) {
      	// tjs 160825
      	//$logs[] = new CollaborationLog( $row );
      	$topicid = $row['topicid'];
      	//$log = new CollaborationLog( $row );
      	// tjs 130719
      	//$rowCount++;
      	// just last one needed
      	break;
      }
      //echo "rowCount $rowCount";
      // tjs 130719
      //$st = $conn->query( "SELECT found_rows() as totalRows" );
      //$row = $st->fetch();
      parent::disconnect( $conn );
      //return array( $members, $row["totalRows"] );
     // $totalRows = Member::getMemberCount();
      //$totalRows = 74;
      //echo " totalRows $rowCount";
      //return array( $logs, $rowCount );
      return $topicid;
      //return array( $members, $rowCount, $totalRows );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    	
    	//$logs = array();
    	//return array( $logs, $rowCount );
    }

    public function getLog() {
    	//echo "getLog... ";
	    if ( array_key_exists( strtolower('log'), $this->data ) ) {
    		//echo "getLog key exists ";
	    	//return $this->data[strtolower('log')];
    		$log = $this->data[strtolower('log')];
    		if ($log == null) {
    			//echo "getLog log data null ";
    			$log = 'NULL';
    		}
    		//echo "getLog log is $log ";
    		return $log;
	  	} else {
    		//echo "getLog key does NOT exist ";
	  		return '';
	    }
    }
        
        //tjs 160725
    public function setHandle($handle) {
    	$this->data["handle"] = $handle;
    }

    public function setLog($log) {
    	$this->data["log"] = $log;
    }
    public function setTopicId($topicid) {
    	$this->data["topicid"] = $topicid;
    }
    public function setNumAttempts($numattempts) {
    	$this->data["numattempts"] = $numattempts;
    }
    public function setStopAccess($stopaccess) {
    	$this->data["stopaccess"] = $stopaccess;
    }
    
/*
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
    
*/

    public function insert() {
    	$conn = parent::connect();
   		// tjs 160914
    		$conn->beginTransaction();

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
    		// tjs 160914
    		//$conn->beginTransaction();
    		
      $st = $conn->prepare( $sql );
      $st->bindValue( ":memberid", $this->data["memberid"], PDO::PARAM_STR );
      $st->bindValue( ":topicid", $this->data["topicid"], PDO::PARAM_STR );
      $st->bindValue( ":numattempts", $this->data["numattempts"], PDO::PARAM_STR );
      $st->bindValue( ":startaccess", $this->data["startaccess"], PDO::PARAM_STR );
      $st->bindValue( ":log", $this->data["log"], PDO::PARAM_STR );
      $st->bindValue( ":stopaccess", $this->data["stopaccess"], PDO::PARAM_STR );
      $st->execute();
      
      // tjs 160914
     // $id = 1;
     //$id = $conn->lastInsertId();
     $id = $conn->lastInsertId('collaborationlog_id_seq');
      /*
      $sql = "SELECT currval('collaborationlog_id_seq') AS lastinsertid";
		$st = $conn->prepare( $sql );
		$st->execute();
      $id = $st->fetch();
      */
             //$result = $st->fetch(PDO::FETCH_ASSOC);
             //$id = $result["id"]; 
     
		$conn->commit(); 
		     
      parent::disconnect( $conn );
      return $id;
    	} catch ( PDOException $e ) {
    		$conn->rollBack();
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
      return null;
    	}
    }

	public function update() {
		$conn = parent::connect();
		$sql = "UPDATE collaborationlog SET
              memberid = :memberid,
              topicid = :topicid,
              numattempts = :numattempts,
              startaccess = :startaccess,
              log = :log,
              stopaccess = :stopaccess
            WHERE id = :id";

		try {
			$st = $conn->prepare( $sql );
			$st->bindValue( ":id", $this->data["id"], PDO::PARAM_INT );
			$st->bindValue( ":memberid", $this->data["memberid"], PDO::PARAM_INT );
			$st->bindValue( ":topicid", $this->data["topicid"], PDO::PARAM_INT );
			$st->bindValue( ":numattempts", $this->data["numattempts"], PDO::PARAM_INT );
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
}

?>
