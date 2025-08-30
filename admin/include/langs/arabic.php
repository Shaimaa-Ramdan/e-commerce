<?php 
function langs($pharse){
    static $langs=array(
        'message' => 'welcome in arabic',
        'admin' => 'administerator in arabic'

    );
   return $langs[$pharse] ;
}?>
