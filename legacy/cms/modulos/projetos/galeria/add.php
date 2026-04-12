<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



NOTICIAS > GALERIA



-->

<?php

$query2 = "SELECT * FROM _projetos WHERE id = '".$_GET['id']."'";
$bd->consulta($query2);
$bd->first();
$dados = $bd->getDados();

if($_POST['action'] == 'cadastrar'){

    $pasta = strtolower($dados['slug']);
    $pasta = trim($pasta);
    $pasta = str_replace(' ', '', $pasta);

    $dir = $_SERVER['DOCUMENT_ROOT']."/cms/assets/uploads/_PROJETOS/";
    $dir2 = "./cms/assets/uploads/_PROJETOS/";

    if(mkdir($dir.$pasta, 0777)){
        chmod($dir.$pasta, 0777);
        $local = $pasta;
    }else{
        $local = "arquivos_sem_pasta";
        $local = $pasta;
    }

    ini_set('post_max_size', '300M'); //tamanho por MB
    ini_set('upload_max_filesize', '300M'); //tamanho por MB
    ini_set('memory_limit', '300M'); //tamanho por MB
    ini_set('max_execution_time', '86400'); //tempo em segundos
    ini_set('max_input_time', '86400'); //tempo em segundos
    ini_set("memory_limit", -1 );
    ini_set("max_execution_time", -1 );

    $i = 0;

    foreach ($_FILES["imagem"]["error"] as $key => $error) {

        $imagem_nome = md5(uniqid(time())).".jpg";
        $imagem_dir = $dir.$local."/".$imagem_nome;
        $imagem_dir2 = $dir2.$local."/".$imagem_nome;
        move_uploaded_file($_FILES["imagem"]["tmp_name"][$i], $imagem_dir);
        list($width, $height) = getimagesize($imagem_dir) ;

        $sql_fotos = "INSERT INTO _projetos_categoria(
        id_galeria_album,
        slug_noticias,
        caminho,
        nome_arquivo
        ) VALUES(
        '".$_REQUEST['id']."',
        '".$dados['slug']."',
        '".substr($imagem_dir2,0)."',
        '".$imagem_nome."'
        ) ";
        $bd->consulta($sql_fotos);

        ++$i;
    }

    if(true){
        $acao2 = str_replace("'","\'", $query);
        $acao = str_replace("'","\'", $sql);
        $historico = "INSERT INTO _historico (usuario,data,ip,acao) VALUES ('".$_SESSION['nome']."','".$data."','".$_SERVER["REMOTE_ADDR"]."','".$acao." - ".$acao2."')";

        $bd->consulta($historico);
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


<h3 class="uk-heading-line"><span>Inserir Galeria</span></h3>

<div class="uk-background-muted uk-padding">
    <p>Você pode inserir 1 ou mais imagens de uma unica vez</p>

    <form class="uk-form-stacked" action="" method="post" enctype="multipart/form-data">
        <div class="test-upload uk-placeholder uk-text-center">
            <span uk-icon="icon: cloud-upload; ratio: 2"></span>
            <span class="uk-text-middle"> Arraste suas imagem para este box ou</span>
            <div uk-form-custom>
                <input type="file" name="imagem[]" id="imagem" accept="image/jpeg" onBlur="initMultiple()" multiple>
                <span class="uk-link">clique aqui</span> para enviar
            </div>
            <span class="nome_file"></span>
        </div>

        <progress id="progressbar" class="uk-progress" value="0" max="100" hidden></progress>


        <div class="row">
            <div class="col-sm-12 text-right">
                <input type="hidden" name="action" value="cadastrar"><br />
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>"><br />
                <a href="javascript:history.back(-1)" class="uk-button uk-button-text uk-text-capitalize">Cancelar</a>
                <button class="uk-button uk-label-success">Cadastrar</button>
            </div>
        </div>
    </form>
</div>

<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>