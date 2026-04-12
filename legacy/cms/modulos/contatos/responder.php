<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



CONTATOS



-->

<?php

$sql = "SELECT * FROM _contatos WHERE id = '".$_REQUEST['id']."'";
$bd->consulta($sql);
$bd->first();
$dados = $bd->getDados();

if($_POST['botao'] == 'SIM'){

    $sql = "UPDATE _contatos SET status = 'Respondido' WHERE id = '".$dados['id']."'";
    if($bd->consulta($sql)){
        echo "
        <script type='text/javascript'>
            onload = function(){
                initAlertEd();
            }
        </script>";
    }else{
        echo "
        <script type='text/javascript'>
            onload = function(){
                initAlertError();
            }
        </script>";
    }
}

if($_POST['botao'] == 'NAO'){
    echo "<script language='javascript'>window.location.href='javascript:history.go(-2)';</script>";
}


?>


<h3 class="uk-heading-line"><span>Contatos</span></h3>

<a href="javascript:history.go(-1)" title="Voltar" class="uk-button uk-button-danger pull-right" uk-tooltip uk-icon="icon: chevron-left"></a>

<div class="clearfix"></div>

<div class="uk-background-muted uk-padding">
    <?php if($dados['status'] == "Respondido"){?>
    <div uk-alert class="uk-alert-success">
        <a class="uk-alert-close" uk-close></a>
        <h3>Contato Respondido</h3>
        <p>Este contato já foi sinalizado como respondido</p>
    </div>
    <?php } ?>
    <form action="" method="post">
        <div class="padding">
            <h2><?php echo $dados['nome'];?></h2>
            <b>Email</b> <?php echo $dados['email'];?> <b>Telefone</b> <?php echo $dados['telefone'];?>
            <hr>
            <b>Assunto</b><br>
            <?php echo $dados['assunto'];?>
            <hr>
            <b>Mensagem enviada</b><br>
            <?php echo $dados['texto'];?>
            <hr>
        </div>

        <div class="marginTop">
            <?php if($dados['status'] == "Pendente"){?>
            Este contato j&aacute; foi respondido?
            <div class="clearfix marginTop"></div>
            <button name="botao" value="SIM" class="uk-button uk-button-primary">Sim, respondido</button>
            <button name="botao" value="NAO" class="uk-button uk-button-danger">Nao</button>

            <?php }?>
        </div>
    </form>

</div>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>