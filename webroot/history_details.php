<?php

require_once '../lib/config/const.php';

require_once DIR_MODEL . 'function.php';
require_once DIR_MODEL . 'history.php';
require_once DIR_MODEL . 'item.php';

{
    session_start();

    $db = db_connect();
    $response = array();

    check_logined($db);

    _order_details($db, $response);

    require_once DIR_VIEW . 'history_details.php';
}


function _order_details($db, &$response){
    if(is_get() === 'false'){
        return;
    }
    if(empty($_GET['order_id']) === 'true'){
        return;
    }

    $response['order_list'] = get_order_detail_list($db, $_SESSION['user']['id'], $_GET['order_id']);
    if(empty($response['order_list']) === true){
        $response['error_msg'] = '購入した商品はありません';
        return;
    }
    return $response['order_list'];
}