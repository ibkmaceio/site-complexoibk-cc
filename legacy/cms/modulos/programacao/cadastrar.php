<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!--



PROGRAMCAO



-->


<?php

if($_POST['action'] == 'cadastrar'){

    $sql = "INSERT INTO _programacao(
    titulo,
    titulo_breve,
    data
    )
    VALUES
    (
    '".$_POST['titulo']."',
    '".$_POST['titulo_breve']."',
    '".$_POST['data']."'
    )";

    if($bd->consulta($sql)){
        echo "
        <script type='text/javascript'>
            onload = function(){
                initAlertCad();
            }
        </script>";
    } else {
        echo "
        <script type='text/javascript'>
            onload = function(){
                initAlertError();
            }
        </script>";
    }
}
?>

<h3 class="uk-heading-line"><span>Cadastrar</span></h3>

<div uk-alert class="uk-alert-danger" id="message_alert" style="display:none;">
    <a class="uk-alert-close" uk-close></a>
    <h3>Ocorreu um erro no cadastro!</h3>
</div>

<div class="uk-overflow-auto uk-background-muted uk-padding">
    <form class="uk-form-stacked" action="" method="post" enctype="multipart/form-data">
        <form class="uk-form-stacked">

            <div class="row">
                <div class="col-sm-6">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="titulo">Titulo</label>
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: list"></span>
                            <input class="uk-input uk-form-width-large" name="titulo" type="text" placeholder="Digite um texto ...">
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="titulo_breve">Breve descrição</label>
                        <div class="uk-form-controls">
                            <div class="uk-inline">
                                <input class="uk-input uk-form-width-large" name="titulo_breve" type="text" placeholder="Digite um texto ..."">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="data">Data da Programação</label>
                        <div class="uk-form-controls">
                            <div class="uk-inline">
                                <span class="uk-form-icon" uk-icon="icon: calendar"></span>
                                <input class="uk-input uk-form-width-large" name="data" id="data" type="text" placeholder="Digite um texto ...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <hr>

            <div class="row">
                <div class="col-sm-12 text-right">
                    <input type="hidden" name="id" value="<?php echo $dados['id'];?>">
                    <input type="hidden" name="action" value="cadastrar">
                    <a href="javascript:history.back(-1)" class="uk-button uk-button-text uk-text-capitalize">Cancelar</a>
                    <button class="uk-button uk-label-success">Atualizar</button>
                </div>
            </div>
        </form>
    </form>
</div>

<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $("#data").datepicker({
        dateFormat: 'd M, y',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
        nextText: 'Próximo',
        prevText: 'Anterior'
    });
</script>