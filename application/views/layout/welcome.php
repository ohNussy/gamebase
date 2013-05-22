<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<title>gamebase</title>
		<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="<?= site_url('/assets/flatstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
		<style type="text/css">
			body {
				padding-top: 60px;
				padding-bottom: 40px;
			}
			.sidebar-nav {
				padding: 9px 0;
			}
		</style>
		<link href="<?= site_url('/assets/flatstrap/css/bootstrap-responsive.min.css') ?>" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Fav and touch icons -->
		<link rel="shortcut icon" href="<?= site_url('/assets/ico/favicon.ico') ?>">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?= site_url('/assets/ico/apple-touch-icon-144-precomposed.png') ?>">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?= site_url('/assets/ico/apple-touch-icon-114-precomposed.png') ?>">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?= site_url('/assets/ico/apple-touch-icon-72-precomposed.png') ?>">
		<link rel="apple-touch-icon-precomposed" href="<?= site_url('/assets/ico/apple-touch-icon-57-precomposed.png') ?>">
	</head>

	<body>

		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a class="brand" href="<?= site_url('#') ?>">gamebase</a>
					<form class="navbar-form pull-right" action="<?= site_url('login') ?>">
						<? if ($user) : ?>
							<p class="navbar-text pull-right">
								<img src="<?= $user->icon_url ?>" width="24" />
								<?= $user->name ?>
							</p>
						<? else: ?>
							<button type="submit" class="btn btn-primary">Start</button>
						<? endif; ?>
					</form>
				</div>
			</div>
		</div>

		<div class="container-fluid">
			<div class="row-fluid">
				<?= $contents ?>
				<div class="span3">
					<div class="well sidebar-nav">
						<ul class="nav nav-list">
							<li class="nav-header">■メニュー■</li>
							<li class="active"><a href="<?= site_url('') ?>">Top</a></li>
							<li><a href="<?= site_url('rule') ?>">ゲームのルール</a></li>
							<li><a href="<?= site_url('gamelogs') ?>">過去のゲームログ</a></li>
							<li><a href="<?= site_url('chatlogs') ?>">過去のチャットログ</a></li>
						</ul>
					</div><!--/.well -->
				</div><!--/span-->
			</div><!--/row-->

			<hr>

			<footer>
				<p>&copy; Company 2012</p>
			</footer>

		</div><!--/.fluid-container-->

		<!-- Le javascript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<script src="<?= site_url('assets/flatstrap/js/bootstrap.min.js') ?>"></script>


	</body>
</html>
