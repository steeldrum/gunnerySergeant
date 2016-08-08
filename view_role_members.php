<?php
/***************************************
$Revision:: 53                         $: Revision of last commit
$LastChangedBy::                       $: Author of last commit
$LastChangedDate:: 2011-03-01 15:28:41#$: Date of last commit
***************************************/
/*
Collaborators/
view_members.php
tjs 101012

file version 1.00 

release version 1.06
*/

require_once( "common.inc.php" );
require_once( "config.php" );
require_once( "RoleMember.class.php" );
// tjs 160801
require_once( "query.php" );

$start = isset( $_GET["start"] ) ? (int)$_GET["start"] : 0;
$order = isset( $_GET["order"] ) ? preg_replace( "/[^ a-zA-Z]/", "", $_GET["order"] ) : "username";
//echo "getting role members...";
//list( $members, $totalRows ) = Member::getMembers( $start, PAGE_SIZE, $order );
list( $roleMembers, $rowCount ) = RoleMember::getRoleMembers( $start, PAGE_SIZE, $order );
//list( $members, $rowCount, $totalRows ) = Member::getMembers( $start, PAGE_SIZE, $order );
$totalRows = queryForMemberCount();
//echo "totalRows $totalRows";
displayPageHeader( "View GunnerySergeant members roles" );

?>
    <h2>Displaying members <?php echo $start + 1 ?> - <?php echo min( $start +  PAGE_SIZE, $totalRows ) ?> of <?php echo $totalRows ?></h2>

    <table cellspacing="0" style="width: 30em; border: 1px solid #666;">
      <tr>
        <th><?php if ( $order != "username" ) { ?><a href="view_role_members.php?order=username"><?php } ?>Username<?php if ( $order != "username" ) { ?></a><?php } ?></th>
        <th><?php if ( $order != "role" ) { ?><a href="view_role_members.php?order=role"><?php } ?>Role<?php if ( $order != "role" ) { ?></a><?php } ?></th>
        <th><?php if ( $order != "firstName" ) { ?><a href="view_role_members.php?order=firstName"><?php } ?>First name<?php if ( $order != "firstName" ) { ?></a><?php } ?></th>
        <th><?php if ( $order != "lastName" ) { ?><a href="view_role_members.php?order=lastName"><?php } ?>Last name<?php if ( $order != "lastName" ) { ?></a><?php } ?></th>
      </tr>
<?php
$rowCount = 0;

foreach ( $roleMembers as $roleMember ) {
  $rowCount++;
?>
      <tr<?php if ( $rowCount % 2 == 0 ) echo ' class="alt"' ?>>
        <td><a href="view_role_member.php?memberId=<?php echo $roleMember->getValueEncoded( "id" ) ?>&amp;start=<?php echo $start ?>&amp;order=<?php echo $order ?>"><?php echo $roleMember->getValueEncoded( "username" ) ?></a></td>
        <td><?php echo $roleMember->getValueEncoded( "role" ) ?></td>
        <td><?php echo $roleMember->getValueEncoded( "firstname" ) ?></td>
        <td><?php echo $roleMember->getValueEncoded( "lastname" ) ?></td>
      </tr>
<?php
}
?>
    </table>

    <div style="width: 30em; margin-top: 20px; text-align: center;">
<?php if ( $start > 0 ) { ?>
      <a href="view_role_members.php?start=<?php echo max( $start - PAGE_SIZE, 0 ) ?>&amp;order=<?php echo $order ?>">Previous page</a>
<?php } ?>
&nbsp;
<?php if ( $start + PAGE_SIZE < $totalRows ) { ?>
      <a href="view_role_members.php?start=<?php echo min( $start + PAGE_SIZE, $totalRows ) ?>&amp;order=<?php echo $order ?>">Next page</a>
<?php } ?>
    </div>


<?php
displayPageFooter();

?>

