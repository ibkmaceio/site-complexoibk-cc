/*



VALIDACAO - VOUCHER



*/
$("#form-voluntario").validate({
    success: function(label) {
        label.text("Preenchido corretamente!").addClass("success");
    },

    rules : {
        ministerio:{
            required: true,
        },
        membro:{
            required:true,
        },
        nome:{
            required:true,
            minlength:3,
        },
        email:{
            required:true,
            email: true,
        },
        telefone:{
            required:true,
        },
        dt_nascimento:{
            required:true,
        },
        texto:{
            required:true,
        },
    },
    messages:{
        ministerio:{
            required:"Selecione 1 ministério desejado",
        },
        membro:{
            required:"Selecione uma das alternativas",
        },
        nome:{
            required:"Digite seu Nome Completo",
            minlength: "Digite no minimo 3 caracteres",
        },
        email:{
            required:"Informe um Email Válido",
            email: "Digite um email @dominio.com",
        },
        telefone:{
            required:"Informe um Telefone de Contato",
        },
        dt_nascimento:{
            required:"Digite sua Data de Nascimento",
        },
        texto:{
            required:"Digite seu texto",
        },
    }
});

/*



VALIDACAO - COMPRA



*/
$("#form-doacao-valor").validate({
    errorLabelContainer: $("#form-doacao-valor div.error"),
    // success: function(label) {
    //     var name = this.label.attr("for");
    //     label.text(" Preenchido corretamente!").addClass("success");
    // },

    errorElement: "i",

    rules : {
        cpf:{
            required: true,
            minlength: 14,
            validaCPF: true
        },
        nome:{
            required:true,
            minlength:3,
        },
        dt_nascimento:{
            required:true,
            maxlength:10,
        },
        email:{
            required:true,
            email: true,
        },
        sexo:{
            required:true,
        },
        rg:{
            required:true,
            number: true,
        },
        tel_cel:{
            required:true,
        },
        cep:{
            required:true,
            number: true,
            maxlength:8,
        },
        endereco:{
            required:true,
        },
        numero:{
            required:true,
            number: true,
        },
        bairro:{
            required:true,
        },
        cidade:{
            required:true,
        },
        estado:{
            required:true,
        },
    },
    messages:{
        cpf:{
            required:"Por favor, informe seu CPF",
            minlength: "Digite seu CPF completo!",
        },
        nome:{
            required:"Digite seu Nome Completo",
            minlength: "Digite no minimo 3 caracteres",
        },
        dt_nascimento:{
            required:"Digite sua Data de Nascimento",
            minlength: "Digite a Data Completa",
        },
        email:{
            required:"Informe um Email Válido",
            email: "Digite um email @dominio.com",
        },
        sexo:{
            required:"Informe o Sexo",
        },
        rg:{
            required:"Informe seu RG",
            number: "Digite apenas números...",
        },
        tel_cel:{
            required:"Informe um Telefone de Contato",
        },
        cep:{
            required:"Insira um CEP Válido",
            number: "Digite apenas números...",
            maxlength: "Máximo de 8 números!",
        },
        endereco:{
            required:"Preencha seu Endereço",
        },
        numero:{
            required:"Informe um Número",
            number: "Digite apenas números...",
        },
        bairro:{
            required:"Informe seu Bairro",
        },
        cidade:{
            required:"Informe sua Cidade",
        },
        estado:{
            required:"Informe seu Estado",
        },
    }
});


/*



VALIDACAO CPF



*/


function validaCPF_msg(cpf) {
    cpf = cpf.replace('.','');
    cpf = cpf.replace('.','');
    cpf = cpf.replace('-','');

    erro = new String;
    if (cpf.length < 11) erro += "Sao necessarios 11 digitos para verificacao do CPF! \n\n";
    var nonNumbers = /\D/;
    if (nonNumbers.test(cpf)) erro += "A verificacao de CPF suporta apenas numeros! \n\n";
    if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999"){
          erro += "Numero de CPF invalido!"
    }
    var a = [];
    var b = new Number;
    var c = 11;
    for (i=0; i<11; i++){
        a[i] = cpf.charAt(i);
        if (i <  9) b += (a[i] *  --c);
    }
    if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
    b = 0;
    c = 11;
    for (y=0; y<10; y++) b += (a[y] *  c--);
    if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
    status = a[9] + ""+ a[10]
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10])){
        erro +="Digito verificador com problema!";
    }
    if (erro.length > 0){
        return false;
    }
    return true;
}

$.validator.addMethod("validaCPF", function(value, element) {
    value = value.replace('.','');
    value = value.replace('.','');
    cpf = value.replace('-','');
    while(cpf.length < 11) cpf = "0"+ cpf;
    var expReg = /^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/;
    var a = [];
    var b = new Number;
    var c = 11;
    for (i=0; i<11; i++){
        a[i] = cpf.charAt(i);
        if (i < 9) b += (a[i] * --c);
    }
    if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
        b = 0;
    c = 11;
    for (y=0; y<10; y++) b += (a[y] * c--);
        if ((x = b % 11) < 2) { a[10] = 0; } else { a[10] = 11-x; }
    if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10]) || cpf.match(expReg)) return false;
    return true;
}, "Informe um CPF válido.");


$(function(){
    $('#cpf').blur(function(){
        var cpf = $(this).val();

        // Testa a validação
        if (validaCPF_msg(cpf)) {
            UIkit.notification({
                message: '<i class="fa fa-check-circle"></i> Seu CPF é válido. Prossiga com o preenchimento!',
                status: 'success',
                pos: 'bottom-center',
                timeout: 5000
            })
        } else {
            $("#cpf").focus();
            UIkit.notification({
                message: '<i class="fa fa-times-circle"></i> Seu CPF é inválido. Preencha o campo corretamente!',
                status: 'danger',
                pos: 'bottom-center',
                timeout: 5000
            })
        }
    });
});