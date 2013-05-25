<div class="well">
	<h3>フレンド一覧</h3>
	<? foreach ($data as $row) : ?>
		<? $f_user = $row->fetchAs('user')->to_user; ?>
		<div class="alert">
			<?= $f_user->name ?>
			<form method="POST" action="<?= site_url('user/greeting') ?>">
				<button type="submit" class="btn btn-success">エールを送る</button>
				<input type="hidden" name="id" value="<?= $data->id ?>" />
				<input type="hidden" name="body" value="<?= $user->name ?> さんがエールを送ってくれました。" />
			</form>
			<form method="POST" action="<?= site_url('user/friend_del') ?>">
				<button type="submit" class="btn btn-danger">フレンド解除</button>
				<input type="hidden" name="id" value="<?= $f_user->id ?>" />
			</form>
		</div>
	<? endforeach; ?>
</div>

