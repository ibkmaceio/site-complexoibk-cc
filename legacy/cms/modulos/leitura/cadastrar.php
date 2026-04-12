<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



LEITURA



-->


<?php


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
        $imagem_dir  = $_SERVER['DOCUMENT_ROOT']."/cms/assets/uploads/_LEITURA/" . $imagem_nome;
        move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
    }

    $sql = "INSERT INTO _leitura(
    titulo,
    autor,
    link,
    img
    )
    VALUES
    (
    '".$_POST['titulo']."',
    '".$_POST['autor']."',
    '".$_POST['link']."',
    '".$imagem_nome."'
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
                            <input class="uk-input uk-form-width-large" name="titulo" type="text" placeholder="Digite um titulo ...">
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="autor">Autor</label>
                        <div class="uk-form-controls">
                            <div class="uk-inline">
                                <span class="uk-form-icon" uk-icon="icon: user"></span>
                                <input class="uk-input uk-form-width-large" name="autor" type="text" placeholder="Digite um autor ..."">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-6">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="link">Link do Livro</label>
                        <div class="uk-form-controls">
                            <div class="uk-inline">
                                <span class="uk-form-icon" uk-icon="icon: link"></span>
                                <input class="uk-input uk-form-width-large" name="link" type="text" placeholder="Digite um link ...">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-sm-12">
                    <div class="uk-form-label">Imagem</div>
                    <div class="test-upload row col-sm-12" uk-form-custom>
                        <input type="file" name="banner" id="banner" accept="image/*" onBlur="initUp()">
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">Selecione uma imagem</button>
                        <span class="nome_file"></span>
                    </div>
                    <div class="row col-sm-12">
                        <progress id="progressbar" class="uk-progress" min="0" max="100" hidden></progress>
                    </div>
                </div>

                <div class="col-sm-12">
                    <input type="hidden" value="cadastrar" name="action">
                    <button class="pull-right uk-button uk-button-success">Ok <i class="fa fa-chevron-right"></i></button>
                </div>

            </div>
        </form>
    </form>

</div>


<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>