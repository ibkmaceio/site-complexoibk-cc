<?php include "inc/header.php"; ?>

<section class="title-int">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<div class="title-int-text">
					<h1>Nossos Eventos <i class="fas fa-angle-right"></i> <span>Veja o que está rolando na IBK</span></h1>
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

<section class="apresentacao-interna cont titulo_arrow_2">
	<div class="container">
		<div class="row">
			<div class="col-sm-4 tira-padding-left tira-padding-right">
				<div id="calendario-ibk" class="col-sm-12" uk-sticky="offset: 100; bottom: #bootom_final_calendario">
					<div class="calendar tira-padding-right"></div>
				</div>
			</div>

			<div class="col-sm-8 tira-padding-right box-events">
				<div class="box"></div>
				<div class="uk-child-width-1-2@m" uk-grid>
					<?php

                    $data_atual = date("Y-m-d");
                    $sql_event = "SELECT * FROM _eventos WHERE ativo = 'S' ORDER BY data_evento ASC";
                    $bd->consulta($sql_event);
                    $bd->first();
                    $row = $bd->getRows();

                    for($i=1; $i<=$row; $i++){
                    $dados_events = $bd->getDados();

					?>
					<div>
                        <!-- <a href="#modal-full-<?php echo $dados_events['slug']; ?>" uk-toggle> -->
						<a href="eventos/<?php echo $dados_events['categoria_noticia_slug']; ?>/<?php echo $dados_events['slug']; ?>">
							<div class="uk-card uk-card-default">
								<div class="uk-card-media-top">
                                    <?php if ( $dados_events['img'] == NULL) { ?>
                                        <img src="./cms/timthumb.php?src=./assets/img/avatar_3.png&w=340&h=340&q=100"/>
                                    <?php } else { ?>
                                        <img src="./cms/timthumb.php?src=./cms/assets/uploads/_EVENTOS/<?php echo $dados_events['img']; ?>&w=340&h=340&q=100"/>
                                    <?php } ?>

								</div>
								<div class="uk-card-body">
									<div class="date"><i class="fa fa-calendar-o"></i>
                                        <?php echo $dados_events['data_evento']; ?>
                                    </div>
									<h3 class="uk-card-title"><?php echo $dados_events['titulo']; ?></h3>
									<p><?php echo $dados_events['titulo_breve']; ?></p>
								</div>
							</div>
						</a>



                        <!-- <div id="modal-full-<?php echo $dados_events['slug']; ?>" class="uk-modal-full modal-ministerio events" uk-modal>
                            <div class="uk-modal-dialog">
                                <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
                                <div class="uk-grid-collapse uk-child-width-1-2@s uk-flex-middle" uk-grid>


                                    <?php if ( $dados_events['img'] == NULL) { ?>
                                        <div class="uk-background-cover" style="background-image: url('./assets/img/avatar_3.png');" uk-height-viewport></div>
                                    <?php } else { ?>
                                        <div class="uk-background-cover" style="background-image: url('./cms/assets/uploads/_EVENTOS/<?php echo $dados_events['img']; ?>');" uk-height-viewport></div>
                                    <?php } ?>


                                    <div class="uk-padding-large">
                                        <div class="date"><i class="fa fa-calendar-o"></i> <?php echo $dados_events['data_evento']; ?></div>
                                        <h3><?php echo $dados_events['titulo']; ?></h3>
                                        <p><?php echo $dados_events['texto']; ?></p>

                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                        </div> -->


					</div>
                    <?php $bd->next(); } ?>
				</div>

				<div class="clearfix"></div>

			</div>
		</div>
	</div>

	<div id="bootom_final_calendario"></div>

</section>

<?php include "inc/footer.php"; ?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/prism.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/components/prism-javascript.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/components/prism-typescript.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/components/prism-json.min.js"></script>
<script type="text/javascript" src="https://twemoji.maxcdn.com/2/twemoji.min.js?2.5"></script>