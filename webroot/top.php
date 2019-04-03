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

	if(is_post() && check_token($response) === true){
        __regist($db, $response);
	}
	$response['items'] = item_list($db);

	sort_items($db, $response);

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
function sort_items($db, &$response){
    if(isset($_GET['action']) === false){
        $response['error_msg'] = 'ソートの条件が指定できておりません。';
        return;
    }
    switch ($_GET['action']) {
        case 'new_item' :
            $response['items'] = sort_new_item($db);
            break;
        case 'cheap_item' :
            $response['items'] = sort_cheap_item($db);
            break;
        case 'expensive_item'  :
            $response['items'] = sort_expensive_item($db);
            break;
    }
}