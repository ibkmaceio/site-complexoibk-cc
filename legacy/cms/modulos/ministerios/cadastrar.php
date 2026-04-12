<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



NOTICIAS



-->


<?php

$query2 = "SELECT * FROM _ministerios WHERE id = '".$_REQUEST['id']."'";
$bd->consulta($query2);
$bd->first();
$dados = $bd->getDados();

$titulo = mysql_real_escape_string(trim($_POST['titulo']));
$slug = _retirar_acentuacao(strtolower($titulo));

$categoria_ministerio = mysql_real_escape_string(trim($_POST['categoria_ministerio']));
$categoria_ministerio_slug = _retirar_acentuacao(strtolower($categoria_ministerio));

$lideres = mysql_real_escape_string(trim($_POST['lideres']));
$lideres_slug = _retirar_acentuacao(strtolower($lideres));

if($_POST['action'] == 'cadastrar'){

    if ($_FILES["banner"] != null) {
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
            $imagem_dir  = $_SERVER['DOCUMENT_ROOT']."/cms/assets/uploads/_MINISTERIOS/" . $imagem_nome;
            move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
        }
    }







    if ($_FILES["banner_intro"] != null) {
        // UPLOAD
        $arquivo = isset($_FILES["banner_intro"]) ? $_FILES["banner_intro"] : FALSE;
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
            $imagem_nome_intro = md5(uniqid(time())) . "." . $ext[1];
            $imagem_dir  = $_SERVER['DOCUMENT_ROOT']."/cms/assets/uploads/_MINISTERIOS/" . $imagem_nome_intro;
            move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
        }
    }










    if ($_FILES["banner_equipe"] != null) {
        // UPLOAD
        $arquivo = isset($_FILES["banner_equipe"]) ? $_FILES["banner_equipe"] : FALSE;
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
            $imagem_nome_equipe = md5(uniqid(time())) . "." . $ext[1];
            $imagem_dir  = $_SERVER['DOCUMENT_ROOT']."/cms/assets/uploads/_MINISTERIOS/" . $imagem_nome_equipe;
            move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
        }
    }


    $url       			= strip_tags($_POST['link_video']);
	$imagem_video     	= "http://i1.ytimg.com/vi/".$embed."/default.jpg";
	$imagem_video_hd	= "http://i1.ytimg.com/vi/".$embed."/hqdefault.jpg";
	$embed_video      	= substr($_POST['link_video'],32,11);

    for ($i=0; $i < sizeof($_POST['lideres']); $i++) {
        $lideres .= $_POST['lideres'][$i].",";
    }

    for ($i=0; $i < sizeof($_POST['lideres']); $i++) {
        $lideres_slug .= $_POST['lideres'][$i].",";
    }

    $sql = "INSERT INTO _ministerios(
    titulo,
    breve_descricao,
    texto,
    slug,
    lideres,
    lideres_slug,
    categoria_ministerio,
    categoria_ministerio_slug,
    introducao_titulo,
    introducao_subtitulo,
    introducao_descricao,
    introducao_img,
    equipe_titulo,
    equipe_subtitulo,
    equipe_descricao,
    equipe_img,
    video,
    link_video,
    imagem_video,
    imagem_video_hd,
    embed_video,
    img
    )
    VALUES
    (
    '".$_POST['titulo']."',
    '".$_POST['breve_descricao']."',
    '".$_POST['texto']."',
    '".$slug."',
    '".$lideres."',
    '".$lideres_slug."',
    '".$_POST['categoria_ministerio']."',
    '".$categoria_ministerio_slug."',
    '".$_POST['introducao_titulo']."',
    '".$_POST['introducao_subtitulo']."',
    '".$_POST['introducao_descricao']."',
    '".$imagem_nome_intro."',
    '".$_POST['equipe_titulo']."',
    '".$_POST['equipe_subtitulo']."',
    '".$_POST['equipe_descricao']."',
    '".$imagem_nome_equipe."',
    '".$_POST['video']."',
    '".$url."',
    '".$imagem_video."',
    '".$imagem_video_hd."',
    '".$embed_video."',
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

    echo '<pre>';
    print_r($_POST);
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
                    <label class="uk-form-label" for="form-stacked-select">Página &bull; Ministério</label>
                    <div class="uk-form-controls">
                        <select name="categoria_ministerio" class="selectpicker" title="Escolha á página...">
                            <option value="Selecione aqui">Selecione aqui</option>
                            <?php
                            $sql = mysql_query("SELECT * FROM _ministerios_categoria ORDER BY id ASC");
                            while ($dados = mysql_fetch_array($sql)) {
                            ?>
                            <option value="<?php echo $dados['titulo']; ?>"><?php echo $dados['titulo']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- <div class="col-sm-3">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">Lideres</label>
                    <div class="uk-form-controls">
                        <select name="lideres[]" class="selectpicker" multiple title="Escolha os lideres...">
                            <option value="Selecione aqui">Selecione aqui</option>
                            <?php
                            $sql = mysql_query("SELECT * FROM _lideranca ORDER BY id ASC");
                            while ($dados = mysql_fetch_array($sql)) {
                            ?>
                            <option value="<?php echo $dados['nome']; ?>"><?php echo $dados['nome']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div> -->
        </div>


        <div class="row">
            <div class="col-sm-9">
                <div class="uk-margin">
                    <label class="uk-form-label" for="nome">Titulo</label>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="titulo" type="text" placeholder="Digite um texto ...">
                    </div>
                </div>
            </div>


            <div class="col-sm-12">
                <div class="uk-margin">
                    <div class="uk-form-label">Breve Descrição</div>
                    <div class="uk-inline">
                    	<div class="pull-right charNum"></div>
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="breve_descricao" id="breve_descricao" type="text" placeholder="Digite um texto ...">
                    </div>
                </div>
            </div>


            <div class="col-sm-12">
                <div class="uk-margin">
                    <div class="uk-form-label">Texto</div>
                    <div class="uk-form-controls">
                        <textarea name="texto" class="uk-textarea" placeholder="Digite um texto ..." rows="5"></textarea>
                    </div>
                </div>
            </div>


            <div class="col-sm-4">
                <div class="uk-margin">
                    <div class="uk-form-label">Usar video no <b>DESTAQUE</b> da página?</div>
                    <div class="uk-form-controls">
                        <label><input class="uk-radio" type="radio" value="S" name="video" onClick="mostrar('video');"> Sim</label>
                        <label><input class="uk-radio" type="radio" value="N" name="video" onClick="ocultar('video');" checked> Não</label>
                    </div>
                </div>
            </div>

            <div class="col-sm-12" id="video" style="display: none;">
                <div class="uk-margin">
                    <div class="uk-form-label">URL do Video</div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="link_video" type="text" placeholder="Digite um texto ...">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="uk-form-label">Imagem <b>DESTAQUE</b> da página</div>
                <div class="test-upload row col-sm-12" uk-form-custom>
                    <input type="file" name="banner" id="banner" accept="image/jpeg" onBlur="initUp()">
                    <button class="uk-button uk-button-default" type="button" tabindex="-1">Selecione uma imagem</button>
                    <span class="nome_file"></span>
                </div>
                <div class="row col-sm-12">
                    <progress id="progressbar" class="uk-progress" min="0" max="100" hidden></progress>
                </div>
            </div>

            <div class="clearfix"></div>
            <hr>

            <div class="col-sm-12">
                <h3>INTRODUÇÃO</h3>
            </div>

            <div class="col-sm-6">
                <div class="uk-margin">
                    <div class="uk-form-label">Titulo de <b>Introdução</b></div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="introducao_titulo" type="text" placeholder="Digite um texto ...">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="uk-margin">
                    <div class="uk-form-label">Subtitulo de <b>Introdução</b></div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="introducao_subtitulo" type="text" placeholder="Digite um texto ...">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="uk-margin">
                    <div class="uk-form-label">Descrição de <b>Introdução</b></div>
                    <div class="uk-form-controls">
                        <textarea name="introducao_descricao" class="uk-textarea" placeholder="Digite um texto ..." rows="5"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="uk-form-label">Imagem da <b>Introdução</b></div>
                <div class="test-upload row col-sm-12" uk-form-custom>
                    <input type="file" name="banner_intro" id="banner_intro" accept="image/jpeg" onBlur="initUp()">
                    <button class="uk-button uk-button-default" type="button" tabindex="-1">Selecione uma imagem</button>
                    <span class="nome_file"></span>
                </div>
                <div class="row col-sm-12">
                    <progress id="progressbar" class="uk-progress" min="0" max="100" hidden></progress>
                </div>
            </div>


            <div class="clearfix"></div>
            <hr>

            <div class="col-sm-12">
                <h3>EQUIPE</h3>
            </div>

            <div class="col-sm-6">
                <div class="uk-margin">
                    <div class="uk-form-label">Titulo de <b>Equipe</b></div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="equipe_titulo" type="text" placeholder="Digite um texto ...">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="uk-margin">
                    <div class="uk-form-label">Subtitulo de <b>Equipe</b></div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="equipe_subtitulo" type="text" placeholder="Digite um texto ...">
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="uk-margin">
                    <div class="uk-form-label">Descrição de <b>Equipe</b></div>
                    <div class="uk-form-controls">
                        <textarea name="equipe_descricao" class="uk-textarea" placeholder="Digite um texto ..." rows="5"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="uk-form-label">Imagem da <b>Equipe</b></div>
                <div class="test-upload row col-sm-12" uk-form-custom>
                    <input type="file" name="banner_equipe" id="banner_equipe" accept="image/jpeg" onBlur="initUp()">
                    <button class="uk-button uk-button-default" type="button" tabindex="-1">Selecione uma imagem</button>
                    <span class="nome_file"></span>
                </div>
                <div class="row col-sm-12">
                    <progress id="progressbar" class="uk-progress" min="0" max="100" hidden></progress>
                </div>
            </div>


            <div class="clearfix"></div>
            <hr>

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


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">

<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/i18n/defaults-*.min.js"></script>