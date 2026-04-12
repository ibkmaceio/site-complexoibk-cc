<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



INSTITUCIONAL



-->


<?php

$query2 = "SELECT * FROM _lideranca_intro WHERE id = '".$_REQUEST['id']."'";
$bd->consulta($query2);
$bd->first();
$dados = $bd->getDados();

if($_POST['action'] == 'editar'){


    $sql = " UPDATE _lideranca_intro SET
    titulo              = '".$_POST['titulo']."',
    titulo_breve        = '".$_POST['titulo_breve']."',
    ativo               = 'S'
    WHERE id = '".$_POST['id']."'
    ";

    if ($bd->consulta($sql)) {
        echo "
        <script type='text/javascript'>
            onload = function(){
                initAlertEd();
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

<h3 class="uk-heading-line"><span>Editar</span></h3>

<div uk-alert class="uk-alert-danger" id="message_alert" style="display:none;">
    <a class="uk-alert-close" uk-close></a>
    <h3>Ocorreu um erro no cadastro!</h3>
</div>

<div class="uk-overflow-auto uk-background-muted uk-padding">
    <form class="uk-form-stacked" action="" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-12">
                <div class="uk-margin">
                    <label class="uk-form-label" for="nome">Titulo</label>
                    <div class="uk-form-controls">
                        <textarea name="titulo" class="uk-textarea" placeholder="Digite um texto ..." rows="2"><?php echo $dados['titulo']; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="uk-margin">
                    <label class="uk-form-label" for="titulo_breve">Breve descrição</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <div class="pull-right charNum"></div>
                            <input class="uk-input uk-form-width-large" name="titulo_breve" id="breve_descricao" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['titulo_breve']; ?>">
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
                <input type="hidden" name="action" value="editar">
                <a href="javascript:history.back(-1)" class="uk-button uk-button-text uk-text-capitalize">Cancelar</a>
                <button class="uk-button uk-label-success">Atualizar</button>
            </div>
        </div>

    </form>
</div>

<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>