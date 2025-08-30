<?php 
function langs($phrase){
    static $langs=array(
        //NAVBAR phrases
        'HOME-ADMIN' => 'HOME',
        'CATEGORIES' => 'CATEGORIES',
        'ITEMS'    => 'ITEMS',
        'MEMBERS'    => 'MEMBERS',
        'COMMENTS' => 'COMMENTS',
        'STATISTICS' => 'STATISTICS',
        'LOGS' => 'LOGS',
        '' => '',
        '' => '',
        '' => '',

    );
   return $langs[$phrase] ;
}?>
