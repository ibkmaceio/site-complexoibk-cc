<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



VIDEOS



-->


<?php

$titulo = mysql_real_escape_string(trim($_POST['titulo']));
$slug = _retirar_acentuacao(strtolower($titulo));

$categoria_video = mysql_real_escape_string(trim($_POST['categoria_video']));
$categoria_video_slug = _retirar_acentuacao(strtolower($categoria_video));

if($_POST['action'] == 'cadastrar'){

    $data 		= date('d/m/Y');
    $url		= strip_tags($_POST['link']);
    $embed 		= substr($_POST['link'],32,11);
    $imagem		= "http://i1.ytimg.com/vi/".$embed."/default.jpg";
    $imagem_hd  = "http://i1.ytimg.com/vi/".$embed."/maxresdefault.jpg";

    $sql = "INSERT INTO _videos (titulo,breve_descricao,slug,categoria_video,categoria_video_slug,link,embed,imagem,imagem_hd,destaque,ao_vivo)
    VALUES(
    '".$_POST['titulo']."',
    '".$_POST['breve_descricao']."',
    '".$slug."',
    '".$_POST['categoria_video']."',
    '".$categoria_video_slug."',
    '".$url."',
    '".$embed."',
    '".$imagem."',
    '".$imagem_hd."',
    '".$_POST['destaque']."',
    '".$_POST['ao_vivo']."'
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
    <form class="uk-form-stacked"  action="" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-9">
                <div class="uk-margin">
                <label class="uk-form-label" for="nome">Titulo do video</label>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="titulo" type="text" placeholder="Digite um texto ...">
                    </div>
                </div>
            </div>


            <div class="col-sm-6">
                <div class="uk-margin">
                    <label class="uk-form-label" for="breve_descricao">Breve descrição</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <input class="uk-input uk-form-width-large" name="breve_descricao" type="text" placeholder="Digite um texto ...">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="uk-margin">
                    <div class="uk-form-label">Link do Video</div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="link" type="text" placeholder="Digite um texto ...">
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-sm-4">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">Categoria</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="categoria_video">
                            <option value="Selecione aqui">Selecione aqui</option>
                            <?php
                            $sql = mysql_query("SELECT * FROM _videos_categoria ORDER BY id ASC");
                            while ($dados = mysql_fetch_array($sql)) {
                            ?>
                            <option value="<?php echo $dados['titulo']; ?>"><?php echo $dados['titulo']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

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
                <div class="uk-form-label">Transmitir AO VIVO?</div>
                <div class="uk-form-controls">
                    <label><input class="uk-radio" type="radio" value="S" name="ao_vivo"> Sim</label>
                    <label><input class="uk-radio" type="radio" value="N" name="ao_vivo" checked> Não</label>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <hr>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-sm-12 text-right">
                <input type="hidden" value="cadastrar" name="action">
                <a href="javascript:history.back(-1)" class="uk-button uk-button-text uk-text-capitalize">Cancelar</a>
                <button class="uk-button uk-label-success">Cadastrar</button>
            </div>
        </div>
    </form>
</div>

<?php include($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>
