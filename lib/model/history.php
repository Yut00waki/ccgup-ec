<?php

function get_order_list($db, $user_id){
    $sql=<<<EOM
SELECT
    orders.order_id,
    orders.purchase_date,
    order_details.purchase_price,
    order_details.amount,
    items.name
FROM
    orders
    INNER JOIN
        order_details
    ON
        orders.order_id=order_details.order_id
    INNER JOIN
        items
    ON
        order_details.item_id=items.id
WHERE user_id = :user_id
EOM;
    $params = array(
        ':user_id' => $user_id,
    );
    return db_select($sql, $db, $params);
}


function get_order_detail_list($db, $user_id, $order_id){
    $sql=<<<EOM
SELECT
    orders.order_id,
    orders.purchase_date,
    order_details.purchase_price,
    order_details.amount,
    items.name
FROM
    orders
    INNER JOIN
        order_details
    ON
        orders.order_id=order_details.order_id
    INNER JOIN
        items
    ON
        order_details.item_id=items.id
WHERE user_id = :user_id AND orders.order_id = :order_id
EOM;
    $params = array(
        ':user_id' => $user_id,
        ':order_id' => $order_id
    );
    return db_select($sql, $db, $params);
}

function order_details_regist($db, $order_id, $item_id, $price, $amount){
    $sql=<<<EOM
       INSERT INTO order_details
       (order_id, item_id, purchase_price, amount)
       VALUES (:order_id, :item_id, :purchase_price, :amount)
       EOM;
    $params = array(
        ':order_id' =>  $order_id,
        ':item_id' =>  $item_id,
        ':purchase_price' =>  $price,
        ':amount' => $amount
    );
    return db_update($db, $sql, $params);
}

function orders_regist($db, $user_id){
    $sql=<<<EOM
            INSERT INTO orders
            (user_id)
            VALUES (:user_id)
            EOM;
    $params = array(
        ':user_id' =>  $user_id
    );
    return db_update($db, $sql, $params);
}
// 購入済商品の注文番号、その合計額を抽出する関数。
function sales_list($order_list){
    $total_sales_list = array();
    foreach($order_list as $order){
        $total_sales_list[$order['order_id']] = '0';
        $total_sales_list[$order['order_id']] += ($order['purchase_price'] * $order['amount']);
    }
    return $total_sales_list;
}