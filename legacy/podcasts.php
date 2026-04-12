<?php include "inc/header.php"; ?>

<section class="title-int">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="title-int-text">
					<h1>Podcasts <i class="fas fa-angle-right"></i> <span>Ouça nossas mensagens de onde estiver</span></h1>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="colors">
	<div class="container">
		<div class="row">
			<div class="cor1"></div>
			<div class="cor2"></div>
			<div class="cor3"></div>
		</div>
	</div>
</section>

<div class="claerfix"></div>

<section class="apresentacao-interna int">
	<div class="container">
		<div class="row">
			<div class="titulo-apresentacao">
				<h1>Mensagens <strong>para edificar</strong></h1>
				<p>Assista e ouça nossas pregações e cultos quando e onde quiser!</p>
			</div>
		</div>
	</div>
</section>

<section class="videos">
	<div class="container">
		<div class="row">

			<?php
			$sql_podcasts = mysql_query("SELECT * FROM _videos WHERE ativo = 'S' ORDER BY data_hora DESC");
			while ($dados_pod = mysql_fetch_array($sql_podcasts)) {

				$dia          = date('d', strtotime($dados_pod['data_hora']));
				$mes          = date('m', strtotime($dados_pod['data_hora']));
				$ano          = date('Y', strtotime($dados_pod['data_hora']));

				$meses = array(1=>'Jan',2=>'Fev',3=>'Mar',4=>'Abr',5=>'Mai',6=>'Jun',
				               7=>'Jul',8=>'Ago',9=>'Set',10=>'Out',11=>'Nov',12=>'Dez');
				$mes_nome = $meses[(int)$mes];
			?>
			<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="height: 370px;">
				<div class="box-video">
					<div class="row">
						<a href="videos/<?php echo $dados_pod['slug']; ?>">
							<?php if ($dados_pod['imagem_hd']) { ?>
								<img src="<?php echo $dados_pod['imagem_hd']; ?>" class="img-fluid">
							<?php } else { ?>
								<img src="https://img.youtube.com/vi/<?php echo $dados_pod['embed_video']; ?>/hqdefault.jpg" class="img-fluid">
							<?php } ?>
						</a>
					</div>
				</div>
				<div class="titulo-video">
					<span class="date"><i class="far fa-calendar-o"></i> <?php echo $dia; ?> <?php echo $mes_nome; ?> '<?php echo $ano; ?></span>
					<h4><?php echo $dados_pod['titulo']; ?></h4>
				</div>
			</div>
			<?php } ?>

		</div>
	</div>
</section>

<?php include "inc/footer.php"; ?>
