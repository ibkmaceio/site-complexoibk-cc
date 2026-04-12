<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



NOTICIAS



-->


<?php

$query2 = "SELECT * FROM _noticias WHERE id = '".$_REQUEST['id']."'";
$bd->consulta($query2);
$bd->first();
$dados = $bd->getDados();

$titulo = mysql_real_escape_string(trim($_POST['titulo']));
$slug = _retirar_acentuacao(strtolower($titulo));

$categoria_noticia = mysql_real_escape_string(trim($_POST['categoria_noticia']));
$categoria_noticia_slug = _retirar_acentuacao(strtolower($categoria_noticia));

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
        $imagem_dir  = $_SERVER['DOCUMENT_ROOT']."/cms/assets/uploads/_PORTFOLIO/" . $imagem_nome;
        move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
    }

    $url       			= strip_tags($_POST['link_video']);
	$imagem_video     	= "http://i1.ytimg.com/vi/".$embed."/default.jpg";
	$imagem_video_hd	= "http://i1.ytimg.com/vi/".$embed."/hqdefault.jpg";
	$embed_video      	= substr($_POST['link_video'],32,11);

    $sql = "INSERT INTO _noticias(
    titulo,
    breve_descricao,
    texto,
    slug,
    autor,
    fonte,
    categoria_noticia,
    categoria_noticia_slug,
    legenda,
    legenda_titulo,
    video,
    link_video,
    imagem_video,
    imagem_video_hd,
    embed_video,
    img,
    destaque
    )
    VALUES
    (
    '".$_POST['titulo']."',
    '".$_POST['breve_descricao']."',
    '".$_POST['texto']."',
    '".$slug."',
    '".$_POST['autor']."',
    '".$_POST['fonte']."',
    '".$_POST['categoria_noticia']."',
    '".$categoria_noticia_slug."',
    '".$_POST['legenda']."',
    '".$_POST['legenda_titulo']."',
    '".$_POST['video']."',
    '".$url."',
    '".$imagem_video."',
    '".$imagem_video_hd."',
    '".$embed_video."',
    '".$imagem_nome."',
    '".$_POST['destaque']."'
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
                    <div class="uk-form-label">Noticia</div>
                    <div class="uk-form-controls">
                        <textarea name="texto" class="uk-textarea" placeholder="Digite um texto ..." rows="5"></textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="uk-margin">
                    <div class="uk-form-label">Fonte</div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="fonte" type="text" placeholder="Digite um texto ...">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="uk-margin">
                    <div class="uk-form-label">Autor</div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="autor" type="text" placeholder="Digite um texto ...">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
            	<div class="uk-margin">
            		<label class="uk-form-label" for="form-stacked-select">Área</label>
            		<div class="uk-form-controls">
            			<select class="uk-select" name="categoria_noticia">
            				<option value="Selecione aqui">Selecione aqui</option>
            				<?php
            				$sql = mysql_query("SELECT * FROM _noticias_categoria ORDER BY id ASC");
            				while ($dados = mysql_fetch_array($sql)) {
        					?>
        					<option value="<?php echo $dados['titulo']; ?>"><?php echo $dados['titulo']; ?></option>
        					<?php } ?>
        				</select>
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

            <div class="clearfix"></div>
            <hr>

             <div class="col-sm-3">
                <div class="uk-margin">
                <div class="uk-form-label">Colocar como Destaque?</div>
                    <div class="uk-form-controls">
                        <label><input class="uk-radio" type="radio" value="S" name="destaque"> Sim</label>
                        <label><input class="uk-radio" type="radio" value="N" name="destaque" checked> Não</label>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="uk-margin">
                <div class="uk-form-label">Usar legenda?</div>
                    <div class="uk-form-controls">
                        <label><input class="uk-radio" type="radio" value="S" name="legenda" onClick="mostrar('legenda');"> Sim</label>
                        <label><input class="uk-radio" type="radio" value="N" name="legenda" onClick="ocultar('legenda');" checked> Não</label>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
            	<div class="uk-margin">
            	<div class="uk-form-label">Usar video?</div>
            		<div class="uk-form-controls">
            			<label><input class="uk-radio" type="radio" value="S" name="video" onClick="mostrar('video');"> Sim</label>
            			<label><input class="uk-radio" type="radio" value="N" name="video" onClick="ocultar('video');" checked> Não</label>
            		</div>
            	</div>
            </div>

            <div class="col-sm-12" id="legenda" style="display: none;">
                <div class="uk-margin">
                    <div class="uk-form-label">Legenda</div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="legenda_titulo" type="text" placeholder="Digite um texto ...">
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