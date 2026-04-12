<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



VIDEOS



-->


<?php

$sql_all = "SELECT * FROM _videos  WHERE id = '$_REQUEST[id]'";
$bd->consulta($sql_all);
$bd->first();
$row = $bd->getRows();
for($i=1; $i<=$row; $i++){
$dados = $bd->getDados();

$titulo = mysql_real_escape_string(trim($_POST['titulo']));
$slug = _retirar_acentuacao(strtolower($titulo));

$categoria_video = mysql_real_escape_string(trim($_POST['categoria_video']));
$categoria_video_slug = _retirar_acentuacao(strtolower($categoria_video));

if($_POST['action'] == 'editar'){

    $data     = date('d/m/Y');
    $url    = strip_tags($_POST['link']);
    $embed    = substr($_POST['link'],32,11);
    $imagem   = "http://i1.ytimg.com/vi/".$embed."/default.jpg";
    $imagem_hd  = "http://i1.ytimg.com/vi/".$embed."/maxresdefault.jpg";

    $sql = " UPDATE _videos SET
    titulo = '".$_POST['titulo']."',
    slug = '".$slug."',
    categoria_video = '".$categoria_video."',
    categoria_video_slug = '".$categoria_video_slug."',
    link = '".$url."',
    embed = '".$embed."',
    imagem = '".$imagem."',
    imagem_hd = '".$imagem_hd."',
    destaque = '".$_POST['destaque']."',
    ao_vivo = '".$_POST['ao_vivo']."',
    ativo = '".$_POST['ativo']."'
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
                        <input class="uk-input uk-form-width-large" name="titulo" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['titulo']; ?>">
                    </div>
                </div>
            </div>


            <div class="col-sm-6">
                <div class="uk-margin">
                    <label class="uk-form-label" for="breve_descricao">Breve descrição</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <input class="uk-input uk-form-width-large" name="breve_descricao" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['breve_descricao']; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="uk-margin">
                    <div class="uk-form-label">Link do Video</div>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                        <input class="uk-input uk-form-width-large" name="link" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['link']; ?>">
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="col-sm-4">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">Categoria</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="categoria_video">
                            <option value="<?php echo $dados['categoria_video']; ?>"><?php echo $dados['categoria_video']; ?></option>
                            <option value="<?php echo $dados['categoria_video']; ?>">-</option>
                            <?php
                            $sql_video_edit = mysql_query("SELECT * FROM _videos_categoria ORDER BY id ASC");
                            while ($dados_cat_video = mysql_fetch_array($sql_video_edit)) {
                            ?>
                            <option value="<?php echo $dados_cat_video['titulo']; ?>"><?php echo $dados_cat_video['titulo']; ?></option>
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
                    <label><input class="uk-radio" type="radio" value="S" name="destaque" <?php if ($dados['destaque'] == 'S') echo "checked"; ?>> Sim</label>
                    <label><input class="uk-radio" type="radio" value="N" name="destaque" <?php if ($dados['destaque'] == 'N') echo "checked"; ?>> Não</label>
                </div>
            </div>
        </div>


        <div class="col-sm-3">
            <div class="uk-margin">
            <div class="uk-form-label">Transmitir AO VIVO?</div>
                <div class="uk-form-controls">
                    <label><input class="uk-radio" type="radio" value="S" name="ao_vivo" <?php if ($dados['ao_vivo'] == 'S') echo "checked"; ?>> Sim</label>
                    <label><input class="uk-radio" type="radio" value="N" name="ao_vivo" <?php if ($dados['ao_vivo'] == 'N') echo "checked"; ?>> Não</label>
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

