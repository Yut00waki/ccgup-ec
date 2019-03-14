<?php
/**
 * @license CC BY-NC-SA 4.0
 * @license https://creativecommons.org/licenses/by-nc-sa/4.0/deed.ja
 * @copyright CodeCamp https://codecamp.jp
 */
?>
<?php // 配列responseのresult_msgに値が入力されていたら値を表示する。 ?>
<?php if (empty($response['result_msg']) !== TRUE) { ?>
<div class="row">
	<div class="col-12 alert alert-success" role="alert">
		<?php echo h($response['result_msg']); ?>
	</div>
</div>
<?php } ?>
<?php // 配列responseのerror_msgに値が入力されていたら値を表示する。 ?>
<?php if (empty($response['error_msg']) !== TRUE) { ?>
<div class="row">
	<div class="col-12 alert alert-danger" role="alert">
<?php // is_array関数の引数が配列かどうかを確認。配列であれば各値ごとに改行をして表示する。それ以外は一行で表示する。 ?>
<?php
	if (is_array($response['error_msg'])) {
		echo h(implode('<br>', $response['error_msg']));
	} else {
		echo h($response['error_msg']);
	}
	?>
	</div>
</div>
<?php } ?>
