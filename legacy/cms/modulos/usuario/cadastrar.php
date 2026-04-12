<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



USUARIOS



-->


<?php

if ($_POST['action'] == 'cadastrar') {

    $sql = "INSERT INTO _usuarios_cms (
    nome,
    email,
    senha,
    contra_senha,
    permissao
) VALUES
(
    '".$_POST['nome']."',
    '".$_POST['email']."',
    '".sha1($_POST['senha'])."',
    '".$_POST['senha']."',
    '".$_POST['permissao']."'
    )";

    if ($bd->consulta($sql)) {
        $data      = date('d/m/Y');
        $acao      = str_replace("'", "\'", $sql);
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

<h3 class="uk-heading-line"><span>Cadastrar</span></h3>

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
                        <input class="uk-input uk-form-width-large" name="nome" type="text" placeholder="Digite um texto ...">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="uk-margin">
                    <label class="uk-form-label" for="">Email</label>
                        <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: mail"></span>
                            <input class="uk-input uk-form-width-large email" name="email" type="text" placeholder="Digite um texto ..."">
                        </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="uk-margin">
                    <label class="uk-form-label" for="">Senha</label>
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: lock"></span>
                            <input class="uk-input senha" data-showpass="true" data-placement="bottom" name="senha" id="senha" type="password" placeholder="Digite um texto ..." autocomplete="new-password">
                        </div>
                </div>
            </div>


            <div class="col-sm-4">
                <div class="uk-margin">
                    <label for="">Permissão</label>

                    <select class="uk-select" name="permissao">
                        <option value="">Selecione</option>
                        <?php
                        $sql_perm = "SELECT * FROM _permissoes ORDER BY permissao ASC";
                        $bd->consulta($sql_perm);
                        $bd->first();
                        $rows = $bd->getRows();

                        for($i=1; $i<=$rows; $i++){
                        $dados_perm = $bd->getDados();
                        ?>
                        <option value="<?php echo $dados_perm['id']; ?>"><?php echo $dados_perm['permissao']; ?></option>
                        <?php $bd->next(); }?>
                    </select>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>

        <div class="row">
            <div class="col-sm-12 text-right">
                <input type="hidden" value="cadastrar" name="action">
                <a href="javascript:history.back(-1)" class="uk-button uk-button-text uk-text-capitalize">Cancelar</a>
                <button class="uk-button uk-label-success">Cadastrar</button>
            </div>
        </div>
    </form>
</div>

<?php include ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php");?>