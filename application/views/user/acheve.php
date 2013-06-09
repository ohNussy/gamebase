<div class="well">
	<h3>実績</h3>
	<? foreach ($data as $row) : ?>
		<div class="alert">
			<h4><img src="<?= $row->acheve->image ?>" /> <?= ( ( $row->complete ) ? $row->acheve->name : '？？？？？' ) ?></h4>
			<p><?= $row->acheve->body ?></p>
			<p><?= ( ( !$row->complete ) ? ( intval(($row->value / $row->acheve->value) * 10000) / 100 ) . '％' : $row->modified . ' 取得' ) ?></p>
		</div>
	<? endforeach; ?>
</div>

