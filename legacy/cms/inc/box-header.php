<header>
    <nav class="navbar-r3 navbar navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="painel"><img src="assets/img/logo.png" alt=""></a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="menu-user">Olá <?php echo $_SESSION['nome']; ?></li>
                    <li class="" uk-toggle="target: #offcanvas-reveal"><a href="javascript:void();"><span class="fa fa-bell"></span></a></li>
                    <div id="offcanvas-reveal" uk-offcanvas="mode: reveal; overlay: true">
                        <div class="uk-offcanvas-bar">
                            <h3>Notificações</h3>
                            <p>Nenhuma notificação no momento.</p>
                            <button class="uk-button uk-button-default uk-offcanvas-close uk-width-1-1 uk-margin" type="button">Fechar</button>
                        </div>
                    </div>
                    <li class=""><a href="javscript:void();"><span class="fa fa-cogs"></span></a></li>
                    <div uk-dropdown="mode: click">
                        <ul class="uk-nav uk-dropdown-nav">
                            <li class="uk-active"><a href="modulos/configuracoes/index.php?id=<?php echo $dados_config['id'];?>"><span uk-icon="icon: cog"></span> Configurações</a></li>
                            <li class="uk-nav-divider"></li>
                            <li class="uk-active"><a href="logout"><span uk-icon="icon: sign-out"></span> Sair</a></li>
                        </ul>
                    </div>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
</header>

<div class="pageheader">
    <div class="container">
        <h4 class="uk-heading-bullet"><?php echo $dados_config['site']; ?></h4>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-3 col-md-3 col-lg-3 col-xs-12">
            <div class="panel panel-dark" uk-sticky="offset: 100;">
                <div class="panel-heading">
                    <div class="panel-btns pull-right">
                        <a href="javascript:void();" class="minimize">−</a>
                    </div><!-- panel-btns -->
                    Menu
                </div>
                <div class="panel-body">
                    <?php include 'menu.php'; ?>
            </div>
        </div>
    </div>

    <div class="col-sm-9 col-md-9 col-lg-9 col-xs-12">