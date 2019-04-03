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

    _order($db, $response);

    require_once DIR_VIEW . 'history_details.php';
}

function _order($db, &$response){
    if(isset($_GET['order_id']) === false){
        return;
    }

    $response['order_detail_list'] = get_order_detail_list($db, $_SESSION['user']['id'], $_GET['order_id']);
    $sum = 0;
    foreach($response['order_detail_list'] as $value){
        $sum += $value['purchase_price'] * $value['amount'];
    }
    $response['sum'] = $sum;
    if(empty($response['order_detail_list']) === true){
        $response['error_msg'] = '購入した商品はありません';
        return;
    }
}