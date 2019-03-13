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
    WHERE login_id = :login_id AND password = :password';
    EOM;
 /* $stmt->bindValue('login_id',$login_id,PARAM_STR);
    $stmt->bindValue('password',$password,PARAM_STR);  */
    $params = array(
        'login_id' => $login_id,
        'password' => $password
    );
 //   $stmt->execute($params);
    return db_select_one($sql, $db, $params);
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
 WHERE id = ?
EOD;
    $params = array(
        $id
    );
    return db_select_one($db, $sql, $params);
}
