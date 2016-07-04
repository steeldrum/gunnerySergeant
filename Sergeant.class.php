<?php
/*

Sergeant.class.php
tjs 160703

CREATE TABLE sergeants
(
  memberid integer NOT NULL,
  platooncap integer NOT NULL,
  isinactive smallint,
  handle character varying(50) NOT NULL,
  CONSTRAINT sergeantspk PRIMARY KEY (memberid),
  CONSTRAINT sergeants_members_fk FOREIGN KEY (memberid)
      REFERENCES members (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT handle_unique UNIQUE (handle)
)
*/

require_once "DataObject.class.php";

class Sergeant extends DataObject {

  protected $data = array(
  // tjs 130725
    "memberid" => "",
    "platooncap" => "",
    "isinactive" => "",
    "handle" => ""
    );

    public function insert() {
    	$conn = parent::connect();
    	// tjs 141114 - remove password function
    	$sql = "INSERT INTO " . TBL_KABAS . " (
              memberid,
              platooncap,
 			isinactive,
 			handle
            ) VALUES (
              :memberid,
              :platooncap,
			:isInactive,
			:handle
             )";

    	try {
      $st = $conn->prepare( $sql );
      $st->bindValue( ":memberid", $this->data["memberid"], PDO::PARAM_STR );
      $st->bindValue( ":platooncap", $this->data["platooncap"], PDO::PARAM_STR );
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
