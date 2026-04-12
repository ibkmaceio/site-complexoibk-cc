<?php include "inc/header.php"; ?>

<script type="text/javascript" src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>

<?php

include_once 'payment/PagSessionId.php';
$session_id = PagSeguroUtil::getSessionId();

$sql_intro = "SELECT * FROM _doacoes_intro WHERE ativo = 'S' order by id DESC";
$bd->consulta($sql_intro);
$bd->first();
$row = $bd->getRows();

for ($i = 1; $i <= $row; $i++) {
$dados_intro = $bd->getDados();

?>

<section class="title-int">
	<div class="container" style="padding-bottom: 0;">
		<div class="row">
			<div class="col-sm-12">
				<div class="title-int-text">
					<h1>Doação <i class="fas fa-angle-right"></i> <span>Conheça nossos projetos!</span></h1>
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
			<h1 class="uk-heading-line uk-text-center title"><span><?php echo $dados_intro['titulo']; ?></span></h1>
			<p><?php echo $dados_intro['titulo_breve']; ?></p>
		</div>
	</div>
</section>

<?php } ?>

<section class="projetos">
	<div class="container">
		<div class="row">

			<?php
			$sql_projetos = "SELECT * FROM _projetos WHERE ativo = 'S' ORDER BY data_criacao DESC";
			$bd->consulta($sql_projetos);
			$bd->first();
			$row = $bd->getRows();

			for($i=1; $i<=$row; $i++){
			$dados_projetos = $bd->getDados();
			?>
			<div class="col-sm-6">
				<a href="doacoes/projetos/<?php echo $dados_projetos['slug']; ?>">
					<div class="uk-card uk-card-default uk-grid-collapse uk-child-width-1-2@s uk-margin" style="max-height: none;" uk-grid>
						<div class="uk-card-media-left uk-cover-container">

							<?php if ($dados_projetos['img'] == NULL) { ?>
								<img src="./assets/img/avatar_3.png" uk-cover>
							<?php } else { ?>

								<img src="./cms/assets/uploads/_PROJETOS/<?php echo $dados_projetos['img']; ?>" uk-cover>
							<?php } ?>

						</div>
						<div>
							<div class="uk-card-body">
								<h3 class="uk-card-title"><?php echo $dados_projetos['titulo']; ?></h3>
								<p><?php echo $dados_projetos['breve_descricao']; ?></p>
							</div>
						</div>
					</div>
				</a>
			</div>
			<?php $bd->next(); } ?>
		</div>
	</div>
</section>


<div class="clearfix"></div>


