/*


EXIBIR - OCULTAR > DIV


*/

function mostrar(idDiv){
    var estado = document.getElementById(idDiv).style.display;
    if(estado == 'none'){
        document.getElementById(idDiv).style.display = 'block';
    }else if(estado == 'block'){
        document.getElementById(idDiv).style.display = 'block';
    }
}


function ocultar(idDiv){
    var estado = document.getElementById(idDiv).style.display;
    if(estado == 'block'){
        document.getElementById(idDiv).style.display = 'none';
    }else if(estado == 'none'){
        document.getElementById(idDiv).style.display = 'none';
    }
}


/*


COUNT CARACTERES - TEXT AREA


*/

$(document).on("input", "#breve_descricao", function() {
    var limite = 200;
    var informativo = "caracteres restantes.";
    var caracteresDigitados = $(this).val().length;
    var caracteresRestantes = limite - caracteresDigitados;

    if (caracteresRestantes <= 0) {
        var breve_descricao = $("textarea[name=breve_descricao]").val();
        $("textarea[name=breve_descricao]").val(breve_descricao.substr(0, limite));
        $(".charNum").text("0 " + informativo);
    } else {
        $(".charNum").text(caracteresRestantes + " " + informativo);
    }
});

/*


ALERT > CADASTRO


*/

function initAlertCad(){
    $.confirm({
        icon: 'fa fa-cog fa-spin',
        title: 'Cadastro',
        content: 'Seu cadastro foi realizado com sucesso!',
        animation: 'zoom',
        closeAnimation: 'scale',
        type: 'green',
        typeAnimated: true,
        buttons: {
            omg: {
                text: 'Ok!',
                btnClass: 'btn-green return',
            },
        }
    });
    $(function(){
        $(document).on('click','.return',function(){
            location.href = ('javascript:history.go(-2)');
            return false;
        });
    });
}



/*


ALERT > EDICAO


*/

function initAlertEd(){
    $.confirm({
        icon: 'fa fa-cog fa-spin',
        title: 'Editado',
        content: 'Seu cadastro foi editado com sucesso!',
        animation: 'zoom',
        closeAnimation: 'scale',
        type: 'green',
        typeAnimated: true,
        buttons: {
            omg: {
                text: 'Ok!',
                btnClass: 'btn-green return',
            },
        }
    });
    $(function(){
        $(document).on('click','.return',function(){
            location.href = ('javascript:history.go(-2)');
            return false;
        });
    });
}

/*


ALERT > ERRO


*/

function initAlertError(){
    $.confirm({
        icon: 'fa fa-cog fa-spin',
        title: 'Erro no cadastro',
        content: 'Cadastro não realizado!',
        animation: 'zoom',
        closeAnimation: 'scale',
        type: 'red',
        typeAnimated: true,
        buttons: {
            omg: {
                text: 'Ok!',
                btnClass: 'btn-red returnError',
            },
        }
    });
    $(function(){
        $(document).on('click','.returnError',function(){
            document.getElementById("message_alert").style.display = 'block';
            document.getElementById("loaderSistema").style.display = 'none';
        });
    });
}



/*


UPLOAD > STATUS


*/

function initUp () {

    var div = document.getElementsByClassName("nome_file")[0];
    var input = document.getElementById("banner");

    div.addEventListener("click", function(){
        input.click();
    });

    input.addEventListener("change", function(){
        var nome = "Não há arquivo selecionado. Selecionar arquivo...";
        if(input.files.length > 0) nome = input.files[0].name;
        div.innerHTML = nome;



        var bar = $("#progressbar")[0];

        var animate = setInterval(function () {
            bar.removeAttribute('hidden');
            bar.value += 20;
            if (bar.value >= bar.max) {
                clearInterval(animate);

                UIkit.notification({
                    message: '<span uk-icon="icon: check"></span> Imagem selecionada com sucesso!',
                    status: 'success',
                    pos: 'top-center',
                    timeout: 5000
                })

            }
        }, 1000);
    });
}


/*


UPLOAD MILTIPLE


*/

function initMultiple () {

    var div = document.getElementsByClassName("nome_file")[0];
    var input = document.getElementById("imagem");

    div.addEventListener("click", function(){
        input.click();
    });

    input.addEventListener("change", function(){
        var nome = "Não há arquivo selecionado. Selecionar arquivo...";
        if(input.files.length > 0) nome = input.files[0].name;
        div.innerHTML = nome;


        var bar = $("#progressbar")[0];

        var animate = setInterval(function () {
            bar.removeAttribute('hidden');
            bar.value += 20;
            if (bar.value >= bar.max) {
                clearInterval(animate);

                UIkit.notification({
                    message: '<span uk-icon="icon: check"></span> Imagem selecionada com sucesso!',
                    status: 'success',
                    pos: 'top-center',
                    timeout: 5000
                })

            }
        }, 1000);
    });
}



/*


MENSAGEM DA SELECAO DO ICONE


*/
function initAlertIcon () {
    UIkit.notification({
        message: '<span uk-icon="icon: check"></span> Icone selecionado com sucesso',
        status: 'success',
        pos: 'top-center',
        timeout: 5000,
    })

    $(document).ready(function() {
       $('a.icons_').click(function(){
            $('html, body').animate({scrollTop:0}, 'slow');
            return false;
        });
       $("#uk-modal").css("display", "none");
    });
}

