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
    // 不明
	$response = array();

	__check_logined($db);
	__login($db, $response);
    // 不明
	require_once DIR_VIEW  . 'login.php';
}

/**
 * @param PDO $db
 */
//
function __check_logined($db) {
    // $_SESSION['user']が空であればリターン？する。
	if (empty($_SESSION['user'])) {
		return;
	}

	$user = user_get($db, $_SESSION['user']['id']);
	if (empty($user)) {
		header('Location: ./logout.php');
		exit;
	}

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
function __login($db, &$response) {
	if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
		return;
	}

	$user = user_get_login($db, $_POST['login_id'], $_POST['password']);
	if (empty($user)) {
		$response['error_msg'] = 'IDまたはパスワードが違います。';
		return;
	}

	$_SESSION['user'] = $user;

	if (empty($user['is_admin'])) {
		header('Location: ./top.php');
	} else {
		header('Location: ./admin.php');
	}
	exit;
}
