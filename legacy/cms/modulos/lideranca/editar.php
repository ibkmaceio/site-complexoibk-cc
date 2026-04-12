<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



INSTITUCIONAL > TIME



-->


<?php

$query2 = "SELECT * FROM _lideranca WHERE id = '".$_REQUEST['id']."'";
$bd->consulta($query2);
$bd->first();
$dados = $bd->getDados();

// Tratamento SLUG
$nome = mysql_real_escape_string(trim($_POST['nome']));
$slug = _retirar_acentuacao(strtolower($nome));

// Tratamento SLUG
$titulo_categoria = mysql_real_escape_string(trim($_POST['titulo_categoria']));
$slug_categoria = _retirar_acentuacao(strtolower($titulo_categoria));

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
            $imagem_dir  = $_SERVER['DOCUMENT_ROOT']."/cms/assets/uploads/_LIDERANCA/" . $imagem_nome;
            move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
        }
        $imagem_nome = $imagem_nome;
    }else{
        $imagem_nome = $_POST["imagem_nome"];
    }

    for ($i=0; $i < sizeof($_POST['ministerio']); $i++) {
        $ministerio .= $_POST['ministerio'][$i].", ";
    }

    for ($i=0; $i < sizeof($_POST['ministerio']); $i++) {
        $ministerio_slug .= _retirar_acentuacao(strtolower($_POST['ministerio'][$i])).", ";
    }

    $sql = " UPDATE _lideranca SET
    nome                = '".$_POST['nome']."',
    slug                = '".$slug."',
    titulo_breve        = '".$_POST['titulo_breve']."',
    texto               = '".$_POST['texto']."',
    titulo_categoria    = '".$_POST['titulo_categoria']."',
    slug_categoria      = '".$slug_categoria."',
    ministerio          = '".$ministerio."',
    ministerio_slug     = '".$ministerio_slug."',
    facebook            = '".$_POST['facebook']."',
    twitter             = '".$_POST['twitter']."',
    instagram           = '".$_POST['instagram']."',
    youtube             = '".$_POST['youtube']."',
    linkedin            = '".$_POST['linkedin']."',
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
                    <label class="uk-form-label" for="nome">Nome</label>
                    <div class="uk-inline">
                        <span class="uk-form-icon" uk-icon="icon: user"></span>
                        <input class="uk-input uk-form-width-large" name="nome" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['nome']; ?>">
                    </div>
                </div>
            </div>

            <div class="col-sm-6">
                <div class="uk-margin">
                    <label class="uk-form-label" for="titulo_breve">Breve descrição</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <input class="uk-input uk-form-width-large" name="titulo_breve" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['titulo_breve']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="uk-margin">
                    <label class="uk-form-label" for="facebook">Facebook</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: facebook"></span>
                            <input class="uk-input uk-form-width-large" name="facebook" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['facebook']; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="uk-margin">
                    <label class="uk-form-label" for="twitter">Twitter</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: twitter"></span>
                            <input class="uk-input uk-form-width-large" name="twitter" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['twitter']; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="uk-margin">
                    <label class="uk-form-label" for="instagram">Instagram</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: instagram"></span>
                            <input class="uk-input uk-form-width-large" name="instagram" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['instagram']; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="uk-margin">
                    <label class="uk-form-label" for="youtube">Youtube</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: youtube"></span>
                            <input class="uk-input uk-form-width-large" name="youtube" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['youtube']; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="uk-margin">
                    <label class="uk-form-label" for="linkedin">Linkedin</label>
                    <div class="uk-form-controls">
                        <div class="uk-inline">
                            <span class="uk-form-icon" uk-icon="icon: linkedin"></span>
                            <input class="uk-input uk-form-width-large" name="linkedin" type="text" placeholder="Digite um texto ..." value="<?php echo $dados['linkedin']; ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-3">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">Cargo</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="titulo_categoria">
                            <option value="<?php echo $dados['titulo_categoria']; ?>"><?php echo $dados['titulo_categoria']; ?></option>
                            <option value="<?php echo $dados['titulo_categoria']; ?>">-</option>
                            <?php
                            $sql = mysql_query("SELECT * FROM _lideranca_categoria ORDER BY id ASC");
                            while ($dados_cat = mysql_fetch_array($sql)) {
                            ?>
                            <option value="<?php echo $dados_cat['titulo']; ?>"><?php echo $dados_cat['titulo']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">Lideres</label>
                    <div class="uk-form-controls">
                        <?php

                        $sqlTags = mysql_query(" SELECT * FROM _ministerios WHERE ativo = 'S' ");
                        $tag_ex = explode(", ",substr($dados['ministerio_slug'],0,-2));
                        while ($dadosTags = mysql_fetch_array($sqlTags)) {

                            foreach ($tag_ex as $key ) {
                                if($dadosTags['slug'] == $key){
                                    $cheked_tag = 'checked';
                                    break;
                                }else{
                                    $cheked_tag = '';
                                }
                            }
                        ?>
                        <div class="col-sm-6 row">
                            <input type="checkbox" id="<?php echo $dadosTags['titulo']; ?>" name="ministerio[]" value="<?php echo $dadosTags['titulo']; ?>" <?php echo $cheked_tag; ?>><label for="<?php echo $dadosTags['titulo']; ?>"><?php echo $dadosTags['titulo']; ?></label>
                        </div>
                        <?php } ?>

                    </div>
                </div>
            </div>

            <!-- <div class="col-sm-3">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">Ministério</label>
                    <div class="uk-form-controls">
                        <select class="uk-select" name="ministerio">
                            <option value="<?php echo $dados['ministerio']; ?>"><?php echo $dados['ministerio']; ?></option>
                            <option value="<?php echo $dados['ministerio']; ?>">-</option>
                            <?php
                            $sql_min = mysql_query("SELECT * FROM _ministerios_categoria ORDER BY id ASC");
                            while ($dados_cat_min = mysql_fetch_array($sql_min)) {
                            ?>
                            <option value="<?php echo $dados_cat_min['titulo']; ?>"><?php echo $dados_cat_min['titulo']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div> -->


            <div class="col-sm-12">
                <div class="uk-margin">
                    <div class="uk-form-label">Descrição</div>
                    <div class="uk-form-controls">
                        <textarea name="texto" class="uk-textarea" placeholder="Digite um texto ..." rows="5"><?php echo $dados['texto']; ?></textarea>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <?php echo "<img src='./timthumb.php?src=./cms/assets/uploads/_LIDERANCA/".$dados['img']."&h=175&w=220' class='thumbnail img-responsive' />";?>

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