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

	foreach ($response['cart_items']as $item) {
		item_update_saled($db, $item['item_id'], $item['amount']);
	}
	$sql=<<<EOM
    INSERT INTO orders
    (user_id, purchase_date)
    VALUES (:user_id, NOW())
    EOM;
	$params = array(
	    ':user_id' =>  $_SESSION['user']['id']
	);
	db_update($db, $sql, $params = array());

	$order_id = $db->lastInsertId();
	foreach($response['cart_items'] as $items){
	    $sql=<<<EOM
        INSERT INTO order_details
        (order_id, item_id, purchase_price, amount)
        VALUES (:order_id, :item_id, :purchase_price, :amount)
        EOM;
	    $params = array(
	        ':order_id' =>  $order_id,
	        ':items_id' =>  $items['item_id'],
	        ':purchase_price' =>  $items['price'],
	        ':amount' => $items['amount']
	    );
	    db_update($db, $sql, $params = array());
	}

	cart_clear($db, $_SESSION['user']['id']);

	$response['result_msg'] = 'ご購入、ありがとうございました。';
}
