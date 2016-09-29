<?php
/*
Collaborators/
view_platoon_logs.php
tjs 160810

file version 1.00 

*/

require_once( "common.inc.php" );
require_once( "config.php" );

require_once( "CollaborationLog.class.php" );
//require_once( "RoleMember.class.php" );
// tjs 160801
require_once( "query.php" );
/*
$start = isset( $_GET["start"] ) ? (int)$_GET["start"] : 0;
$order = isset( $_GET["order"] ) ? preg_replace( "/[^ a-zA-Z]/", "", $_GET["order"] ) : "username";
list( $roleMembers, $rowCount ) = RoleMember::getRoleMembers( $start, PAGE_SIZE, $order );
$totalRows = queryForMemberCount();
TODO
expected use case with sergeantid shows platoon logs.
when times are the same the log is "open" (for a given kaba).
when stop time is after start then log is closed.
when the table is populated there will always be an open row for each kaba.
This means if a closed row appears and no open row exists it is created
automatically.
The GS gets to select from open rows, initiate contact, and
eventually log results and close the log.  The default close date
is 12 months from the open date.
The GS gets to select rows that have been opened the longest first.
Typical steps include trigger a topic event (before contact).
The kaba is then informed (e.g. by email) to peruse the topic.
In due time the GS makes contact (e.g. by phone) and the topic is
discussed.  Topics are scenarios with conclusion 'lessons learned'.

*/
$start = isset( $_GET["start"] ) ? (int)$_GET["start"] : 0;
$order = isset( $_GET["order"] ) ? preg_replace( "/[^ a-zA-Z]/", "startaccess", $_GET["order"] ) : "startaccess";
//$sergeantid = isset( $_GET["sergeantid"] ) ? preg_replace( "/[^ a-zA-Z]/", "", $_GET["sergeantid"] ) : "";
$sergeantid = isset( $_GET["sergeantid"] ) ? preg_replace( "/[^0-9]/", "", $_GET["sergeantid"] ) : "";
//$sergeantid = $_GET["sergeantid"];
//$memberid = isset( $_GET["memberid"] ) ? preg_replace( "/[^ a-zA-Z]/", "", $_GET["memberid"] ) : "";
$memberid = isset( $_GET["memberid"] ) ? preg_replace( "/[^0-9]/", "", $_GET["memberid"] ) : "";
//echo "start $start order $order sergeant id $sergeantid";
list( $collaborationLogs, $rowCount ) = CollaborationLog::getCollaborationLogs( $start, PAGE_SIZE, $order, $sergeantid, $memberid );
//CollaborationLog::getCollaborationLogs( $start, PAGE_SIZE, $order, $sergeantid, $memberid );

$totalRows = queryForPlatoonLogsCount($sergeantid);

displayPageHeader( "View GunnerySergeant platoon logs" );

?>
    <h2>Displaying collaboration logs <?php echo $start + 1 ?> - <?php echo min( $start +  PAGE_SIZE, $totalRows ) ?> of <?php echo $totalRows ?></h2>

    <table cellspacing="0" style="width: 30em; border: 1px solid #666;">
      <tr>
        <th><?php if ( $order != "startaccess" ) { ?><a href="view_platoon_logs.php?sergeantid=<?php echo $sergeantid; ?>&amp;order=startaccess"><?php } ?>Start Contact<?php if ( $order != "startaccess" ) { ?></a><?php } ?></th>
        <th><?php if ( $order != "stopaccess" ) { ?><a href="view_platoon_logs.php?sergeantid=<?php echo $sergeantid; ?>&amp;order=stopaccess"><?php } ?>Stop Contact<?php if ( $order != "stopaccess" ) { ?></a><?php } ?></th>
        <th>Handle</th>
      </tr>
<?php
$rowCount = 0;

foreach ( $collaborationLogs as $collaborationLog ) {
  $rowCount++;
?>
      <tr<?php if ( $rowCount % 2 == 0 ) echo ' class="alt"' ?>>
        <td><a href="view_platoon_log.php?sergeantid=<?php echo $sergeantid; ?>&amp;handle=<?php echo $collaborationLog->getValueEncoded( "handle" ); ?>&amp;id=<?php echo $collaborationLog->getValueEncoded( "id" ); ?>&amp;start=<?php echo $start; ?>&amp;order=<?php echo $order; ?>"><?php echo $collaborationLog->getValueEncoded( "startaccess" ); ?></a></td>
        <td><?php echo $collaborationLog->getValueEncoded( "stopaccess" ) ?></td>
        <td><?php echo $collaborationLog->getValueEncoded( "handle" ) ?></td>
      </tr>
<?php
}
?>
    </table>

    <div style="width: 30em; margin-top: 20px; text-align: center;">
<?php if ( $start > 0 ) { ?>
      <a href="view_platoon_logs.php?start=<?php echo max( $start - PAGE_SIZE, 0 ) ?>&amp;order=<?php echo $order ?>&amp;sergeantid=<?php echo $sergeantid ?>&amp;memberid=<?php echo $memeberid ?>">Previous page</a>
<?php } ?>
&nbsp;
<?php if ( $start + PAGE_SIZE < $totalRows ) { ?>
      <a href="view_platoon_logs.php?start=<?php echo min( $start + PAGE_SIZE, $totalRows ) ?>&amp;order=<?php echo $order ?>&amp;sergeantid=<?php echo $sergeantid ?>&amp;memberid=<?php echo $memeberid ?>">Next page</a>
<?php } ?>
    </div>


<?php
displayPageFooter();

?>

