<?php include "inc/header.php"; ?>

<?php

$sql = "SELECT * FROM _institucional WHERE ativo = 'S' order by id DESC";
$bd->consulta($sql);
$bd->first();
$row = $bd->getRows();

for ($i = 1; $i <= $row; $i++) {
$dados = $bd->getDados();

?>

<section class="title-int">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="title-int-text">
					<h1>Institucional <i class="fas fa-angle-right"></i> <span>Conheça a IBK</span></h1>
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
			<h1 class="uk-heading-line uk-text-center title"><span><?php echo $dados['titulo']; ?></span></h1>
			<p><?php echo $dados['titulo_breve']; ?></p>
		</div>
	</div>
</section>

<section class="apresentacao-interna cont titulo_arrow_2">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 tira-padding-left tira-padding-right">
				<div class="uk-column-1-2 uk-column-divider">
					<h1>Visão</h1>
					<p><p><?php echo $dados['visao']; ?></p></p>


					<h1>Valores</h1>
					<p><?php echo $dados['valores']; ?></p>
				</div>
			</div>
		</div>
	</div>

	<div class="container text-int-history" style="margin-top: 80px;">
		<div class="row">
			<div class="col-sm-12 tira-padding-left tira-padding-right">
				<h1>O que cremos?</h1>
				<p><?php echo $dados['o_que_cremos']; ?></p>
			</div>
		</div>
	</div>
</section>

<div class="clearfix"></div>

<section class="slider-int">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 tira-padding-left tira-padding-right">
				<div class="clearfix" style="margin-top: 50px;"></div>

				<?php if ($dados['video'] == 'S') { ?>
					<iframe width="100%" class="video_institucional" frameborder="0" src="https://www.youtube.com/embed/<?php echo $dados['embed_video']; ?>" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				<?php } else {} ?>

				<div class="uk-position-relative uk-visible-toggle uk-light" uk-slider>
					<ul class="uk-slider-items uk-child-width-1-2 uk-child-width-1-3@m">
						<?php
                        $sql_foto = "SELECT * FROM _institucional as ga INNER JOIN _institucional_galeria as gi ON ga.id = gi.id_galeria_album WHERE ga.ativo = 'S' AND ga.id = $dados[id] ";
                        $bd->consulta($sql_foto);
                        $bd->first();
                        $row = $bd->getRows();

                        for($i=1; $i<=$row; $i++){
                        $dados_pic = $bd->getDados();
                        ?>
						<li>
							<img src="./cms/timthumb.php?src=<?php echo $dados_pic['caminho'];?>&w=370&h=550&q=100" alt="">
						</li>
						<?php $bd->next(); } ?>
					</ul>

					<a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
					<a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>

				</div>
			</div>
		</div>
	</div>
</section>

<?php } ?>
<?php include "inc/footer.php"; ?>