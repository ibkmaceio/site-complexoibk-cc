<?php require './inc/header.php'; ?>
<?php require './inc/box-header.php'; ?>

<!-- Cards > Cliente -->

<div class="uk-card uk-card-default uk-card-body uk-width-1-1@m">
    <a href="modulos/configuracoes/index.php?id=<?php echo $dados_config['id'];?>">
        <div class="uk-card-badge uk-label uk-label-success"><i class="fa fa-pencil"></i></div>
    </a>
    <h3 class="uk-card-title"><?php echo $dados_config['empresa']; ?></h3>
    <p><?php echo $dados_config['endereco']; ?>, <?php echo $dados_config['numero']; ?> - <?php echo $dados_config['cidade']; ?>/<?php echo $dados_config['estado']; ?></p>
    <p><?php echo $dados_config['telefone']; ?> - <i class="fa fa-envelope"></i> <?php echo $dados_config['email']; ?></p>
</div>

<!-- Cards -->

<!-- Metricas > Google Analitycs -->

<h3 class="uk-heading-line"><span>Métricas</span></h3>
<div class="row">
    <div class="col-sm-8">
        <div class="panel panel-success">
            <div class="panel-heading padding5">
                <div id="line-chart-PAINEL" style="width:100%;height: 302px;"></div>
            </div>
            <div class="panel-body">
                <div class="text-muted text-xs">*Dados atualizados juntamente com o Google Analytics</div>
            </div>
        </div><!-- panel -->
    </div><!-- col-sm-12 -->


    <div class="col-md-4">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-btns">
                    <a href="#" class="minimize">−</a>
                </div><!-- panel-btns -->
                <h3 class="panel-title">Navegadores</h3>
            </div>
            <div class="panel-body">
                <div id="donut-chart2" style="height: 300px;"></div>
            </div>
        </div>
    </div>
</div>

<?php require './inc/footer.php'; ?>

<script>
//  DASBOARD > CHART
new Morris.Line({

    element: 'line-chart-PAINEL',
    data: [{
        y: '2006',
        a: 50,
        b: 0
    }, {
        y: '2007',
        a: 60,
        b: 25
    }, {
        y: '2008',
        a: 45,
        b: 30
    }, {
        y: '2009',
        a: 40,
        b: 20
    }, {
        y: '2010',
        a: 50,
        b: 35
    }, {
        y: '2011',
        a: 60,
        b: 50
    }, {
        y: '2012',
        a: 65,
        b: 55
    }],
    xkey: 'y',
    ykeys: ['a', 'b'],
    labels: ['Series A', 'Series B'],
    gridTextColor: 'rgba(255,255,255,0.5)',
    lineColors: ['#fff', '#fdd2a4'],
    lineWidth: '2px',
    hideHover: 'always',
    smooth: true,
    grid: true
});

//  DASBOARD > CHART > DONUT
new Morris.Donut({
    element: 'donut-chart2',
    data: [{
        label: "Chrome",
        value: 30
    }, {
        label: "Firefox",
        value: 20
    }, {
        label: "Opera",
        value: 20
    }, {
        label: "Safari",
        value: 20
    }, {
        label: "Internet Explorer",
        value: 10
    }],
    colors: ['#D9534F', '#1CAF9A', '#428BCA', '#5BC0DE', '#428BCA']
});
</script>