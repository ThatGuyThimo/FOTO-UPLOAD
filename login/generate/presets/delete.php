<?php
require('../../../includes/config.inc.php');
$DIR = basename(__DIR__);
var_dump($DIR);
$delete_images = mysqli_query($mysqli, "DELETE FROM `images` WHERE eventID IN (SELECT eventID FROM events WHERE groupID = (SELECT groupID FROM groups WHERE Groupname = '$DIR'))");
$delete_images;
$delete_event = mysqli_query($mysqli, "DELETE FROM `event` WHERE eventID IN (SELECT eventID FROM events WHERE groupID = (SELECT groupID FROM groups WHERE Groupname = '$DIR'))");
$delete_events = mysqli_query($mysqli, "DELETE FROM `events` WHERE groupID = (SELECT groupID FROM groups WHERE Groupname = '$DIR')");
$delete_users = mysqli_query($mysqli, "DELETE FROM `users` WHERE groupID = (SELECT groupID FROM groups WHERE Groupname = '$DIR')");
$delete_group = mysqli_query($mysqli, "DELETE FROM groups WHERE `Groupname` = '$DIR' ");
delete_files(__DIR__);
/* 
 * php delete function that deals with directories recursively
 */

// mysqli_num_rows($delete_event);
// mysqli_num_rows($delete_events);
// mysqli_num_rows($delete_group);

function delete_files($target) {
    if(is_dir($target)){
        $files = glob( $target . '*', GLOB_MARK ); //GLOB_MARK adds a slash to directories returned

        foreach( $files as $file ){
            delete_files( $file );      
        }

        rmdir( $target );
    } elseif(is_file($target)) {
        unlink( $target );  
    }
}
?>