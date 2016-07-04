<?php
/*

Guns.class.php
tjs 160703

CREATE TABLE guns
(
id serial NOT NULL,
memberid integer NOT NULL,
gunname character varying(64) NOT NULL,
shortname character varying(15) DEFAULT NULL::character varying,
make character varying(32) DEFAULT NULL::character varying,
model character varying(32) DEFAULT NULL::character varying,
serialnumber character varying(32) DEFAULT NULL::character varying,
description character varying(255) DEFAULT NULL::character varying,
caliber smallint NOT NULL,
createddate date NOT NULL,
isforsale smallint,
isinactive smallint,
CONSTRAINT gunspk PRIMARY KEY (id, memberid),
CONSTRAINT guns_members_fk FOREIGN KEY (memberid)
REFERENCES members (id) MATCH SIMPLE
ON UPDATE NO ACTION ON DELETE NO ACTION
)
*/

require_once "DataObject.class.php";

class Guns extends DataObject {

	protected $data = array(
    "id" => "",  
    "memberid" => "",
    "gunname" => "",
    "shortname" => "",
    "make" => "",
      "model" => "",
        "serialnumber" => "",
          "description" => "",
            "caliber" => "",
              "createddate" => "",
                "isforsale" => "",
              "isinactive" => ""
     );

              public function insert() {
              	$conn = parent::connect();
              	// tjs 141114 - remove password function
              	$sql = "INSERT INTO " . TBL_GUNS . " (
              memberid,
              gunname,
              shortname,
              make,
              model,
              serialnumber,
              description,
              caliber,
              createddate,
              isforsale,
              isinactive
            ) VALUES (
              :memberid,
              :gunname,
              :shortname,
              :make,
              :model,
              :serialnumber,
              :description,
              :caliber,
              :createddate,
              :isforsale,
              :isInactive
             )";

              	try {
              		$st = $conn->prepare( $sql );
              		$st->bindValue( ":memberid", $this->data["memberid"], PDO::PARAM_STR );
              		$st->bindValue( ":gunname", $this->data["gunname"], PDO::PARAM_STR );
              		$st->bindValue( ":shortname", $this->data["shortname"], PDO::PARAM_STR );
              		$st->bindValue( ":make", $this->data["make"], PDO::PARAM_STR );
              		$st->bindValue( ":model", $this->data["model"], PDO::PARAM_STR );
              		$st->bindValue( ":serialnumber", $this->data["serialnumber"], PDO::PARAM_STR );
              		$st->bindValue( ":description", $this->data["description"], PDO::PARAM_STR );
              		$st->bindValue( ":caliber", $this->data["caliber"], PDO::PARAM_STR );
              		$st->bindValue( ":createddate", $this->data["createddate"], PDO::PARAM_STR );
              		$st->bindValue( ":isforsale", $this->data["isforsale"], PDO::PARAM_STR );
              		$st->bindValue( ":isInactive", $this->data["isinactive"], PDO::PARAM_STR );
              		$st->execute();
              		parent::disconnect( $conn );
              	} catch ( PDOException $e ) {
              		parent::disconnect( $conn );
              		die( "Query failed: " . $e->getMessage() );
              	}
              }

}

?>
