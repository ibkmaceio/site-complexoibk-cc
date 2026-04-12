<?php include($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php");

# VERIFICAÇÃO DO POST ENVIADO PARA INSERIR NO BD
if(@$_POST['action'] == 'cadastrar'){

    $sql = "INSERT INTO institucional (titulo,titulo_breve,texto1,texto2)
    VALUES
    (
        '".$_POST['titulo']."',
        '".$_POST['titulo_breve']."',
        '".$_POST['texto1']."',
        '".$_POST['texto2']."'
        )";

    if($bd->consulta($sql)){
        echo "<script type='text/javascript'>alert('Cadastro realizado com sucesso!'); window.location.href='javascript:history.go(-2)';</script>";
    }
    else{
        echo "<script type='text/javascript'>alert('Erro ao realizar cadastro!');</script>";
    }
    }

?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="row row-pad-5">
        <div class="col-lg-12">
            <input name="titulo" id="titulo" placeholder="Frase Principal" class="form-control" type="text">
        </div>

        <div class="col-lg-8">
            <input name="titulo_breve" id="titulo_breve" placeholder="Frase Complementar" class="form-control" type="text">
        </div>

    </div><!-- row -->

    <div class="row row-pad-5">
        <div class="col-lg-12">
            <textarea name="texto1" id="wysiwyg" rows="8" placeholder="Digite sobre a empresa..." class="form-control"></textarea>
        </div>
    </div>

    <div class="pull-right">
        <input type="hidden" name="action" value="cadastrar"><br />
        <button type="submit" class="btn btn-success btn-sm">Cadastrar</button>
        <a href="javascript:history.back(-1)" class="text-xs text-muted">Cancelar</a>
    </div>

</form>

<?php include($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>
