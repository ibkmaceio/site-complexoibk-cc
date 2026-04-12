<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



CATEGORIAS



-->

<?php


$query2 = "SELECT * FROM _ministerios_categoria WHERE id = '".$_REQUEST['id']."'";
$bd->consulta($query2);
$bd->first();
$dados = $bd->getDados();

$titulo = mysql_real_escape_string(trim($_POST['titulo']));
$slug = _retirar_acentuacao(strtolower($titulo));

if($_POST['action'] == 'editar'){

    $data = date('d/m/Y');

    $sql = " UPDATE _ministerios_categoria SET

    titulo       = '".$_POST['titulo']."',
    slug         = '".$slug."'
    WHERE id = '".$_POST['id']."'
    ";

    if($bd->consulta($sql)){
        $acao = str_replace("'","\'", $sql);
        $historico = "INSERT INTO _historico (usuario,data,ip,acao) VALUES ('".$_SESSION['nome']."','".$data."','".$_SERVER["REMOTE_ADDR"]."','".$acao."')";

        $bd->consulta($historico);
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

<h3 class="uk-heading-line"><span>Editar</span></h3>

<div uk-alert class="uk-alert-danger" id="message_alert" style="display:none;">
    <a class="uk-alert-close" uk-close></a>
    <h3>Ocorreu um erro no cadastro!</h3>
</div>

<div class="uk-background-muted uk-padding">

    <form class="uk-form-stacked" id="form" action="" method="post" enctype="multipart/form-data" autocomplete="off">

        <div class="row">
            <div class="col-sm-6">
                <div class="uk-margin">
                <label class="uk-form-label" for="">Nome da Categoria</label>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="titulo" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['titulo']; ?>">
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

<?php include ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php");?>