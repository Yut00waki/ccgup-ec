<!DOCTYPE HTML>
<html>
<head>
	<meta charset = "utf-8">
	<title>領収書</title>
</head>
<body>
	<?php  foreach($response['items'] as $value){     ?>
	<p>注文番号：<?php echo $value['id']?></p>
	<p>購入日時：<?php echo $value['date']?></p>
	<p>合計金額：<?php echo $value['sum']?></p>
	<?php }  ?>
	<table>
		<tr>
			<th>商品名</th>
			<th>商品価格</th>
			<th>数量</th>
			<th>小計</th>
		</tr>
		<?php foreach($response['items'] as $value){   ?>
		<tr>
			<td><?php echo $value['item_id']?></td>
			<td><?php echo $value['price']?></td>
			<td><?php echo $value['amount']?></td>
			<td><?php echo $value['amount_price']?></td>
		</tr>
		<?php } ?>
	</table>
</body>