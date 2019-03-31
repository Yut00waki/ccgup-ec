<!DOCTYPE HTML>
<html>
<head>
	<meta charset = "utf-8">
	<title>領収書</title>
	<link href="./assets/css/history.css" rel="stylesheet">
</head>
<body>
	<?php require DIR_VIEW_ELEMENT . 'output_message.php'; ?>
	<h1>購入明細</h1>
	<?php  foreach($response['total_sales_list'] as $key => $value){   ?>
	<p>注文番号：<?php echo h($key); ?></p>
	<p>購入日時：<?php // echo  ?></p>
	<p>合計金額：<?php echo h(number_format($value)); ?>円</p>
	<?php }  ?>
	<table border=!>
		<tr>
			<th>商品名</th>
			<th>商品価格</th>
			<th>購入個数</th>
			<th>小計</th>
		</tr>
		<?php foreach($response['order_list'] as $value){   ?>
		<tr>
			<td><?php echo h($value['name']);?></td>
			<td><?php echo h(number_format($value['purchase_price'])); ?></td>
			<td><?php echo h($value['amount']); ?></td>
			<td><?php echo h($value['purchase_price'] * $value['amount']); ?>円</td>
		</tr>
		<?php } ?>
	</table>
</body>