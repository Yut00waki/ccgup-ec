<?php
/**
 * @license CC BY-NC-SA 4.0
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/deed.ja
 * @copyright CodeCamp https://codecamp.jp
 */
header('X-Flame-Options:DENY');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>商品一覧</title>
<link href="./assets/bootstrap/dist/css/bootstrap.min.css"
	rel="stylesheet">
<link rel="stylesheet" href="./assets/css/style.css">

</head>
<body>
<?php // ビューエレメントディレクトリのoutput_navber.phpを参照。ログイン、ログアウト、管理のアクセスを出す。 ?>
<?php require DIR_VIEW_ELEMENT . 'output_navber.php'; ?>
	<div class="container-fluid px-md-5">
		<div class="row">
			<div class="col-12">
				<h1>商品一覧</h1>
			</div>
		</div>
<?php // ビューエレメントディレクトリのoutput_message.phpを参照。エラーメッセージの表示。 ?>
<?php require DIR_VIEW_ELEMENT . 'output_message.php'; ?>
		<div class="row">
<?php // 配列responseのitemsから値を抽出。 ?>
<?php foreach ($response['items'] as $value)  { ?>
			<div class="card col-12 col-md-4 p-0 m-0 shadow-sm">
				<img class="rounded"
					src="<?php echo h(DIR_IMG . $value['img']); ?>">
				<div class="card-body">
					<div class="row item-info">
						<div class="col-12 item-price"><?php echo h($value['name']); ?>：<?php echo h(number_format($value['price'])); ?>円</div>
						<div class="col-12 mt-1">
<?php // 在庫数量が０以上であれば、それ以外であればの条件指定。 ?>
<?php if ($value['stock'] > 0) { ?>
							<form action="<?php echo h($_SERVER['SCRIPT_NAME']); ?>" method="post">
								<input type="hidden" name="id" value="<?php echo h($value['id']); ?>">
									<input type="hidden" name="token"
									value="<?php echo h($_SESSION['token']); ?>">

								<button type="submit" class="btn btn-primary cart-btn">カートに入れる</button>
							</form>
<?php } else { ?>
							<p class="sold-out">売り切れ</p>
<?php } ?>
						</div>
					</div>
				</div>
			</div>
<?php } ?>
		</div>
	</div>
	<div class="text-center margin_top">
	<?php if($page > 1){ ?>
	<a class="btn btn-primary cart-btn" href="./top.php?page=<?php echo h($page - 1); ?>">前へ</a>
	<?php  } ?>
	<?php for($p=1;$p<=$max_page;$p++){ ?>
		<?php if($p === (int)$page){ ?>
			<div class="btn btn-info cart-btn"><?php echo h($p); ?></div>
		<?php }else{  ?>
			<a class="btn btn-primary cart-btn" href="./top.php?page=<?php echo h($p); ?>"><?php echo h($p); ?></a>
		<?php  } ?>
	<?php  } ?>
	<?php if($page < $max_page){ ?>
	<a class="btn btn-primary cart-btn" href="./top.php?page=<?php echo h($page + 1); ?>">次へ</a>
	<?php  } ?>
	</div>
	<!-- /.container -->
	<script src="./assets/js/jquery/1.12.4/jquery.min.js"></script>
	<script src="./assets/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
