	<footer>
        <div class="container">
            <div class="cor1"></div>
            <div class="cor2"></div>
            <div class="cor3"></div>
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mobile-info-footer">
                    <a href="#"><img src="assets/img/logo-footer.png" alt="<?php echo $dados_H_Footer['empresa']; ?>"></a>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 mobile-info-footer">
                    <h5><?php echo $dados_H_Footer['cidade']; ?></h5>
                    <p><?php echo $dados_H_Footer['endereco']; ?>, <?php echo $dados_H_Footer['numero']; ?> <br>
                    <?php echo $dados_H_Footer['complemento']; ?>, <?php echo $dados_H_Footer['cidade']; ?>/<?php echo $dados_H_Footer['estado']; ?> <br>
                    CEP: <?php echo $dados_H_Footer['cep']; ?></p>

                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 mobile-info-footer">
                    <h5>Comunicação IBK</h5>
                    <p><i class="fas fa-envelope-open-text"></i> <?php echo $dados_H_Footer['email']; ?></p>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 mobile-info-reverse">
                    <h5 class="mobile-none">&nbsp;</h5>
                    <p><i class="fa fa-phone"></i> <?php echo $dados_H_Footer['telefone']; ?></p>
                </div>
            </div>
        </div>
        <div class="rodape">
            <p>© <?php echo date("Y"); ?>. Todos os direitos reservados</p>
            <p style="font-weight: 800;"><?php echo $dados_H_Footer['empresa']; ?></p>
            <br>
            <a href="http://rota3.com.br" target="_blank" rel="noopener noreferrer"><img src="../assets/img/logo-rota.png" alt="Rota 3 Agência Full"></a>
        </div>
    </footer>

    <div class="clearfix"></div>

    <!-- NEwSLTTER -->
    <div id="offcanvas-push" uk-offcanvas="mode: push; flip: true; overlay: true" >
        <div class="uk-offcanvas-bar">

            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <h3>Receba novidades da nossa igreja diretamente no seu email</h3>

            <form action="" method="POST" id="form-val-newsletter">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" placeholder="Digite seu nome" name="nome">
                        </div>
                        <div class="clearfix"></div>
                        <label class="error" for="nome"></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fas fa-envelope-open-text"></i></span>
                            <input type="text" placeholder="Digite seu email" name="email">
                        </div>
                        <div class="clearfix"></div>
                        <label class="error" for="email"></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <input type="hidden" name="action" value="cadNewsletter">
                        <button style="margin-top: 0;" type="submit" class="prosseguir">Cadastrar <i class="fas fa-check-circle"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

    <script type="text/javascript" src="https://www.jqueryscript.net/demo/jQuery-Plugin-To-Display-Reading-Time-Of-A-Specific-Article-readingTimeLeft-js/lib/readingTimeLeft.js"></script>

    <!-- ICON HEART - COUNT -->
    <script type="text/javascript" src="assets/js/mo.min.js"></script>
    <script type="text/javascript" src="assets/js/icon-votar.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.js"></script>

    <script type="text/javascript" src="assets/js/uikit.min.js"></script>
    <script type="text/javascript" src="assets/js/uikit-icons.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/bower_components/bxSlider/dist/jquery.bxslider.js"></script>
    <script type="text/javascript" src="assets/bower_components/ekko-lightbox/dist/ekko-lightbox.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/accounting.js/0.3.2/accounting.min.js"></script>

    <script type="text/javascript" src="assets/js/pignose.calendar.full.min.js"></script>

    <!-- SHARE EVENTS -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.jssocials/1.4.0/jssocials.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-youtube-background/1.0.0/jquery.youtubebackground.min.js"></script>
    <script type="text/javascript" src="assets/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="assets/js/lightbox.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>


    <!-- CEP -->
    <script type="text/javascript" src="assets/js/cep.js"></script>

    <!-- CARD -->
    <script type="text/javascript" src="assets/js/card.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/prism.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/components/prism-javascript.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/components/prism-typescript.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.13.0/components/prism-json.min.js"></script>
    <script type="text/javascript" src="https://twemoji.maxcdn.com/2/twemoji.min.js?2.5"></script>


    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>

    <script type="text/javascript" src="assets/js/validacao.js"></script>
  </body>
</html>