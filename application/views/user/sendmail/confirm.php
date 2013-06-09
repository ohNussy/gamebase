<div class="well">
	<h3>メール送信</h3>
	<form method="POST" action="<?= site_url("user/sendmail") ?>">
		<div class="alert">
			<p>この内容を送信しますか？</p>
			<h4>To <?= $data->name ?></h4>
			<p><?= nl2br($body) ?></p>
			<button type="submit" class="btn btn-danger">確定</button>
			<input type="hidden" name="id" value="<?= $data->id ?>" />
			<input type="hidden" name="body" value="<?= $body ?>" />
			<input type="hidden" name="mode" value="transmit" />
		</div>
	</form>
</div>

