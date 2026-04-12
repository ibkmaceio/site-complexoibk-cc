<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



INSTITUCIONAL > TIME



-->


<?php

$query2 = "SELECT * FROM _leitura WHERE id = '".$_REQUEST['id']."'";
$bd->consulta($query2);
$bd->first();
$dados = $bd->getDados();

if($_POST['action'] == 'editar'){

    // UPLOAD
    if($_FILES["banner"]["name"] != ""){
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
        $imagem_nome = $imagem_nome;
    }else{
        $imagem_nome = $_POST["imagem_nome"];
    }

    $sql = " UPDATE _leitura SET
    titulo              = '".$_POST['titulo']."',
    autor               = '".$_POST['autor']."',
    link                = '".$_POST['link']."',
    img                 = '".$imagem_nome."',
    ativo               = '".$_POST['ativo']."'
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
            <div class="col-sm-6">
                <div class="uk-margin">
                    <label class="uk-form-label" for="titulo">Titulo</label>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: list"></span>
                        <input class="uk-input uk-form-width-large" name="titulo" type="text" placeholder="Digite um titulo ..." value="<?php echo $dados['titulo']; ?>">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="uk-margin">
                    <label class="uk-form-label" for="autor">Autor</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: user"></span>
                            <input class="uk-input uk-form-width-large" name="autor" type="text" placeholder="Digite um autor ..." value="<?php echo $dados['autor']; ?>">
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-6">
                <div class="uk-margin">
                    <label class="uk-form-label" for="link">Link</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: link"></span>
                            <input class="uk-input uk-form-width-large" name="link" type="text" placeholder="Digite um link ..." value="<?php echo $dados['link']; ?>">
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-sm-12">
                <?php echo "<img src='./timthumb.php?src=./cms/assets/uploads/_LEITURA/".$dados['img']."&h=175&w=220' class='thumbnail img-responsive' />";?>

                <div class="row">
                    <div class="col-sm-3">
                        <input type="hidden" name="imagem_nome" value="<?php echo $dados['img']; ?>" class="img-responsive img-thumbnail" />
                    </div>
                </div>

                <a href="javascript:void(0);" onClick="mostrar('sel_banner');"><span class="uk-label">Alterar Banner</span></a>

                <div class="uk-margin" id="sel_banner" style="display:none;">
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
            </div>

            <div class="col-sm-12">
                <div class="uk-margin">
                <div class="uk-form-label">Status</div>
                    <div class="uk-form-controls">
                        <label><input class="uk-radio" type="radio" value="S" name="ativo" <?php if ($dados['ativo'] == 'S') echo "checked"; ?>> Ativo</label>
                        <label><input class="uk-radio" type="radio" value="N" name="ativo" <?php if ($dados['ativo'] == 'N') echo "checked"; ?>> Inativo</label>
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

<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>