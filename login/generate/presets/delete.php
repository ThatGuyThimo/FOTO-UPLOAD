<?php
require('../../../includes/config.inc.php');
$DIR = basename(__DIR__);
var_dump($DIR);
$delete = mysqli_query($mysqli, "DELETE FROM `images` WHERE eventID = (SELECT eventID FROM events WHERE groupID = (SELECT groupID FROM groups WHERE Groupname = '$DIR'))");
$delete2 = mysqli_query($mysqli, "DELETE FROM `events` WHERE groupID = (SELECT groupID FROM groups WHERE Groupname = '$DIR')");
$result = mysqli_query($mysqli, "DELETE FROM groups WHERE `Groupname` = '$DIR' ");
var_dump($delete);
delete_files(__DIR__);
/* 
 * php delete function that deals with directories recursively
 */
mysqli_num_rows($delete);
mysqli_num_rows($delete2);
mysqli_num_rows($result);

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