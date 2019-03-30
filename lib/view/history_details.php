<!DOCTYPE HTML>
<html>
<head>
	<meta charset = "utf-8">
	<title>領収書</title>
</head>
<body>
	<?php  foreach($response['order_list'] as $value){     ?>
	<p>注文番号：<?php echo $value['order_id']?></p>
	<p>購入日時：<?php echo $value['purchase_date']?></p>
	<p>合計金額：<?php echo $value['sum']?></p>
	<?php }  ?>
	<table border=!>
		<tr>
			<th>商品名</th>
			<th>商品価格</th>
			<th>数量</th>
			<th>小計</th>
		</tr>
		<?php foreach($response['order_list'] as $value){   ?>
		<tr>
			<td><?php echo h($value['name']);?></td>
			<td><?php echo h($value['purchase_price']); ?></td>
			<td><?php echo h($value['amount']); ?></td>
			<td><?php echo h($value['purchase_price'] * $value['amount']); ?></td>
		</tr>
		<?php } ?>
	</table>
</body>