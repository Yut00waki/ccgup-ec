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

	$db = db_connect();
	$response = array();

	$max_page = get_max_page($db, $response);

	if(isset($_GET['page']) === true){
	    $page = $_GET['page'];
	}else{
	    $page = 1;
	}
	$start_item_number = ($page - 1) * MAX;
	$get_action = get_get_data('action');

	$response['items'] = select_sort_items($db, $get_action, $start_item_number);

	if(is_post() && check_token($response) === true){
        __regist($db, $response);
	}

	make_token();

	require_once DIR_VIEW  . 'top.php';
}

/**
 * @param PDO $db
 * @param array $response
 */
function __regist($db, &$response) {
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		return;
	}

	check_logined($db);

	if (empty($_POST['id']) === TRUE) {
		$response['error_msg'] = '商品の指定が不適切です。';
		return;
	}

	if (cart_regist($db, $_SESSION['user']['id'], $_POST['id'])) {
		$response['result_msg'] = 'カートに登録しました。';
		return;
	}

	$response['error_msg'] = 'カート登録に失敗しました。';
	return;
}