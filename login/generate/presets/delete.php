<?php
require('../../../includes/config.inc.php');
$DIR = basename(__DIR__);
delete_files(__DIR__);
$result = mysqli_query($mysqli, "DELETE FROM groups WHERE `Groupname` = '$DIR' ");
/* 
 * php delete function that deals with directories recursively
 */

if (mysqli_num_rows($result) !== NULL) {
    echo 'deleted';
} else {
    echo 'Geen resultaat gevonden';
}

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