<div class="well">
	<h3><?= $data->name ?></h3>
	<? if ($is_friend) : ?>
		<div class="alert alert-success">このユーザはフレンドです。</div>
	<? else : ?>
		<form method="POST" action="<?= site_url('user/greeting') ?>">
			<button type="submit" class="btn btn-success">エールを送る</button>
			<input type="hidden" name="id" value="<?= $data->id ?>" />
			<input type="hidden" name="body" value="<?= $user->name ?> さんがエールを送ってくれました。" />
		</form>
		<form method="POST" action="<?= site_url('user/friend_app') ?>">
			<button type="submit" class="btn btn-warning">フレンド申請</button>
			<input type="hidden" name="id" value="<?= $data->id ?>" />
		</form>
	<? endif; ?>
</div>
