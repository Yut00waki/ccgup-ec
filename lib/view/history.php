<!DOCTYPE HTML>
<html>
<head>
	<meta charset = "utf-8">
	<title>購入履歴画面</title>
</head>
<body>
	<?php require DIR_VIEW_ELEMENT . 'output_message.php'; ?>
	<table border=1>
		<tr>
			<th>注文番号</th>
			<th>購入日時</th>
			<th>合計金額</th>
			<th>明細</th>
		</tr>
		<?php foreach($response['total_sales_list'] as $key => $value){   ?>
		<tr>
			<td><?php echo h($key); ?></td>
			<td><?php echo h($value['purchase_date']); ?></td>
			<td><?php echo h($value); ?></td>
			<form method="get" action="./history_details.php ">
			<td>
				<input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
				<input type="hidden" name="order_id" value="<?php echo h($key);?>">
			    <input type="submit" value="確認">
			</td>
			</form>
		</tr>
		<?php } ?>
	</table>
</body>
</html>