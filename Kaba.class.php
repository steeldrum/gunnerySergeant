<?php
/*

Kaba.class.php
tjs 160703

  CREATE TABLE kabas
(
  memberid integer NOT NULL,
  sponsorid integer NOT NULL,
  sergeantid integer NOT NULL,
  isinactive smallint,
  handle character varying(50) NOT NULL,
  CONSTRAINT kabaspk PRIMARY KEY (memberid),
  CONSTRAINT kabas_members_fk FOREIGN KEY (memberid)
*/

require_once "DataObject.class.php";

class Kaba extends DataObject {

  protected $data = array(
  // tjs 130725
    "memberid" => "",
    "sponsorid" => "",
    "sergeantid" => "",
    "isinactive" => "",
    "handle" => ""
    );

    public function insert() {
    	$conn = parent::connect();
    	// tjs 141114 - remove password function
    	$sql = "INSERT INTO " . TBL_KABAS . " (
              memberid,
              sponsorid,
              sergeantid,
 			isinactive,
 			handle
            ) VALUES (
              :memberid,
              :sponsorid,
              :sergeantid,
			:isInactive,
			:handle
             )";

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":memberid", $this->data["memberid"], PDO::PARAM_STR );
      $st->bindValue( ":sponsorid", $this->data["sponsorid"], PDO::PARAM_STR );
      $st->bindValue( ":sergeantid", $this->data["sergeantid"], PDO::PARAM_STR );
      $st->bindValue( ":isInactive", $this->data["isinactive"], PDO::PARAM_STR );
      $st->bindValue( ":handle", $this->data["handle"], PDO::PARAM_STR );
      $st->execute();
      parent::disconnect( $conn );
    	} catch ( PDOException $e ) {
      parent::disconnect( $conn );
      die( "Query failed: " . $e->getMessage() );
    	}
    }

}

?>
