<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



TRAJETORIA



-->


<?php

$query2 = "SELECT * FROM _trajetoria WHERE id = '".$_REQUEST['id']."'";
$bd->consulta($query2);
$bd->first();
$dados = $bd->getDados();

if($_POST['action'] == 'cadastrar'){

    // UPLOAD
    $arquivo = isset($_FILES["banner"]) ? $_FILES["banner"] : FALSE;
    $config["tamanho"] = 4000000;
    $config["largura"] = 4200;
    $config["altura"]  = 3200;

    if(!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"])){
        $erro[] = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg, bmp, gif ou png. Envie outro arquivo";
    }
    else {
        if($arquivo["size"] > $config["tamanho"]){
            $erro[] = "Arquivo em tamanho muito grande! A imagem deve ser de no máximo " . $config["tamanho"] . " bytes. Envie outro arquivo";
        }
        $tamanhos = getimagesize($arquivo["tmp_name"]);
        if($tamanhos[0] > $config["largura"]){
            $erro[] = "Largura da imagem não deve ultrapassar " . $config["largura"] . " pixels";
        }
        if($tamanhos[1] > $config["altura"]){
            $erro[] = "Altura da imagem não deve ultrapassar " . $config["altura"] . " pixels";
        }
    }
    if(sizeof($erro)){
        foreach($erro as $err){
            $error_all =  " - " . $err . "<br>";
        }
    }
    else {
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);
        $imagem_nome = md5(uniqid(time())) . "." . $ext[1];
        $imagem_dir  = $_SERVER['DOCUMENT_ROOT']."/cms/assets/uploads/_INSTITUCIONAL/" . $imagem_nome;
        move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
    }

    $sql = "INSERT INTO _trajetoria(
    ano,
    mes,
    titulo,
    img
    )
    VALUES
    (
    '".$_POST['ano']."',
    '".$_POST['mes']."',
    '".$_POST['titulo']."',
    '".$imagem_nome."'
    )";

    if ($bd->consulta($sql)) {
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
    <p><?php echo $error_all; ?></p>
</div>

<div class="uk-overflow-auto uk-background-muted uk-padding">
    <form class="uk-form-stacked" action="" method="post" enctype="multipart/form-data">
        <div class="row">

            <div class="col-sm-4">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">Mês</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="mes">
                            <option value="Selecione aqui">Selecione aqui</option>
                            <option value="Janeiro">Janeiro</option>
                            <option value="Fevereiro">Fevereiro</option>
                            <option value="Março">Março</option>
                            <option value="Abril">Abril</option>
                            <option value="Maio">Maio</option>
                            <option value="Junho">Junho</option>
                            <option value="Julho">Julho</option>
                            <option value="Agosto">Agosto</option>
                            <option value="Setembro">Setembro</option>
                            <option value="Outubro">Outubro</option>
                            <option value="Novembro">Novembro</option>
                            <option value="Dezembro">Dezembro</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-2">
                <div class="uk-margin">
                    <label class="uk-form-label" for="nome">Ano</label>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="ano" type="text" placeholder="2019">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="uk-margin">
                    <div class="uk-form-label">Titulo</div>
                    <div class="uk-form-controls">
                        <textarea name="titulo" class="uk-textarea" placeholder="Digite um texto ..." rows="5"></textarea>
                    </div>
                </div>
            </div>


            <div class="col-sm-12">
                <div class="uk-form-label">Imagem</div>
                <div class="test-upload row col-sm-12" uk-form-custom>
                    <input type="file" name="banner" id="banner" accept="image/jpeg" onBlur="initUp()">
                    <button class="uk-button uk-button-default" type="button" tabindex="-1">Selecione uma imagem</button>
                    <span class="nome_file"></span>
                </div>
                <div class="row col-sm-12">
                    <progress id="progressbar" class="uk-progress" min="0" max="100" hidden></progress>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 text-right">
                <input type="hidden" value="cadastrar" name="action">
                <a href="javascript:history.back(-1)" class="uk-button uk-button-text uk-text-capitalize">Cancelar</a>
                <button class="uk-button uk-label-success">Cadastrar</button>
            </div>
        </div>
    </form>
</div>


<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>