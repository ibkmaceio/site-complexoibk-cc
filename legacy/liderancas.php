<?php include "inc/header.php"; ?>

<?php

$sql = "SELECT * FROM _lideranca_intro WHERE ativo = 'S' order by id ASC";
$bd->consulta($sql);
$bd->first();
$row = $bd->getRows();

for ($i = 1; $i <= $row; $i++) {
$dados = $bd->getDados();

?>

<section class="title-int">
	<div class="container" style="padding-bottom: 0;">
		<div class="row">
			<div class="col-sm-12">
				<div class="title-int-text">
					<h1>Líderanças <i class="fas fa-angle-right"></i> <span>Conheça a IBK</span></h1>
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

<?php } ?>

<div class="clearfix"></div>

<!-- LIDERANÇAS -->
<section class="lideres">
	<div class="col-sm-12" style="display:flex; flex-wrap:wrap; justify-content:center; align-items:flex-start;">

		<?php
		$sql_time = "SELECT * FROM _lideranca WHERE ativo = 'S' ORDER BY id ASC";
		$bd->consulta($sql_time);
		$bd->first();
		$row = $bd->getRows();

		for($i=1; $i<=$row; $i++){
		$dados_time = $bd->getDados();
		?>

		<div class="cardContainer inactive">
			<div class="card">
				<div class="side front">
					<?php
					$img_ext = strtolower(pathinfo($dados_time['img'], PATHINFO_EXTENSION));
					if ($dados_time['img'] == NULL || $img_ext === 'png') {
					?>
						<div class="img" style="background-image: url(./assets/img/avatar_2.png);"></div>
					<?php } else { ?>
						<div class="img" style="background-image: url(./cms/assets/uploads/_LIDERANCA/<?php echo $dados_time['img']; ?>);"></div>
					<?php } ?>
					<div class="info">
						<h2><?php echo $dados_time['nome']; ?></h2>
						<p>
						<?php
							echo $dados_time['titulo_categoria'];
							echo "<br>";

							$pontos = array(",", "<br>");
							echo $result = str_replace($pontos, "<br> ", $dados_time['ministerio']);

						?>
						</p>
					</div>
				</div>
				<div class="side back">
					<div class="info">
						<h2><?php echo $dados_time['nome']; ?></h2>
						<?php echo $dados_time['texto']; ?>
					</div>
				</div>
			</div>
		</div>
		<?php $bd->next(); } ?>
	</div>

	<div class="clearfix"></div>
</section>

<div class="clearfix"></div>

<?php include "inc/footer.php"; ?>