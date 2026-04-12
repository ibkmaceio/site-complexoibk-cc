<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



INSTITUCIONAL



-->


<?php

$query2 = "SELECT * FROM _institucional WHERE id = '".$_REQUEST['id']."'";
$bd->consulta($query2);
$bd->first();
$dados = $bd->getDados();

if($_POST['action'] == 'editar'){

    $embed_video        = substr($_POST['link_video'],32,11);
    $url                = strip_tags($_POST['link_video']);
    $imagem_video       = "http://i1.ytimg.com/vi/".$embed_video."/default.jpg";
    $imagem_video_hd    = "http://i1.ytimg.com/vi/".$embed_video."/hqdefault.jpg";

    $sql = " UPDATE _institucional SET
    titulo              = '".$_POST['titulo']."',
    titulo_breve        = '".$_POST['titulo_breve']."',
    valores             = '".$_POST['valores']."',
    visao               = '".$_POST['visao']."',
    o_que_cremos        = '".$_POST['o_que_cremos']."',
    video               = '".$_POST['video']."',
    link_video          = '".$url."',
    imagem_video        = '".$imagem_video."',
    imagem_video_hd     = '".$imagem_video_hd."',
    embed_video         = '".$embed_video."',
    ativo               = 'S'
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
            <div class="col-sm-12">
                <div class="uk-margin">
                    <label class="uk-form-label" for="nome">Titulo</label>
                    <div class="uk-form-controls">
                        <textarea name="titulo" class="uk-textarea" placeholder="Digite um texto ..." rows="2"><?php echo $dados['titulo']; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="uk-margin">
                    <label class="uk-form-label" for="titulo_breve">Breve descrição</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <div class="pull-right charNum"></div>
                            <input class="uk-input uk-form-width-large" name="titulo_breve" id="breve_descricao" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['titulo_breve']; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="uk-margin">
                    <div class="uk-form-label">Valores</div>
                    <div class="uk-form-controls">
                        <textarea name="valores" class="uk-textarea" placeholder="Digite um texto ..." rows="5"><?php echo $dados['valores']; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="uk-margin">
                    <div class="uk-form-label">Visão</div>
                    <div class="uk-form-controls">
                        <textarea name="visao" class="uk-textarea" placeholder="Digite um texto ..." rows="5"><?php echo $dados['visao']; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="uk-margin">
                    <div class="uk-form-label">O que cremos</div>
                    <div class="uk-form-controls">
                        <textarea name="o_que_cremos" class="uk-textarea" placeholder="Digite um texto ..." rows="5"><?php echo $dados['o_que_cremos']; ?></textarea>
                    </div>
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

        <div class="col-sm-6" id="video" style="<?php if ($dados['video'] == 'S'){ echo "display:block;"; }else{ echo "display:none;"; } ?>">
            <div class="uk-margin">
                <div class="uk-form-label">URL do Video</div>
                <div class="uk-inline">
                    <span class="uk-form-icon" uk-icon="icon: arrow-right"></span>
                    <input class="uk-input uk-form-width-large" name="link_video" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['link_video']; ?>">
                </div>
            </div>
        </div>

        <!-- <div class="row">

            <div class="col-sm-12">
                <?php echo "<img src='./timthumb.php?src=./cms/assets/uploads/_INSTITUCIONAL/".$dados['img']."&h=175&w=220' class='thumbnail img-responsive' />";?>

                <div class="row">
                    <div class="col-sm-3">
                        <input type="hidden" name="imagem_nome" value="<?php echo $dados['img']; ?>" class="img-responsive img-thumbnail" />
                    </div>
                </div>

                <a href="javascript:void(0);" onClick="mostrar('sel_banner');"><span class="uk-label">Alterar Banner</span></a>

                <div class="uk-margin" id="sel_banner" style="display:none;">
                    <div class="uk-form-label">Imagem</div>
                    <div class="test-upload row col-sm-12" uk-form-custom>
                        <input type="file" name="banner" id="banner" onBlur="initUp()">
                        <button class="uk-button uk-button-default" type="button" tabindex="-1">Selecione uma imagem</button>
                        <span class="nome_file"></span>
                    </div>
                    <div class="row col-sm-12">
                        <progress id="progressbar" class="uk-progress" min="0" max="100" hidden></progress>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="clearfix"></div>
        <hr>

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