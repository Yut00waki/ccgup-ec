<?php
/**
 * @license CC BY-NC-SA 4.0
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/deed.ja
 * @copyright CodeCamp https://codecamp.jp
 */
require_once '../lib/config/const.php';

require_once DIR_MODEL . 'function.php';
require_once DIR_MODEL . 'cart.php';
require_once DIR_MODEL . 'item.php';
require_once DIR_MODEL . 'history.php';

{
	session_start();

	$response = array();
	$db = db_connect();

	check_logined($db);

	__finish($db, $response);

	require_once DIR_VIEW . 'finish.php';
}

/**
 * @param PDO $db
 * @param array $response
 */
function __finish($db, &$response) {
	if(check_token($response) === false){
	    return;
	}


	$response['cart_items'] = cart_list($db, $_SESSION['user']['id']);
	if (empty($response['cart_items'])) {
		$response['error_msg'] = 'カートに商品がありません。';
		return;
	}
	$response['total_price'] = cart_total_price($db, $_SESSION['user']['id']);

    $db -> beginTransaction();
    try{
    	foreach ($response['cart_items']as $item) {
    		item_update_saled($db, $item['item_id'], $item['amount']);
    	}
    	orders_regist($db, $_SESSION['user']['id']);

    	$order_id = $db->lastInsertId();
    	foreach($response['cart_items'] as $items){
    	    order_details_regist($db, $order_id, $items['item_id'], $items['price'], $items['amount']);
    	}

    	cart_clear($db, $_SESSION['user']['id']);
    	$response['result_msg'] = 'ご購入、ありがとうございました。';

    	$db -> commit();
    }catch(PDOException $e){
        $response['error_msg'] = 'db_error:' . $e->getTraceAsString();
        $db -> rollBack();
    }
}
