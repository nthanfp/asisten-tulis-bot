<?php
header('Content-Type: application/json');
require('../lib/config.php');
$table          = 'tbl_message';
$primaryKey     = 'id_message';
//$joinQuery      = "FROM `{$table}` AS `re` INNER JOIN `tbl_instagram` AS `us` ON (`re`.`id_instagram` = `us`.`id_instagram`)";
//$extraCondition = "id_user='".$id_user."'";
$columns        = array(
    array(
        'db' => 'date',
        'dt' => 0,
        'field' => 'date',
        'formatter' => function($d, $row){
            // return date('d M Y H:i:s', $d);
            return $d;
        }
    ),
    array(
        'db' => 'chat_id',
        'dt' => 1,
        'field' => 'chat_id'
    ),
    array(
        'db' => 'text',
        'dt' => 2,
        'field' => 'text',
        'formatter' => function($d, $row){
            return nl2br($d);
        }
    )
);
 
echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, null, null));
//echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition));