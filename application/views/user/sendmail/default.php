<div class="well">
	<h3>メール送信</h3>
	<form method="POST" action="<?= site_url("user/sendmail") ?>">
		<div class="alert">
			<h4>To <?= $data->name ?></h4>
			<textarea name="body" rows="4" cols="80"></textarea><br/>
			<button type="submit" class="btn btn-danger">返信</button>
			<input type="hidden" name="id" value="<?= $data->id ?>" />
			<input type="hidden" name="mode" value="confirm" />
		</div>
	</form>
</div>

