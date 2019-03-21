<?php
/**
 * @license CC BY-NC-SA 4.0
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/deed.ja
 * @copyright CodeCamp https://codecamp.jp
 */
require_once '../lib/config/const.php';

require_once DIR_MODEL . 'function.php';
require_once DIR_MODEL . 'user.php';

{
    // セッションの開始、データベースへの接続呼び出し。
	session_start();
	$db = db_connect();
    // 配列の初期化
	$response = array();

	__check_logined($db);

	if(check_token() === true){
	    __login($db, $response);
	}
    make_token();

	// 上記満たさなかった場合は'login.php'を参照する。
	require_once DIR_VIEW  . 'login.php';
}

/**
 * @param PDO $db
 */
// セッションにある値を確認する処理。
function __check_logined($db) {
    // $_SESSION['user']が空であれば呼び出し元へ移動する。
	if (empty($_SESSION['user'])) {
		return;
	}
	// $_SESSION['user']['id']がデータベース上になければ./logout.phpへ強制移動。
	$user = user_get($db, $_SESSION['user']['id']);
	if (empty($user)) {
		header('Location: ./logout.php');
		exit;
	}
	// $_SESSION['user']['is_admin']がデータベース上になければ./top.php'へそれ以外は./admin.phpへ強制移動。
	if (empty($_SESSION['user']['is_admin'])) {
		header('Location: ./top.php');
	} else {
		header('Location: ./admin.php');
	}
	exit;
}

/**
 * @param PDO $db
 * @param array $response
 */
// ログイン操作をユーザーが行った時の処理。
function __login($db, &$response) {
    // リクエストメソッドがPOSTでなければ呼び出し元に移動する。
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		return;
	}

	$user = user_get_login($db, $_POST['login_id'], $_POST['password']);
	// データがなければエラーを表示。呼び出し元に移動する。
	if (empty($user)) {
		$response['error_msg'] = 'IDまたはパスワードが違います。';
		return;
	}
    // データがあればセッションに格納。
	$_SESSION['user'] = $user;
	// $user['is_admin']管理者権限がなければ./top.phpへあれば./admin.phpへ移動。
	if (empty($user['is_admin'])) {
		header('Location: ./top.php');
	} else {
		header('Location: ./admin.php');
	}
	exit;
}
