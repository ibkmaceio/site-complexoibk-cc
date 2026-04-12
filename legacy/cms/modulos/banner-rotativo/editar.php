<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



DESTAQUES



-->


<?php

$sql = "SELECT * FROM _destaques WHERE id = '$_REQUEST[id]'";
$bd->consulta($sql);
$bd->first();
$row = $bd->getRows();
for($i=1; $i<=$row; $i++){
$dados = $bd->getDados();

$categoria_destaque = mysql_real_escape_string(trim($_POST['categoria_destaque']));
$categoria_destaque_slug = _retirar_acentuacao(strtolower($categoria_destaque));

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
            $imagem_dir  = $_SERVER['DOCUMENT_ROOT']."/cms/assets/uploads/_DESTAQUES/" . $imagem_nome;
            move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
        }
        $imagem_nome = $imagem_nome;
    }else{
        $imagem_nome = $_POST["imagem_nome"];
    }

    $data     = date('d/m/Y');
    $url    = strip_tags($_POST['link_video']);
    $embed    = substr($_POST['link_video'],32,11);
    $imagem   = "http://i1.ytimg.com/vi/".$embed."/default.jpg";
    $imagem_hd  = "http://i1.ytimg.com/vi/".$embed."/hqdefault.jpg";

    $sql = " UPDATE _destaques SET
    titulo                  = '".$_POST['titulo']."',
    breve_descricao         = '".$_POST['breve_descricao']."',
    categoria_destaque      = '".$categoria_destaque."',
    categoria_destaque_slug = '".$categoria_destaque_slug."',
    link_video              = '".$url."',
    embed                   = '".$embed."',
    imagem                  = '".$imagem."',
    imagem_hd               = '".$imagem_hd."',
    img                     = '".$imagem_nome."',
    link_imagem             = '".$_POST['link_imagem']."',
    link_externo            = '".$_POST['link_externo']."',
    tipo_destaque           = '".$_POST['tipo_destaque']."',
    imagem_full             = '".$_POST['imagem_full']."',
    ativo                   = '".$_POST['ativo']."'
    WHERE id = '".$_POST['id']."' ";

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

<h3 class="uk-heading-line"><span>Editar</span></h3>

<div uk-alert class="uk-alert-danger" id="message_alert" style="display:none;">
    <a class="uk-alert-close" uk-close></a>
    <h3>Ocorreu um erro no cadastro!</h3>
    <p><?php echo $error_all; ?></p>
</div>

