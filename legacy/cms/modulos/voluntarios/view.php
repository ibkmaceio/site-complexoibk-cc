<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/header.php"); ?>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/box-header.php"); ?>

<!--



CONTATOS



-->

<?php

$sql = "SELECT * FROM _voluntarios WHERE id = '".$_REQUEST['id']."'";
$bd->consulta($sql);
$bd->first();
$dados = $bd->getDados();

?>

<style>
    label.label-success {
        font-size: 12px;
        padding-top: 4px;
        font-weight: bold;
        text-transform: uppercase;
    }

    label.label-default {
        font-size: 12px;
        padding-top: 4px;
        border:1px solid #ccc;
        color: #999;
        background: #fff;
        font-weight: bold;
        text-transform: uppercase;
        margin-top: 10px;
    }

    a i { font-size: 35px !important; }
</style>

<h3 class="uk-heading-line"><span>Voluntário</span></h3>
<a href="javascript:history.go(-1)" title="Voltar" class="uk-button uk-button-danger pull-right" uk-tooltip uk-icon="icon: chevron-left"></a>

<div class="clearfix"></div>

<div class="uk-background-muted uk-padding">
    <form action="" method="post">
        <div class="padding">
            <h2><?php echo $dados['nome'];?></h2>
            <b>Email:</b> <?php echo $dados['email'];?> <b style="margin-left: 25px;">Telefone:</b> <?php echo $dados['telefone'];?><br><br>

            <label for="" class="label label-default">Redes Sociais</label> <br><br>

            <?php if ($dados['facebook'] == NULL) { } else { ?>
                <a href="http://www.fb.com/<?php echo $dados['facebook']; ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-facebook-square"></i></a>
            <?php } ?>

            <?php if ($dados['twitter'] == NULL) { } else { ?>
                <a href="http://www.twiiter.com/<?php echo $dados['twitter']; ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-twitter-square"></i></a>
            <?php } ?>

            <?php if ($dados['instagram'] == NULL) { } else { ?>
                <a href="http://www.instagram.com/<?php echo $dados['instagram']; ?>" target="_blank" rel="noopener noreferrer"><i class="fa fa-instagram"></i></a>
            <?php } ?>

            <hr>

            <div class="row">
                <div class="col-sm-4">
                    <b>Membro</b><br>
                     <?php if ($dados['membro'] == S) { ?>
                        <i class="fa fa-check-circle"></i> Sim, sou membro
                    <?php } else {?>
                        <i class="fa fa-times-circle"></i> Não sou membro
                    <?php } ?>
                </div>

                <div class="col-sm-4">
                    <b>Ministério(s) desejado(s)</b><br>
                    <?php

                    $tag_ex = explode(", ",substr($dados['ministerio'],0,-2));
                    for($t = 0; $t < count($tag_ex); $t++) {
                        echo "<i class='fa fa-tag'></i> " . $tag_ex[$t]." <br>";
                    }
                    ?>
                </div>
            </div>

            <div class="clearfix"></div>
            <hr>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-sm-12">
                    <label for="" class="label label-default">Descrição</label> <br><br>
                    <?php echo $dados['texto'];?>
                </div>
            </div>

        </div>
    </form>

</div>
<?php require ($_SERVER['DOCUMENT_ROOT']."/cms/inc/footer.php"); ?>