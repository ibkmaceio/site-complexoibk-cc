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
            $imagem_dir  = $_SERVER['DOCUMENT_ROOT']."/cms/assets/uploads/_PORTFOLIO/" . $imagem_nome;
            move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
        }
        $imagem_nome = $imagem_nome;
    }else{
        $imagem_nome = $_POST["imagem_nome"];
    }

    $embed_video        = substr($_POST['link_video'],32,11);
    $url                = strip_tags($_POST['link_video']);
    $imagem_video       = "http://i1.ytimg.com/vi/".$embed_video."/default.jpg";
    $imagem_video_hd    = "http://i1.ytimg.com/vi/".$embed_video."/hqdefault.jpg";

    $sql = " UPDATE _noticias SET

    titulo                     = '".$_POST['titulo']."',
    breve_descricao            = '".$_POST['breve_descricao']."',
    texto                      = '".$_POST['texto']."',
    slug                       = '".$slug."',
    autor                      = '".$_POST['autor']."',
    fonte                      = '".$_POST['fonte']."',
    categoria_noticia          = '".$_POST['categoria_noticia']."',
    categoria_noticia_slug     = '".$categoria_noticia_slug."',
    legenda                    = '".$_POST['legenda']."',
    legenda_titulo             = '".$_POST['legenda_titulo']."',
    video                      = '".$_POST['video']."',
    link_video                 = '".$url."',
    imagem_video               = '".$imagem_video."',
    imagem_video_hd            = '".$imagem_video_hd."',
    embed_video                = '".$embed_video."',
    img                        = '".$imagem_nome."',
    destaque                   = '".$_POST['destaque']."',
    ativo                      = '".$_POST['ativo']."'
    WHERE id = '".$_POST['id']."'
    ";

    if ($dados['titulo'] == $_POST['titulo']) {
        $titulo = "titulo = '".($_POST['titulo'])."', ";
    }
    if ($dados['titulo'] != $_POST['titulo']) {

        $sql_edit_galeria = " UPDATE _noticias_galeria SET
            slug_noticias = '".$slug."'
            WHERE slug_noticias = '".$dados['slug']."'
            ";

            if ($bd->consulta($sql_edit_galeria)) {
                echo "";
            } else {
                echo "<script type='text/javascript'>alert('Erro ao atualizar tablea NOTICIAS > GALERIA');</script>";
            }
    }

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
                        <input class="uk-input uk-form-width-large" name="titulo" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['titulo']; ?>">
                    </div>
                </div>
            </div>


            <div class="col-sm-12">
                <div class="uk-margin">
                    <div class="uk-form-label">Breve Descrição</div>
                    <div class="uk-inline">
                        <div class="pull-right charNum"></div>
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="breve_descricao" id="breve_descricao" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['breve_descricao']; ?>">
                    </div>
                </div>
            </div>


            <div class="col-sm-12">
                <div class="uk-margin">
                    <div class="uk-form-label">Noticia</div>
                    <div class="uk-form-controls">
                        <textarea name="texto" class="uk-textarea" placeholder="Digite um texto ..." rows="5"><?php echo $dados['texto']; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="uk-margin">
                    <div class="uk-form-label">Fonte</div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="fonte" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['fonte']; ?>">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="uk-margin">
                    <div class="uk-form-label">Autor</div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="autor" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['autor']; ?>">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">Área</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="categoria_noticia">
                            <option value="<?php echo $dados['categoria_noticia']; ?>"><?php echo $dados['categoria_noticia']; ?></option>
                            <option value="<?php echo $dados['categoria_noticia']; ?>">-</option>
                            <?php
                            $sql = mysql_query("SELECT * FROM _noticias_categoria ORDER BY id ASC");
                            while ($dados_cat = mysql_fetch_array($sql)) {
                            ?>
                            <option value="<?php echo $dados_cat['titulo']; ?>"><?php echo $dados_cat['titulo']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <?php echo "<img src='./timthumb.php?src=./cms/assets/uploads/_PORTFOLIO/".$dados['img']."&h=175&w=220' class='thumbnail img-responsive' />";?>

                <div class="row">
                    <div class="col-sm-3">
                        <input type="hidden" name="imagem_nome" value="<?php echo $dados['img']; ?>" class="img-responsive img-thumbnail" />
                    </div>
                </div>

                <a href="javascript:void(0);" onClick="mostrar('sel_banner');"><span class="uk-label">Alterar Banner</span></a>

                <div class="uk-margin" id="sel_banner" style="display:none;">
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

            <div class="clearfix"></div>
            <hr>

            <div class="col-sm-3">
                <div class="uk-margin">
                <div class="uk-form-label">Colocar como Destaque?</div>
                    <div class="uk-form-controls">
                        <label><input class="uk-radio" type="radio" value="S" name="destaque" <?php if ($dados['destaque'] == 'S') echo "checked"; ?>> Sim</label>
                        <label><input class="uk-radio" type="radio" value="N" name="destaque" <?php if ($dados['destaque'] == 'N') echo "checked"; ?>> Não</label>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="uk-margin">
                <div class="uk-form-label">Usar legenda?</div>
                    <div class="uk-form-controls">
                        <label><input class="uk-radio" type="radio" value="S" name="legenda" onClick="mostrar('legenda');" <?php if ($dados['legenda'] == 'S') echo "checked"; ?>> Sim</label>
                        <label><input class="uk-radio" type="radio" value="N" name="legenda" onClick="ocultar('legenda');" <?php if ($dados['legenda'] == 'N') echo "checked"; ?>> Não</label>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="uk-margin">
                <div class="uk-form-label">Usar video?</div>
                    <div class="uk-form-controls">
                        <label><input class="uk-radio" type="radio" value="S" name="video" onClick="mostrar('video');" <?php if ($dados['video'] == 'S') echo "checked"; ?>> Sim</label>
                        <label><input class="uk-radio" type="radio" value="N" name="video" onClick="ocultar('video');" <?php if ($dados['video'] == 'N') echo "checked"; ?>> Não</label>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="uk-margin">
                    <div class="uk-form-label">Status</div>
                    <div class="uk-form-controls">
                        <label><input class="uk-radio" type="radio" value="S" name="ativo" <?php if ($dados['ativo'] == 'S') echo "checked"; ?>> Ativo</label>
                        <label><input class="uk-radio" type="radio" value="N" name="ativo" <?php if ($dados['ativo'] == 'N') echo "checked"; ?>> Inativo</label>
                    </div>
                </div>
            </div>

            <div class="col-sm-6" id="legenda" style="<?php if ($dados['legenda'] == 'S'){ echo "display:block;"; }else{ echo "display:none;"; } ?>">
                <div class="uk-margin">
                    <div class="uk-form-label">Legenda</div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="legenda_titulo" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['legenda_titulo']; ?>">
                    </div>
                </div>
            </div>


            <div class="col-sm-6" id="video" style="<?php if ($dados['video'] == 'S'){ echo "display:block;"; }else{ echo "display:none;"; } ?>">
                <div class="uk-margin">
                    <div class="uk-form-label">URL do Video</div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="link_video" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['link_video']; ?>">
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