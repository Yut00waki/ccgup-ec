<?php
/**
 * @license CC BY-NC-SA 4.0
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/deed.ja
 * @copyright CodeCamp https://codecamp.jp
 */

/**
 * @param PDO $db
 * @param int $login_id
 * @param string $password
 * @return NULL|array
 */

function user_get_login($db, $login_id, $password) {
    $sql = <<<EOM
    'SELECT id, login_id, password, is_admin, create_date, update_date
    FROM users
    WHERE login_id = ? AND password = ?';
    >>>
    $stmt=$db->prepare($sql);
    $stmt->bindValue(1,$login_id,PARAM_STR);
    $stmt->bindValue(2,$password,PARAM_STR);
    $stmt->execute();
    $rows=$stmt->fetchAll();

	return db_select_one($db, $sql);
}

/**
 * @param PDO $db
 * @param int $id
 * @return NULL|array
 */
function user_get($db, $id) {
	$sql = <<<EOD
 SELECT id, login_id, password, is_admin, create_date, update_date
 FROM users
 WHERE id = {$id}
EOD;

	return db_select_one($db, $sql);
}
