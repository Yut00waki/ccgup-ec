<!DOCTYPE HTML>
<html>
<head>
	<meta charset = "utf-8">
	<title>購入履歴画面</title>
</head>
<body>
	<table>
		<tr>
			<th>注文番号</th>
			<th>購入日時</th>
			<th>合計金額</th>
			<th>明細</th>
		</tr>
		<?php foreach($response['items'] as $value){   ?>
		<tr>
			<td><?php echo $value['id']?></td>
			<td><?php echo $value['sum']?></td>
			<td><?php echo $value['date']?></td>
			<form method="post" action="../webroot/detail_history.php ">
			<td>
			    <input type="hidden" name="date" value="<?php echo $value['date'];?>">
				<input type="hidden" name="user_id" value="<?php echo $value['user_id'];?>">
			    <input type="submit" value="確認">
			</td>
			</form>
		</tr>
		<?php } ?>
	</table>
</body>
</html>