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

    make_token();

    _order($db, $response);

    require_once DIR_VIEW . 'history.php';
}


function _order($db, &$response){

    $response['order_list'] = get_order_list_group_orderID($db, $_SESSION['user']['id']);

    if(empty($response['order_list']) === true){
        $response['error_msg'] = '購入した商品はありません';
        return;
    }
}