<div class="uk-overflow-auto uk-background-muted uk-padding">
    <form class="uk-form-stacked"  action="" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-6">
                <div class="uk-margin">
                <label class="uk-form-label" for="nome">Titulo do Destaque</label>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="titulo" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['titulo']; ?>">
                    </div>
                </div>
            </div>


            <div class="col-sm-6">
                <div class="uk-margin">
                    <div class="uk-form-label">Breve Descrição</div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="breve_descricao" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['breve_descricao']; ?>">
                    </div>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">Categoria</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="categoria_destaque">
                            <option value="<?php echo $dados['categoria_destaque']; ?>"><?php echo $dados['categoria_destaque']; ?></option>
                            <option value="<?php echo $dados['categoria_destaque']; ?>">-</option>
                            <?php
                            $sql = mysql_query("SELECT * FROM _destaques_categoria ORDER BY id ASC");
                            while ($dados_cat = mysql_fetch_array($sql)) {
                            ?>
                            <option value="<?php echo $dados_cat['titulo']; ?>"><?php echo $dados_cat['titulo']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

        </div>

        <div class="row">
            <div class="col-sm-3">
                <div class="uk-margin">
                    <div class="uk-form-label">Status</div>
                    <div class="uk-form-controls">
                        <label><input class="uk-radio" type="radio" value="S" name="ativo" <?php if ($dados['ativo'] == 'S') echo "checked"; ?>> Ativo</label>
                        <label><input class="uk-radio" type="radio" value="N" name="ativo" <?php if ($dados['ativo'] == 'N') echo "checked"; ?>> Inativo</label>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="uk-margin">
                <div class="uk-form-label">Tipo de Destaque</div>
                    <div class="uk-form-controls">
                        <label>
                            <input class="uk-radio" type="radio" value="V" name="tipo_destaque" onClick="mostrar('video_destaque');ocultar('imagem_destaque');" <?php if ($dados['tipo_destaque'] == 'V') echo "checked"; ?>>
                            <span style="position: relative;top: 3px;"><i class="fa fa-video-camera"></i> Video</span>
                        </label>
                        <label>
                            <input class="uk-radio" type="radio" value="I" name="tipo_destaque" onClick="ocultar('video_destaque');mostrar('imagem_destaque');" <?php if ($dados['tipo_destaque'] == 'I') echo "checked"; ?>>
                            <span style="position: relative;top: 3px;"><i class="fa fa-picture-o"></i> Imagem</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-sm-6" id="video_destaque" style="<?php if ($dados['tipo_destaque'] == 'V'){ echo "display:block;"; }else{ echo "display:none;"; } ?>">
                <div class="uk-margin">
                    <div class="uk-form-label">URL do Video</div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="link_video" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['link_video']; ?>">
                    </div>
                </div>
            </div>

            <div class="col-sm-12" id="imagem_destaque" style="<?php if ($dados['tipo_destaque'] == 'I'){ echo "display:block;"; }else{ echo "display:none;"; } ?>">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="uk-margin">
                            <hr>
                            <div class="uk-form-label">Tipo de Imagem</div>
                            <div class="uk-form-controls">
                                <label>
                                    <input class="uk-radio" type="radio" value="S" name="imagem_full" <?php if ($dados['imagem_full'] == 'S') echo "checked"; ?>>
                                    <span style="position: relative;top: 3px;"><i class="fa fa-picture-o"></i> FULL</span>
                                </label>
                                <label>
                                    <input class="uk-radio" type="radio" value="N" name="imagem_full" <?php if ($dados['imagem_full'] == 'N') echo "checked"; ?>>
                                    <span style="position: relative;top: 3px;"><i class="fa fa-picture-o"></i> COMUM</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo "<img src='./timthumb.php?src=./cms/assets/uploads/_DESTAQUES/".$dados['img']."&h=175&w=220' class='thumbnail img-responsive' />";?>

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

                <div class="clearfix"></div>

                <div class="row" style="margin-top: 20px;">
                    <div class="col-sm-6">
                        <div class="uk-margin">
                            <div class="uk-form-label" for="descricao">Link da Imagem</div>
                            <div class="uk-inline">
                                <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                                <input class="uk-input uk-form-width-large" name="link_imagem" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['link_imagem'];?>">
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-3">
                        <div class="uk-margin">
                            <div class="uk-form-label">Abrir em nova aba?</div>
                            <div class="uk-form-controls">
                                <label>
                                    <input class="uk-radio" type="radio" value="S" name="link_externo" <?php if ($dados['link_externo'] == 'S') echo "checked"; ?>>
                                    <span style="position: relative;top: 3px;"><i class="fa fa-external-link"></i> Sim</span>
                                </label>
                                <label>
                                    <input class="uk-radio" type="radio" value="N" name="link_externo" <?php if ($dados['link_externo'] == 'N') echo "checked"; ?>>
                                    <span style="position: relative;top: 3px;"><i class="fa fa-link"></i> Não</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="clearfix"></div>
        <hr>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-sm-12 text-right">
                <input type="hidden" name="id" value="<?php echo $dados['id'];?>">
            <input type="hidden" name="action" value="editar"><br />
                <a href="javascript:history.back(-1)" class="uk-button uk-button-text uk-text-capitalize">Cancelar</a>
                <button class="uk-button uk-label-success">Atualizar</button>
            </div>
        </div>

    </form>

</div>

<?php } include($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>