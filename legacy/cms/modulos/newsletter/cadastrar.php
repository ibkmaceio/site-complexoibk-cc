<?php include($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php");

if(@$_POST['action'] == 'cadastrar'){

    $data = date('d/m/Y H:i:s');

    $sql = "INSERT INTO newsletter (firstname,email,data)
    VALUES
    (
        '".$_POST['firstname']."',
        '".$_POST['email']."',
        CURRENT_TIMESTAMP
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
        <div class="col-lg-6">
            <label for="">Name</label>
            <input name="firstname" id="firstname" placeholder="Insert Name" class="form-control" type="text">
        </div>

        <div class="col-lg-6">
            <label for="">E-mail</label>
            <input name="email" id="email" placeholder="Insert E-mail" class="form-control" type="email">
        </div>

    </div><!-- row -->

    <hr>

    <div class="pull-right">
        <input type="hidden" name="action" value="cadastrar"><br />
        <button type="submit" class="btn btn-success btn-sm">Insert</button>
        <a href="javascript:history.back(-1)" class="text-xs text-muted">Cancel</a>
    </div>

</form>

<?php include($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>
