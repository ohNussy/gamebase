<div class="well">
	<h3>メール一覧</h3>
	<? foreach ($data as $row) : ?>
		<? $f_user = $row->fetchAs('user')->from_user; ?>
		<div class="alert">
			<h4><?= $f_user->name ?></h4>
			<p><?= $row->body ?></p>
			<form method="GET" action="<?= site_url("user/sendmail") ?>">
				<button type="submit" class="btn btn-danger">返信</button>
				<input type="hidden" name="id" value="<?= $f_user->id ?>" />
			</form>
			<form method="POST" action="<?= site_url('user/greeting') ?>">
				<button type="submit" class="btn btn-success">エールを送る</button>
				<input type="hidden" name="id" value="<?= $f_user->id ?>" />
				<input type="hidden" name="body" value="<?= $f_user->name ?> さんがエールを送ってくれました。" />
			</form>
		</div>
	<? endforeach; ?>
</div>

