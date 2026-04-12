<?php include "inc/header.php"; ?>

<section class="title-int">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="title-int-text">
                    <h1>Nossa história <i class="fas fa-angle-right"></i> <span>Conheça a IBK</span></h1>
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
            <h1 class="uk-heading-line uk-text-center title"><span>Comunhão e Amor<br><b>desde sempre! </b></span></h1>
            <p>Conheça a história da nossa igreja!</p>
        </div>
    </div>
</section>


<!-- TIMELINE -->
<div class="agency-about-intro">
    <div class="timeline-wrapper">
        <div class="container">

            <?php

            $sql = "SELECT * FROM _trajetoria WHERE ativo = 'S' ORDER BY ano ASC";
            $bd->consulta($sql);
            $bd->first();
            $row = $bd->getRows();

            $ano_anterior = null;
            $entry_index  = 0;

            for ($i = 1; $i <= $row; $i++) {
            $dados_timeline = $bd->getDados();

            $ano_atual = $dados_timeline['ano'];
            $entry_index++;
            $classe = ($entry_index % 2 == 0) ? 'left' : '';

            if ($ano_atual !== $ano_anterior) { ?>
            <div class="clearfix"></div>
            <div class="year">
                <span><?php echo $ano_atual; ?></span>
            </div>
            <?php $ano_anterior = $ano_atual; } ?>

            <?php if ($dados_timeline['img'] == "") { ?>
            <div class="node <?php echo $classe; ?>">
                <div class="marker"></div>
                <div class="entry" style="background: linear-gradient(135deg, #bca153 0%, #896c4a 100%); display:flex; align-items:center; justify-content:center;">
                    <div class="intro" style="top:0; text-align:center; padding: 0 20px;">
                        <p style="font-size:18px; font-weight:600; line-height:1.5;"><?php echo $dados_timeline['titulo']; ?></p>
                    </div>
                </div>
            </div>

            <?php } else { ?>
            <div class="node <?php echo $classe; ?>">
                <div class="marker"></div>
                <div class="entry" style="background-image:url('cms/assets/uploads/_INSTITUCIONAL/<?php echo $dados_timeline['img']; ?>');">
                    <div class="intro">
                        <p><?php echo $dados_timeline['titulo']; ?></p>
                    </div>
                </div>
            </div>
            <?php } ?>

            <?php $bd->next(); } ?>

            <div class="clearfix"></div>
            <div class="year last">
                <span>&infin;</span>
            </div>
            <br><br><br>
        </div>
    </div>

</div>
<?php include("inc/footer.php"); ?>

<script type="text/javascript">
    $(function () {
        if (!window.utils.isMobile()) {
            $(window).scroll(function() {
                var scroll = $(window).scrollTop(),
                slowScroll = scroll/4,
                slowBg = 50 + slowScroll;

                $('.agency-about-hero').css("background-position", "center " + slowBg + "%");
            });

            utils.parallax_text($(".agency-about-hero .hero-text"), $(".hero-text").position().top);
        }
    });
</script>