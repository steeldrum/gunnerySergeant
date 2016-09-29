<?php
//echo "query.php starting...";

date_default_timezone_set ( "America/New_York" );

require_once( "common.inc.php" );
require_once( "Kaba.class.php" );
require_once( "Guns.class.php" );
require_once( "Sergeant.class.php" );

//echo "query.php call queryForKabaSergeantMatches...";

// test
//queryForKabaSergeantMatches();

function queryForKabaSergeantMatches() {
	//echo "queryForKabaSergeantMatches starting...";

	//echo "Handle is " . $handle . " GS handle is " . $gshandle;
	$conn = connect();
	$sql = 'SELECT m.zip5, k.handle, 0 as "platooncap" FROM members m, kabas k WHERE k.memberid = m.id AND m.zip5 IN (SELECT m.zip5 FROM members m, kabas k, sergeants s WHERE s.handle = :mastersergeant1 AND k.sergeantid = s.memberid AND k.memberid = m.id) UNION ALL SELECT m.zip5, s.handle, s.platooncap FROM members m, sergeants s WHERE s.memberid = m.id AND m.zip5 IN (SELECT m.zip5 FROM members m, kabas k, sergeants s WHERE s.handle = :mastersergeant2 AND k.sergeantid = s.memberid AND k.memberid = m.id) ORDER BY zip5';
	//echo " sql is " . $sql;

	/*
	 * 
<label for="zip">Zip
			code *</label> <input type="text" name="zip" 
			value="$zip5"/>

<label for="sarge">Sergeant Handle
			 *</label><input type="text" name="sarge"
				value="$sarge"/>
<label for="kaba">Gun Owner Handle
			 *</label><input type="text" name="kaba"
				value="$kaba"/>
			
	 */
	try {
		$rows = array();
		$st = $conn->prepare( $sql );
		$mastersergeant = 'mastersergeant';
		//echo "mastersergeant $mastersergeant";
		$st->bindValue( ":mastersergeant1", $mastersergeant, PDO::PARAM_STR );
		$st->bindValue( ":mastersergeant2", $mastersergeant, PDO::PARAM_STR );
		//echo "binding done...";
		
		$st->execute();
		$lastzip = '';	
		$lasthandle = '';	
		$lastcount = '';	
		//echo "looping start...";
		foreach ( $st->fetchAll() as $row ) {
			//echo "Result is " . $row;
			//echo "username is " . $row['username'];
			//echo "zip is " . $row['zip5'];
			//echo "handle is " . $row['handle'];
			if ($lastzip == '') {
				$lastzip = $row['zip5'];
				$lasthandle = $row['handle'];
				$lastcount = (integer) $row['platooncap'];
				//echo "last zip $lastzip handle $lasthandle count $lastcount";
			} else {
				$zip = $row['zip5'];
				$handle = $row['handle'];
				$count = (integer) $row['platooncap'];
				if ($zip == $lastzip) {
					if ($count > 0) {
						//echo "Sergeant handle $handle matches gun owner $lasthandle with zip $zip";
						echo '<label for="zip">Zip code *</label> <input type="text" name="zip" value="' . $zip . '"/><label for="sarge">Sergeant Handle *</label><input type="text" name="sarge" value="' . $handle . '"/><label for="kaba">Gun Owner Handle *</label><input type="text" name="kaba" value="' . $lasthandle . '"/>';
					} else if ($lastcount > 0) {
						//echo "Sergeant handle $lasthandle matches gun owner $handle with zip $zip";
						echo '<label for="zip">Zip code *</label> <input type="text" name="zip" value="' . $zip . '"/><label for="sarge">Sergeant Handle *</label><input type="text" name="sarge" value="' . $lasthandle . '"/><label for="kaba">Gun Owner Handle *</label><input type="text" name="kaba" value="' . $handle . '"/>';
					}
				} else {
					$lastzip = $zip;					
					$lasthandle = $handle;					
					$lastcount = $count;					
				}
			}
		}
		disconnect( $conn );
			} catch ( PDOException $e ) {
		disconnect( $conn );
		die( "Query failed: " . $e->getMessage() );
	}
	
}

