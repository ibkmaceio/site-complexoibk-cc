<?php
session_start();

if(!empty($_SESSION['id'])){
	echo "<script>document.location='painel';</script>";
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<!-- METATAGS -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
	<meta name="description" content="">
	<meta name="author" content="Rota 3 Agencia Full">
	<title>Gestor de Conteúdo - Rota 3 Agencia Full</title>

	<link rel="stylesheet" href="assets/css/uikit.min.css">
	<link rel="stylesheet" href="assets/css/login.css">

	<script src="http://code.jquery.com/jquery-1.5.1.js" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$("#login_form").submit(function(){
				$("#msgbox").removeClass().addClass('messagebox').text('Validando login, aguarde!').fadeIn(1000);
				$.post("ajax_login.php",{ user_name:$('#email').val(),password:$('#password').val(),rand:Math.random() } ,function(data){
					if(data=='yes')
					{
						$("#msgbox").fadeTo(200,0.1,function()
						{
							$(this).html('Logado! Carregando sistema...').addClass('messageboxok').fadeTo(900,1,
								function()
								{
									document.location='painel';
								});
						});
					}
					else
					{
						$("#msgbox").fadeTo(200,0.1,function()
						{
							$(this).html('Inicie com seu login corretamente!').addClass('messageboxerror').fadeTo(900,1);
						});
					}

				});
				return false;
			});
			$("#password").blur(function()
			{
				$("#login_form").trigger('submit');
			});
		});
	</script>

</head>
<body>


	<div class = "container">
		<div class="wrapper">
			<form action="" method="post" id="login_form" name="Login_Form" class="form-signin" autocomplete="off">
				<h1 class="uk-heading-line"><span>Login</span></h1>

				<div class="uk-margin">
					<div class="uk-inline uk-width-1-1">
						<span class="uk-form-icon" uk-icon="icon: user"></span>
						<input class="uk-input" type="text" name="email" id="email" placeholder="Digite seu email" readonly autocomplete="off" onfocus="if (this.hasAttribute('readonly')) {this.removeAttribute('readonly');this.blur();this.focus();}">
					</div>
				</div>

				<div class="uk-margin">
					<div class="uk-inline uk-width-1-1">
						<span class="uk-form-icon" uk-icon="icon: lock"></span>
						<input class="uk-input" type="password" name="password" id="password" placeholder="Digite sua senha" readonly autocomplete="off" onfocus="if (this.hasAttribute('readonly')) {this.removeAttribute('readonly');this.blur();this.focus();}">
					</div>
				</div>

				<button class="uk-button uk-width-1-1 uk-margin-small-bottom uk-label-success" type="submit" id="submit" name="Submit">Entrar</button>

				<span id="msgbox" style="display:none;"></span>
			</form>
		</div>
	</div>

	<a href="http://www.rota3.com.br/" target="_blank" rel="noopener noreferrer"><img src="./assets/img/rota-3.png" alt="Rota 3 Agencia" class="by"></a>

	<!-- CDN javascript extern -->
	<!-- CDN jquery latest version -->
	<script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
	<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.4.min.js"><\/script>')</script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.12/js/uikit.min.js"></script>


	<script>
		// AUTOCOMPLETE - FALSE
		if (navigator.userAgent.toLowerCase().indexOf("chrome") >= 0) {
			$(window).load(function(){
				$('input:-webkit-autofill').each(function(){
					var text = $(this).val();
					var name = $(this).attr('name');
					$(this).after(this.outerHTML).remove();
					$('input[name=' + name + ']').val(text);
				});
			});
		}
	</script>

</body>
</html>
