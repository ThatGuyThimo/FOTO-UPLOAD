<?php

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
        header("../../groepselect.php");

        rmdir( $target );
    } elseif(is_file($target)) {
        unlink( $target );  
    }
}
?>