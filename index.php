<?php include 'layouts/header.php'; ?>

<style>
	body.home{
		background-image: url("public/images/main_backgrounds/bg.jpeg");
	}
</style>

<body class="home" id="home">
	<div id="bg-overlay"></div>

	<div class="main_wrapper">
        <i class="fa fa-info-circle homosexuals-info"></i>
		<a href="/">
			<img class="logo" src="public/images/venus-logo.png" />
		</a>
		<form id="main_form" method="POST" action="">
			<div class="form-group">
				<input type="text" class="form-control" id="postcode" name="postcode" placeholder="Digite aqui o CEP..." autocomplete="off"><span class="gambi__border"></span>
				<button class="btn btn-navy btn-border" id="fetch__postcode__data">obter dados</button>
			</div>
		</form>

		<div class="preview__postcode__data">
			<div class="preview__loading">
				<?php include 'public/images/loading.svg'; ?>
			</div>
			<div class="wrapper"></div>	
		</div>
	</div>
</body>

<?php include 'layouts/footer.php'; ?>