function queryForSergeantPlatoon($sargeId) {
	//SELECT * FROM platoon_members_by_sergeant WHERE sargeid = 1;

	$conn = connect();
	$sql = 'SELECT * FROM platoon_members_by_sergeant WHERE sargeid = :sergeantid';
	//echo " sql is " . $sql;

	try {
		$rows = array();
		$st = $conn->prepare( $sql );
		$st->bindValue( ":sergeantid", $sargeId, PDO::PARAM_INT );
		//echo "binding done...";
		
		$st->execute();
		//echo "looping start...";
		echo '<table class="w3-table w3-bordered w3-striped w3-border"><thead><th>Handle</th><th>Phone</th><th>Email</th></thead><tbody>';
		foreach ( $st->fetchAll() as $row ) {
			//echo "Result is " . $row;
			//echo "handle is " . $row['handle'];
			//echo "phone is " . $row['phone'];
			//echo "email is " . $row['email'];
			echo "<tr><td>" . $row['handle'] . "</td><td>" . $row['phone'] . "</td><td>" . $row['email'] . "</td></tr>";
		}
		echo "</tbody></table>";
		
		disconnect( $conn );
			} catch ( PDOException $e ) {
		disconnect( $conn );
		die( "Query failed: " . $e->getMessage() );
	}
	
}

function queryForMemberCount() {
	$conn = connect();
	$sql = 'SELECT count(*) as "count" FROM members';
	//echo " sql is " . $sql;

	try {
		$count = 0;
		$st = $conn->prepare( $sql );
		//echo "binding done...";
		
		$st->execute();
		//echo "looping start...";
		foreach ( $st->fetchAll() as $row ) {
			//echo "Result is " . $row;
			//echo "handle is " . $row['handle'];
			//echo "phone is " . $row['phone'];
			//echo "email is " . $row['email'];
			$count = $row['count'];
		}
		
		disconnect( $conn );
		//echo " count $count";
		return $count;
			} catch ( PDOException $e ) {
		disconnect( $conn );
		die( "Query failed: " . $e->getMessage() );
	}	
}

function queryForPlatoonLogsCount($sargeId) {
	$conn = connect();
	//$sql = 'SELECT memberid, handle FROM kabas WHERE isinactive = 0 AND sergeantid = :sergeantid';
	$sql = 'SELECT count(*) FROM collaborationlog WHERE memberid IN (SELECT memberid FROM kabas WHERE isinactive = 0 AND sergeantid = :sergeantid)';
	//echo " sql is " . $sql;
	$count = 0;
	
	try {
		$rows = array();
		$st = $conn->prepare( $sql );
		$st->bindValue( ":sergeantid", $sargeId, PDO::PARAM_INT );
		//echo "binding done...";
		
		$st->execute();
		//echo "looping start...";
		foreach ( $st->fetchAll() as $row ) {
			//echo "Result is " . $row;
			//echo "handle is " . $row['handle'];
			//echo "phone is " . $row['phone'];
			//echo "email is " . $row['email'];
			$count = $row['count'];
		}
		
		disconnect( $conn );
		return $count;
	} catch ( PDOException $e ) {
		disconnect( $conn );
		die( "Query failed: " . $e->getMessage() );
	}
	
	$conn = connect();
	$sql = 'SELECT count(*) as "count" FROM collaborationlogs';
	//echo " sql is " . $sql;

	try {
		$count = 0;
		$st = $conn->prepare( $sql );
		//echo "binding done...";
		
		$st->execute();
		//echo "looping start...";
		foreach ( $st->fetchAll() as $row ) {
			//echo "Result is " . $row;
			//echo "handle is " . $row['handle'];
			//echo "phone is " . $row['phone'];
			//echo "email is " . $row['email'];
			$count = $row['count'];
		}
		
		disconnect( $conn );
		//echo " count $count";
		return $count;
			} catch ( PDOException $e ) {
		disconnect( $conn );
		die( "Query failed: " . $e->getMessage() );
	}	
}

function connect() {
	try {
		// tjs 130719 - conversion to postgreSQL
		$conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
		//$conn = new PDO( DB_DSN, DB_HOST, DB_USERNAME, DB_PASSWORD );
		$conn->setAttribute( PDO::ATTR_PERSISTENT, true );
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		// tjs 140209
		$conn->setAttribute( PDO::ATTR_TIMEOUT, 30);
	} catch ( PDOException $e ) {
		die( "Connection failed: " . $e->getMessage() );
	}

	return $conn;
}

function disconnect( $conn ) {
	$conn = "";
}


?>
