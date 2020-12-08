<?php
require('../../../../../includes/config.inc.php');
$DIR = basename(__DIR__);
$delete_images = mysqli_query($mysqli, "DELETE FROM `images` WHERE eventID IN (SELECT eventID FROM `event` WHERE Eventname = '$DIR')");
$delete_images;
$delete_events = mysqli_query($mysqli, "DELETE FROM `events` WHERE eventID = (SELECT eventID FROM `event` WHERE Eventname = '$DIR')");
$delete_event = mysqli_query($mysqli, "DELETE FROM `event` WHERE Eventname = '$DIR'");
delete_files(__DIR__);

/* 
 * php delete function that deals with directories recursively
 */



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