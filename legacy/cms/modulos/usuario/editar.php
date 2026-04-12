<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



USUARIOS



-->

<?php

$query2 = "SELECT * FROM _usuarios_cms WHERE id = '".$_REQUEST['id']."'";
$bd->consulta($query2);
$bd->first();
$dados = $bd->getDados();

if ($_POST['action'] == 'editar') {

    if($dados['senha'] == $_POST['senha']){
        $senha_update = "senha = '".($_POST['senha'])."', ";
        $contra_senha = "senha = '".($_POST['senha'])."', ";
    }
    if($dados['senha'] != $_POST['senha'] ){
        $senha_update = "senha = '".sha1($_POST['senha'])."', ";
        $contra_senha = "contra_senha = '".$_POST['senha']."', ";
    }

    $sql = " UPDATE _usuarios_cms SET
    nome = '".$_POST['nome']."',
    email = '".$_POST['email']."',
    ".$senha_update."
    ".$contra_senha."
    permissao = '".$_POST['permissao']."',
    ativo = '".$_POST['ativo']."'
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

<div class="uk-background-muted uk-padding">
    <form class="uk-form-stacked" id="form" action="" method="post" enctype="multipart/form-data" autocomplete="off">

        <div class="row">
            <div class="col-sm-6">
                <div class="uk-margin">
                <label class="uk-form-label" for="">Nome do Usuário</label>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: user"></span>
                        <input class="uk-input uk-form-width-large" name="nome" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['nome'] ?>">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="uk-margin">
                    <label class="uk-form-label" for="">Email</label>
                        <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: mail"></span>
                            <input class="uk-input uk-form-width-large email" name="email" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['email'] ?>">
                        </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="uk-margin">
                    <label class="uk-form-label" for="">Senha</label>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: lock"></span>
                        <input class="uk-input senha" data-showpass="true" data-placement="bottom" name="senha" id="senha" type="password" placeholder="Digite um texto ..." autocomplete="new-password" value="<?php echo $dados['contra_senha'] ?>">
                    </div>
                </div>
            </div>


            <div class="col-sm-4">
                <div class="uk-margin">
                    <label class="uk-form-label" for="">Permissão</label>
                    <select class="uk-select" name="permissao">
                        <option value="1" <?php if ($dados['permissao'] == 1) {echo "selected";}?>>Administrador</option>
                        <option value="2" <?php if ($dados['permissao'] == 2) {echo "selected";}?>>Usuario</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>

        <div class="row">
            <div class="col-lg-6">
                <label for="">Status do Usuário</label>
                <div class="clearfix"></div>
                <div class="col-sm-2" style="padding-left:0;">
                    <div class="rdio rdio-success">
                        <input type="radio" name="ativo" value="S" id="habilitar_usuario" <?php if ($dados['ativo'] == 'S') {echo "checked";}?>/>
                        <label for="habilitar_usuario">Ativo</label>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="rdio rdio-success">
                        <input type="radio" name="ativo" value="N" id="desabilitar_usuario" <?php if ($dados['ativo'] != 'S') {echo "checked";}?>/>
                        <label for="desabilitar_usuario">Inativo</label>
                    </div>
                </div>
            </div>
        </div>

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