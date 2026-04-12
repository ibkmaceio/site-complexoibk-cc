<?php include "inc/header.php"; ?>

<?php

$slug = mysql_real_escape_string($_GET['slug']);
$sql_views = mysql_query("UPDATE _noticias SET views = views+1 WHERE slug = '{$slug}' ");

$sql_all = mysql_query("SELECT * FROM _noticias WHERE slug = '{$slug}' ");
$dados_all = mysql_fetch_array($sql_all);

$dia            = date('d', strtotime($dados_all['data_criacao']));
$mes_completo   = date('m', strtotime($dados_all['data_criacao']));
$ano            = date('Y', strtotime($dados_all['data_criacao']));

switch ($mes_completo){
	case 1:  $mes_completo = "Jan";  break;
	case 2:  $mes_completo = "Fev";  break;
	case 3:  $mes_completo = "Mar";  break;
	case 4:  $mes_completo = "Abr";  break;
	case 5:  $mes_completo = "Mai";  break;
	case 6:  $mes_completo = "Jun";  break;
	case 7:  $mes_completo = "Jul";  break;
	case 8:  $mes_completo = "Ago";  break;
	case 9:  $mes_completo = "Set";  break;
	case 10: $mes_completo = "Out";  break;
	case 11: $mes_completo = "Nov";  break;
	case 12: $mes_completo = "Dez";  break;
}
?>

<style>
#time-left {
    position: fixed;
    z-index: 0;
    top: 50%;
    left: 1em;
    padding: 6px 12px;
    background: #ccc;
    border-bottom: 0;
    border-radius: 50px;
    color: #fff;
    font-size: 13px;
    font-family: PT Sans Narrow;
}
</style>

<div id="time-left"></div>

<section class="title-int">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="title-int-text">
					<h1>
						Novidades
						<i class="fas fa-angle-right"></i>
						<span> <?php echo $dados_all['titulo']; ?>
							<span style="color:#bca153; font-weight: 800; padding-left: 20px; top: 0px;" class="date-mobile"><i class="fa fa-calendar-o"></i> <?php echo $dia; ?> <?php echo $mes_completo; ?> '<?php echo $ano; ?></span>
						</span>
					</h1>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="colors" style="background: transparent;">
	<div class="container">
		<div class="row">
			<div class="cor1"></div>
			<div class="cor2"></div>
			<div class="cor3"></div>
		</div>
	</div>
</section>

<div class="claerfix"></div>

<section class="int midia midia-cont">

	<div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin tira-padding-right" uk-grid style="margin-top: -6px;">
		<div class="uk-card-media-left uk-cover-container">
			<div class="uk-inline-clip uk-transition-toggle" tabindex="0">

				<?php if ($dados_all['img'] == NULL) { ?>
				<img class="uk-transition-scale-up uk-transition-opaque" src="./cms/timthumb.php?src=./assets/img/avatar_3.png&w=700&h=401"/>
				<?php } else { ?>

				<img class="uk-transition-scale-up uk-transition-opaque" src="./cms/timthumb.php?src=./cms/assets/uploads/_NOTICIAS/<?php echo $dados_all['img']; ?>&w=700&h=401"/>
				<?php } ?>

			</div>
		</div>
		<div>
			<div class="uk-card-body">
				<div class="padding-total">
					<h3 class="uk-card-title"><?php echo $dados_all['titulo']; ?></h3>
					<div class="date-footer">
						<ul class="grid">
							<li class="grid__item">
								<div class="col-sm-4">
									<button class="icobutton icobutton--heart" id="botao" name="botao"><span class="fa fa-heart"></span>
										<span class="icobutton__text icobutton__text--side" id="resposta">
											<?php
                                                $soma_likes = mysql_query("SELECT  *,sum(like_s) as total_likes
                                                    FROM _noticias_like
                                                    WHERE slug = '".$dados_all['slug']."' ");

                                                $dados_soma_geral = mysql_fetch_array($soma_likes);
                                                $total += $dados_soma_geral['total_likes'];
                                                echo $total;
                                                ?>
										</span>
										<span class="likes">gostaram</span></button>
								</div>

								<div class="col-sm-4">
									<a href="javascript:void();">
										<p><i class="fas fa-eye fa-2x"></i> <?php echo $dados_all['views']; ?> visualizações</p>
									</a>
								</div>

								<div class="col-sm-4">
									<a href="#modal-share" uk-toggle>
										<p><i class="fas fa-share-alt fa-2x"></i>  Compartilhar</p>
									</a>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container" id="text-read">
		<div class="row">
			<div class="col-sm-12 text-justify">
				<p><?php echo $dados_all['texto']; ?></p>
			</div>

			<?php if ($dados_all['video'] == 'S') { ?>
			<div class="col-sm-12">
				<iframe width="100%" height="550" frameborder="0" src="https://www.youtube.com/embed/<?php echo $dados_all['embed_video']; ?>" allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
			<?php } else {} ?>

			<div class="col-sm-12">
				<div class="uk-grid-collapse uk-child-width-1-4@s uk-margin" uk-grid uk-lightbox="animation: scale">

					<?php
			        $sql_3 = "SELECT * FROM _noticias as ga INNER JOIN _noticias_galeria
			        as gi ON ga.id = gi.id_galeria_album
			        WHERE ga.ativo = 'S' AND ga.slug = '$slug' ORDER BY gi.id DESC";
			        $bd->consulta($sql_3);
			        $bd->first();
			        $row = $bd->getRows();

			        for($i=1; $i<=$row; $i++){
			        $dados_pic = $bd->getDados();
			        ?>
					<div class="uk-inline-clip uk-transition-toggle" tabindex="0">
						<a class="uk-inline" href="<?php echo $dados_pic['caminho']; ?>" data-caption="<?php echo $dados_all['titulo']; ?>">
							<img src="<?php echo $dados_pic['caminho']; ?>" class='uk-transition-scale-up uk-transition-opaque' />
							<div class="uk-transition-fade uk-position-cover uk-position-small uk-overlay uk-overlay-default uk-flex uk-flex-center uk-flex-middle">
								<span class="uk-transition-fade" uk-icon="icon: plus; ratio: 2"></span>
							</div>
						</a>
					</div>
					<?php $bd->next(); } ?>
				</div>
			</div>
		</div>
	</div>
</section>

<div id="modal-share" class="uk-flex-top" uk-modal>
	<div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

		<button class="uk-modal-close-default" type="button" uk-close></button>

		<h1>Compartilhe com seus amigos e familiares</h1>
		<p>Clique na rede social desejada para compartilhar</p>
		<hr>
		<div id="shareIcons" class="jssocials" style="font-size: 18px;"></div>

	</div>
</div>

<input type="hidden" name="slug" id="slug" value="<?php echo $dados_all['slug']; ?>">
<input type="hidden" name="ip" id="ip" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">

<?php include "inc/footer.php"; ?>

<script>
	$('#botao').click(function(){
		$.ajax({
			type      : 'post',
			url       : './like.php',
			data      : {slug:$('#slug').val(), ip:$('#ip').val()},
			dataType  : 'html',
			success : function(txt){
				$('#resposta').html(txt);
			}
		});
	}).ajaxStart(function(){
		$('#loading').toggle();
	}).ajaxStop(function(){
		$('#loading').toggle();
	})


	//
	//
	//
	$('#text-read').readingTimeLeft()
	.on('timechange', function(e, minutesLeft) {
		var text = minutesLeft < 1 ? '1' : Math.round(minutesLeft);
		$('#time-left').html('<i class="fa fa-hourglass-half"></i> ' + text + 'min restante');
	})
	$(window).trigger('scroll');

</script>