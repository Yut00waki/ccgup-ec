<?php
/**
 * @license CC BY-NC-SA 4.0
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/deed.ja
 * @copyright CodeCamp https://codecamp.jp
 */

/**
 * @param PDO $db
 * @param string $name
 * @param string $img
 * @param int $price
 * @param int $stock
 * @param int $status
 * @return number
 */
function item_regist($db, $name, $img, $price, $stock, $status) {
	$sql = <<<EOD
INSERT INTO items (name, img, price, stock, status, create_date, update_date)
 VALUES (:name, :img, :price, :stock, :status, NOW(), NOW());
EOD;
	$params = array(
	    ':name' => $name,
	    ':img' => $img,
	    ':price' => $price,
	    ':stock' => $stock,
	    ':status' => $status
	);
	return db_update($db, $sql, $params);
}

/**
 * @param PDO $db
 * @param int $id
 * @return number
 */
function item_delete($db, $id) {
	$row = item_get($db, $id);

	if (!empty($row)) {
		@unlink(DIR_IMG_FULL . $row['img']);
	}
	$sql = 'DELETE FROM items WHERE id = :id' ;
	$params = array(
	    ':id' => $id
	);
	return db_update($db, $sql, $params);
}

/**
 * @param PDO $db
 * @return array
 */
function item_list($db, $is_active_only = true) {
	$sql = <<<EOD
 SELECT id, name, price, img, stock, status, create_date, update_date
 FROM items
EOD;

	if ($is_active_only) {
		$sql .= " WHERE status = 1";
	}
     // $params = array();
    return db_select($sql, $db);
}
function get_count_item($db, $is_active_only = true) {
    $sql = <<<EOD
 SELECT count(*)  as count
 FROM items
EOD;
    if ($is_active_only) {
        $sql .= " WHERE status = 1";
    }
    return db_select($sql, $db);
}

/**
 * @param PDO $db
 * @param int $id
 * @return NULL|mixed
 */
function item_get($db, $id) {
	$sql = <<<EOD
 SELECT id, name, price, img, stock, status, create_date, update_date
 FROM items
 WHERE id = :id
EOD;
	$params = array(
	    ':id' => $id
	);
	return db_select_one($sql, $db, $params);
}

/**
 *
 * @param PDO $db
 * @param array $cart_items
 * @return boolean
 */
function item_update_stock($db, $id, $stock) {
	$sql = <<<EOD
 UPDATE items
 SET stock = :stock, update_date = NOW()
 WHERE id = :id
EOD;
	$params = array(
	    ':stock' => $stock,
	    ':id' => $id
	);
	return db_update($db, $sql, $params);
}

/**
 *
 * @param PDO $db
 * @param array $cart_items
 * @return boolean
 */
function item_update_saled($db, $id, $amount) {
	$sql = <<<EOD
 UPDATE items
 SET stock = stock - :amount, update_date = NOW()
 WHERE id = :id
EOD;
	$params = array(
	    ':amount' => $amount,
	    ':id' => $id
	);
	return db_update($db, $sql, $params);
}

/**
 *
 * @param PDO $db
 * @param array $cart_items
 * @return boolean
 */
function item_update_status($db, $id, $status) {
	$sql = <<<EOD
 UPDATE items
 SET status = :status, update_date = NOW()
 WHERE id = :id
EOD;
	$params = array(
	    ':status' => $status,
	    ':id' => $id
	);
	return db_update($db, $sql, $params);
}

/**
 * @param string $status
 * @return boolean
 */
function item_valid_status($status) {
	return "0" === (string)$status || "1" === (string)$status;
}

function get_max_page($db, &$response){
    $items_count = get_count_item($db);

    return ceil($items_count[0]['count'] / ITEMS_PER_PAGE);
}


function start_item_number($page){
    return ($page - 1) * ITEMS_PER_PAGE;
}

function sort_item($db, $sort, $page, $is_active_only = true){
    $start_item_number = start_item_number($page);
    $sql = 'SELECT
            id,
            name,
            price,
            img,
            stock,
            status,
            create_date,
            update_date
            FROM items';

    if ($is_active_only) {
        $sql .= ' WHERE status = 1';
    }
    $sql .= ' ORDER BY ' . $sort;
    $sql .= ' LIMIT :start_item_number,:items_per_page';

    $params = array(
        ':start_item_number' => $start_item_number,
        ':items_per_page' => ITEMS_PER_PAGE
    );
    return db_select($sql, $db, $params);
}


function select_sort_items($db, $get_action, $page){
    switch ($get_action) {
        case '' :
        case 'new_item' :
            $sort = 'id DESC';
            break;
        case 'cheap_item' :
            $sort = 'price ASC';
            break;
        case 'expensive_item'  :
            $sort = 'price DESC';
            break;
    }
    return sort_item($db, $sort, $page);
}