<!-- LIDERANÇAS -->
<section class="lideres checkout" id="realizar">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">

				<h3>Escolha uma modalidade de doação</h3>
				<p class="text-center">Você pode escolher diversas formas para contrinuir com nossos projetos e com nossa igreja!</p>

				<div class="ul-modalidade">
					<ul class="uk-flex-center" uk-tab>
						<li class="uk-active" id="material"><a href="#"><i class="fas fa-chair"></i> Materiais em Geral</a></li>
						<li id="dinheiro"><a href="#"> <i class="fas fa-money-check-alt"></i> Em Dinheiro</a></li>
						<li id="cesta"><a href="#"><i class="fas fa-people-carry"></i> Cesta Básica</a></li>
					</ul>

					<ul class="uk-switcher uk-margin">
						<li>
							<form action="finalizar-doacao" class="pagamento" id="form-doacao" method="POST">
								<input type="hidden" name="modalidade" value="Materiais em Geral">


								<h3>Selecione o tipo de material</h3>
								<p style="margin-bottom: 10px;">Você pode selecionar mais de um item</p>

								<div class="inputGroup">
									<input id="option1" name="tipo[]" type="checkbox" value="Material de Limpeza"/>
									<label for="option1">Material de Limpeza</label>
								</div>

								<div class="inputGroup">
									<input id="option2" name="tipo[]" type="checkbox" value="Material de Higiene Pessoal"/>
									<label for="option2">Material de Higiene Pessoal</label>
								</div>

								<div class="inputGroup">
									<input id="option3" name="tipo[]" type="checkbox" value="Medicamentos"/>
									<label for="option3">Medicamentos</label>
								</div>

								<div class="inputGroup">
									<input id="option4" name="tipo[]" type="checkbox" value="Material de Construção"/>
									<label for="option4">Material de Construção</label>
								</div>

								<div class="inputGroup">
									<input id="option5" name="tipo[]" type="checkbox" value="Roupas"/>
									<label for="option5">Roupas</label>
								</div>

								<div class="inputGroup">
									<input id="option6" name="tipo[]" type="checkbox" value="Outros"/>
									<label for="option6">Outros</label>
								</div>

								<div class="clearfix"></div>
								<hr>

								<div style="width: 35%;" class="width-mobile-100">
									<h3>Como deseja fazer a entrega deste material?</h3>
								</div>
								<div class="inputGroup">
									<input id="entrega_buscar" name="forma_entrega" type="radio" value="Venham" />
									<label for="entrega_buscar">Venham buscar</label>
								</div>

								<div class="inputGroup">
									<input id="entrega_levar" name="forma_entrega" type="radio" value="Irei" />
									<label for="entrega_levar">Irei levar</label>
								</div>

								<div class="clearfix"></div>
								<hr>

								<div id="levar_doador_conteudo" style="display:none;">
									<h3>Igreja Batista Koinonia Maceió</h3>
									<p><i class="fas fa-map-marker-alt"></i> <?php echo $dados_H_Footer['endereco'] ?>, <?php echo $dados_H_Footer['numero'] ?> - <?php echo $dados_H_Footer['complemento'] ?>, <?php echo $dados_H_Footer['cidade'] ?> - <?php echo $dados_H_Footer['estado'] ?></p>
									<p><i class="fa fa-phone"></i> <?php echo $dados_H_Footer['telefone'] ?></p>

									<div id="map"></div>

									<br><br>
									<div class="clearfix"></div>
									<hr>
								</div>

								<div id="buscar_doador_conteudo" style="display:none;">
									<div style="width: 55%; margin-bottom: 30px;" class="width-mobile-100">
										<h3>Digite seus dados para continuar com a Doação</h3>
										<p>Preencha os dados corretamente para continuar com sua doação!</p>
									</div>

									<div class="modal__container" style="border-radius: 0px;">
										<div class="modal__content">
											<ul class="form-list">

												<?php include("checkout_doador.php"); ?>

												<div class="clearfix"></div>
											</ul>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-12 alinha-centro margin-auto">
											<input type="hidden" name="action" value="envia_doacao_secundaria">
											<button type="submit" class="prosseguir tira-padding-right">
												Finalizar minha doação <i class="fa fa-hand-pointer"></i>
											</button>
										</div>
									</div>
								</div>
							</form>
						</li>

						<!-- DINHEIRO -->
						<li>
							<div class="col-sm-4 pagamento">
								<h3>Informações</h3>
								<p>Após a doação ter sido APROVADA chegará no seu e-mail cadastrado,  um recibo e uma mensagem de agradecimento.</p>
							</div>

							<form action="payment/pagamento.php" class="pagamento" id="form-doacao-valor" method="POST" onsubmit="valida(event)">

								<input id="user_token" name="user_token" type="hidden"/>
								<input id="cred_token" name="cred_token" type="hidden"/>

								<input id="is_debito" name="debito" type="hidden"/>
								<input id="is_boleto" name="boleto" type="hidden"/>
								<input id="is_credito" name="credito" type="hidden"/>

								<input id="brand_name" name="brand_name" type="hidden"/>
								<input id="valor_parcela" name="valor_parcela" type="hidden"/>
								<input id="tax_val" name="tax_val" type="hidden" value="0,00" />
								<input type="hidden" name="pagamento" value="S">


								<input type="hidden" name="modalidade" value="Oferta Online">
								<input type="hidden" name="forma_entrega" id="forma_entrega" value="ND">

								<div class="col-sm-7 pull-right pagamento">
									<div class="row">
										<div class="col-sm-5 valor">
											<h3>Valor desejado</h3>
											<div class="input-group">
												<span class="input-group-addon"><i class="fas fa-hand-holding-usd"></i></span>
												<input type="text" name="valor_doacao" id="valor_doacao" class="money valor_doacao" placeholder="R$ 100,00"/>

												<input type="hidden" name="quantidade" value="1">
												<input type="hidden" name="bilhete" value="001">
												<input type="hidden" name="descricao" value="Oferta - IBK Maceió">
											</div>
										</div>

										<div class="col-sm-7 tira-padding-right">
											<span class="mobile-none"><br><br><br></span>
											<p>Escolha um valor de sua preferencia e clique em <b>'Prosseguir com a doação'</b></p>
										</div>
									</div>

									<div class="row">
										<div class="col-sm-12 alinha-centro margin-auto">
											<a class="prosseguir tira-padding-right" id="prosseguir-dados-comprador">
												Prosseguir com a doação <i class="fa fa-hand-pointer"></i>
											</a>
										</div>
									</div>

									<div class="clearfix"></div>
								</div>

								<div class="col-sm-12" id="dados-comprador-pagador" style="display: none; margin-top: 40px;">
									<div class="tira-padding col-xs-12 titulo-sessao">
										<h3>Digite seus dados</h3>
										<p>Preencha os campos para efetivar sua doação</p>
									</div>
									<div class="modal__container">
										<div class="modal__content">
											<ul class="form-list">

												<?php include("checkout_doador.php"); ?>

												<div class="clearfix"></div>
											</ul>
										</div>
									</div>

									<a class="prosseguir tira-padding-right" id="prosseguir-forma-pagamento" uk-toggle>Escolher forma de doação <i class="fa fa-hand-pointer"></i></a>

									<div class="clearfix"></div>

									<div id="dados-forma-pagamento" style="display: none; margin-top: 40px;">
										<div class="row col-xs-12 titulo-sessao" style="margin-bottom: 40px;">
											<h3>Escolha a forma de pagamento </h3>
											<p>Escolha uma forma de pagamento para efetivar sua doação </p>
										</div>

										<div class="clearfix"></div>

										<ul class="uk-child-width-expand" uk-tab>
											<li class="uk-active"><a href="#" class="types" id="cartaoCredito" data-type="credito">
												<i class="fas fa-credit-card"></i> Cartão de Crédito </a>
											</li>
											<li><a href="#" class="types" id="debito" data-type="debito">
												<i class="fas fa-arrows-alt-h"></i> Débito</a>
											</li>
											<li><a href="#" class="types" id="boleto" data-type="boleto">
												<i class="fas fa-barcode"></i> Boleto</a>
											</li>
										</ul>

										<ul class="uk-switcher uk-margin">

											<!-- CARTÃO DE CRÉDITO -->
											<li class="uk-active">
												<div class="modal__container">
													<div class="modal__content">
														<h2>Preencha os campos abaixo corretamente</h2>

														<ul class="form-list">
															<!-- <li class="form-list__row form-list__row--inline">
																<div>
																	<label>Nome Completo</label>
																	<input type="text" name="cartaoNome" id="cartaoNome" required="" placeholder="Digite o nome do titular do cartão" disabled/>
																</div>

																<div>
																	<label>Email</label>
																	<input type="text" name="cartaoEMAIL" id="cartaoEMAIL" required="" placeholder="Digite um email válido" disabled/>
																</div>
															</li>

															<li class="form-list__row form-list__row--inline">
																<div>
																	<label>CPF</label>
																	<input type="text" name="cartaoCPF" id="cartaoCPF" class="cpf" required="" placeholder="Digite o CPF do titular do cartão" disabled/>
																</div>

																<div>
																	<label>RG</label>
																	<input type="text" name="cartaoRG" id="cartaoRG" required="" placeholder="Digite o RG do titular do cartão" disabled/>
																</div>
															</li> -->

															<li class="form-list__row" id="creditcard-click-section">
																<label>Número do Cartão de Crédito</label>
																<div id="input--cc" class="creditcard-icon">
																	<input type="number" name="cartaoNUMERO" id="cartaoNUMERO" minlength="14" maxlength="16"/>
																</div>
															</li>

															<li class="form-list__row form-list__row--inline">
																<div>
																	<label>Vencimento</label>
																	<div class="form-list__input-inline">
																		<input type="text" name="cartaoVencimento" id="cartaoVencimento" placeholder="MM/AAAA" minlength="7" maxlength="7" />
																	</div>
																	<div style="clear: both !important;"></div>
																	<span style="text-align:left; margin-top:5px;display:block; color: red; font-size: 13px;">Formato exigido: MM/AAAA <br> (MÊS com 2 digitos e ANO com 4 digitos)</span>
																</div>

																<div style="flex:0.5;">
																	<label>CVV</label>
																	<input type="text" name="cartaoCodigo" id="cartaoCodigo" placeholder="123" minlength="3" maxlength="4" />
																</div>
															</li>
															<li id="n_parcelas" li class="form-list__row form-list__row--inline" style="display: none;">
																<div>
																	<label>Nº de Parcelas</label>
																	<select id="parcelas" style="width: 100%; border:1px solid #ccc; padding:10px;"></select>
																	<!-- class="selectpicker"  -->
																	<input type="hidden" id="tax_delivery" value="0.00">
																	<input type="hidden" name="parcelas" id="qtd_parcelas" value="1">
																</div>
															</li>
														</ul>
													</div> <!-- END: .modal__content -->
												</div> <!-- END: .modal__container -->

												<div id="card-validating" class="alert alert-info" style="display: none;">Validando seu cartão</div>
												<div id="card-invalid" class="alert alert-danger" style="display: none;">Preencha todos os campos</div>

												<button type="submit" id="btn-finish" disabled class="prosseguir">Finalizar minha compra <i class="fa fa-hand-pointer"></i></button>
											</li>





											<!-- DÉBITO AUTOMATICO -->
											<li>
												<div class="modal__container" style="margin-bottom: 0;">
													<div class="modal__content">
														<h2>Selecione o seu banco preferencial</h2>
														<p>Finalize sua compra escolhando o seu banco para pagamento preferencial.</p>

														<ul class="form-list">
															<li class="form-list__row form-list__row--inline" style="padding-right: 0 !important;">
																<select name="banco" id="banco" class="selectpicker" data-style="btn-primary">
																	<option value="-">Selecione um banco</option>
																	<option value="itau">Itaú</option>
																	<option value="bancodobrasil">Banco do Brasil</option>
																	<option value="banrisul">Banrisul</option>
																	<option value="hsbc">HSBC</option>
																	<option value="bradesco">Bradesco</option>
																</select>
															</li>
														</ul>
													</div>
												</div>

												<div class="clearfix"></div>

												<button style="margin-top: 0;" type="submit" id="prosseguir-forma-pagamento-final" class="prosseguir">Finalizar minha compra <i class="fa fa-hand-pointer"></i></button>
											</li>







											<!-- BOLETO -->
											<li>
												<div class="modal__container" style="margin-bottom: 0;">
													<div class="modal__content">
														<h2>Clique no link para gerar seu boleto!</h2>
														<p>Ao clicar no link, seu boleto será gerado com o valor da sua doação.</p>
													</div>
												</div>

												<div class="clearfix"></div>

												<div class="form-actions">
													<button style="margin-top: 0;" type="submit" id="prosseguir-forma-pagamento-final-boleto" class="prosseguir">Gerar meu boleto <i class="fas fa-barcode"></i></button>
												</div>
											</li>
										</ul>

										<div class="col-sm-12">
											<p class="pull-right"><img src="assets/img/processamento.png" alt=""></p>
										</div>
									</div>
								</div>
							</form>
						</li>

						<!-- CESTA BÁSICA -->
						<li>
							<div class="pagamento">
								<h3 class="text-center">Em Breve. Aguarde mais informações!</h3>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="clearfix"></div>
</section>

<div class="clearfix"></div>

<?php include "inc/footer.php"; ?>

<script>

	// Radio buttons entrega: toggle painéis
	$('input[name="forma_entrega"]').on('change', function() {
		var val = $(this).val();
		if (val === 'Venham') {
			$('#buscar_doador_conteudo').show();
			$('#levar_doador_conteudo').hide();
		} else {
			$('#levar_doador_conteudo').show();
			$('#buscar_doador_conteudo').hide();
		}
	});

	var brand_flag;
	var amount;

	var debito 				= $('#is_debito'),
		credito 			= $('#is_credito'),
		boleto 				= $('#is_boleto'),
		boleto_parcelado 	= $('#is_boleto_parcelado');

	var btn_finish = $('#btn-finish');
	var allowSubmit = false;

	debito.val(0);
	credito.val(1);
	boleto.val(0);
	boleto_parcelado.val(0);

	$(document).ready(function() {
		PagSeguroDirectPayment.setSessionId('<?php echo $session_id?>');

		var identificador = PagSeguroDirectPayment.getSenderHash();
		$("#user_token").val(identificador);

		$('#nome').on('keyup', function() {
			$('#cartaoNome').val($(this).val());
		});

		$('#email').on('keyup', function() {
			$('#cartaoEMAIL').val($(this).val());
		});

		$('#cpf').on('keyup', function() {
			$('#cartaoCPF').val($(this).val());
		});

		$('#rg').on('keyup', function() {
			$('#cartaoRG').val($(this).val());
		});

		$("#prosseguir-forma-pagamento-final").click(function() {
			$("#loaderSistema").css("display","block");
		});

		$("#prosseguir-forma-pagamento-final-boleto").click(function() {
			$("#loaderSistema").css("display","block");
		});

		$('#prosseguir-forma-pagamento').on('click', function(event) {
			var identificador = PagSeguroDirectPayment.getSenderHash();
			$("#user_token").val(identificador);
			// console.log($("#user_token").val());
		})

		$('#input--cc input').on('keyup', function(event) {
			brand_flag = null;

			var cardBin = $(this).val().substr(0,6);

			var min = $(this).val().toString().length >= 14;
			var max = $(this).val().toString().length <= 16;

			if (min && max) {
				PagSeguroDirectPayment.getBrand({
					cardBin: cardBin,
					success: function(response) {
						brand_flag = response.brand.name;
						$('#brand_name').val(brand_flag);

						$('#n_parcelas').show();
						setCombo();
						createCreditToken();
					},
					error: function(response) {
						$('#n_parcelas').hide();
					},
					complete: function(response) {}
				});
			} else {
				$('#n_parcelas').hide();
			}
		});

		$('#cartaoCodigo').on('keyup', function(event) {
			createCreditToken();
		});

		$('#cartaoVencimento').on('keyup', function(event) {
			createCreditToken();
		});

		$('#parcelas').on('change', function(event) {
			$('#qtd_parcelas').val($(this).val());

			PagSeguroDirectPayment.getInstallments({
				amount: amount,
				brand:  brand_flag,
				success: function(data){
					var valor = data.installments[brand_flag][$('#parcelas').val() - 1].installmentAmount;

					$('#valor_parcela').val(valor.toFixed(2));
					console.log($('#valor_parcela').val());
				},
				error: function(data) {},
				complete: function(complete) {}
			});
		});

		$('.types').on('click', function(event) {
			var type = $('#' + event.target.id).data('type');

			resetTypes();

			switch (type) {
				case 'credito':
					credito.val(1);
					break;
				case 'debito':
					debito.val(1);
					break;
				case 'boleto':
					boleto.val(1);
					break;
				case 'boleto_parcelado':
					boleto_parcelado.val(1);
					break;
			}

			console.log({
				debito: debito.val(),
				credito: credito.val(),
				boleto: boleto.val(),
				boleto_parcelado: boleto_parcelado.val(),
			});
		})
	})

	function resetTypes() {
		debito.val(0);
		credito.val(0);
		boleto.val(0);
		boleto_parcelado.val(0);
	}


	function setCombo(){
		amount = $("#valor_doacao").val().replace(',', '.');

		PagSeguroDirectPayment.getInstallments({
			amount: amount,
			maxInstallmentNoInterest: 1,
			brand: brand_flag,
			success: function(data){
				var combo = $('#parcelas');
				combo.empty();

				var index = 0;
				for (item of data.installments[brand_flag]) {
					if (index == 0) {
						$('#valor_parcela').val(item.installmentAmount.toFixed(2));
					}

					var output = '<option value = "'+ item.quantity +'">' + item.quantity + 'x de R$ ' + item.installmentAmount.toFixed(2) + '</option>';
					combo.append(output);

					index++;
				}
			},
			error: function(data) {},
			complete: function(data) {}
		});
	}

	function valida(event) {
		if (allowSubmit) {
			if(credito.val() == 1) {
				var amount = amount = $("#valor_doacao").val().replace(',', '.');
			}

		} else {
			// if (validarCPF(document.getElementById('cpf').value)) {
			// 	getClientData();

			// 	if (document.getElementById('cpf').indexOf(" ") <= 0)
			// 	{
			// 		return false;
			// 	}
			// } else {
			// 	alert('CPF Inválido');
			// 	document.getElementById('cpf').focus();
			// 	return false;
			// }
		}
	}

	function createCreditToken() {
		$('#card-invalid').hide();
		$('#card-validating').show();

		PagSeguroDirectPayment.createCardToken({
			cardNumber:$('#cartaoNUMERO').val(),
			brand: $('#brand_name').val(),
			cvv: $('#cartaoCodigo').val(),
			expirationMonth: $('#cartaoVencimento').val().split("/")[0],
			expirationYear: $('#cartaoVencimento').val().split("/")[1],

			success: function(data) {
				$('#cred_token').val(data.card.token);
				console.log($('#cred_token').val());

				btn_finish.prop('disabled', false);
				allowSubmit = true;

				// $("#btn-finish").click(function() {
				// 	$("#loaderSistema").css("display","block");
				// });

				// var action = $('#form-val-compra').attr('action');

				// $.ajax({
				// 	url: action,
				// 	type:'POST',
				// 	data: $('#form-val-compra').serialize(),
				// 	success: function(result){
				// 		console.log(result);
				// 		// var obj = jQuery.parseJSON(result);
				// 		console.log(result);

				// 		// if(obj.success){
				// 			location.href='https://www.ingressosrecife.com/finish.php';
				// 		// } else {
				// 		// 	document.getElementById('loaderSistema').style.display = 'none';
				// 		// 	alert(obj.message)
				// 		// }
				// 	},
				// 	error: function(error) {
				// 		console.log(error);
				// 	},
				// 	complete: function(complete) {
				// 		console.log(complete);
				// 	}
				// });
			},
			error: function(error) {
				btn_finish.prop('disabled', true);
				allowSubmit = false;

				$('#card-invalid').show();
			},
			complete: function(complete) {
				$('#card-validating').hide();
				$('#card-invalid').hide();
			}
		});
	}

	// $("#txtcomissario").blur(function () {
	// 	var txtcomissario = $(this).val();
	// 	$.ajax({
	// 		type: "GET",
	// 		url: "busca_comissario.php",
	// 		data: "txtcomissario="+txtcomissario,
	// 		success: function(comissario){
	// 			informacoesComissario = comissario.split("-");
	// 			$("#codcomissario").val(informacoesComissario[0]);
	// 		}
	// 	});
	// });

</script>

<script>
	// GOOGLE MAPS > DETALHAMNETO
	var map;

	function initialize() {

		<?php $latitude_longitude = "-9.6658, -35.7350"; ?>
		var latlng = new google.maps.LatLng(<?php echo $latitude_longitude; ?>);
		var options = {
			zoom: 16,
			mapTypeControl: false,
			panControl: false,
			zoomControl: true,
			scaleControl: true,
			streetViewControl: false,
			scrollwheel: false,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		map = new google.maps.Map(document.getElementById("map"), options);
		geocoder = new google.maps.Geocoder();
		marker = new google.maps.Marker({
			map: map,
			draggable: false,
		});

		marker.setPosition(latlng);

		var styles = [
		{
			stylers: [
			{ hue: "#333333" },
			{ saturation: -230 }
			]
		},{
			featureType: "road.arterial",
			elementType: "geometry",
			stylers: [
			{ lightness: 400 },
			{ visibility: "simplified" }
			]
		},{
			featureType: "road",
			elementType: "labels",
			stylers: [
			{ visibility: "on" }
			]
		}
		];

		map.setOptions({styles: styles});
	}
	initialize();
</script>