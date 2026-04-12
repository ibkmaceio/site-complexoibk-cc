function getEndereco() {

    function limpa_formulário_cep() {
        // Limpa valores do formulário de cep.
        $("#logradouro").val("");
        $("#bairro").val("");
        $("#cidade").val("");
        $("#estado").val("");
        $("#ibge").val("");
    }

    //Quando o campo cep perde o foco.
    $("#cep").blur(function() {

        //Nova variável "cep" somente com dígitos.
        var cep = $(this).val().replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                $("#logradouro").val("Carregando...");
                $("#bairro").val("Carregando...");
                $("#estado").val("Carregando...");
                $("#cidade").val("Carregando...");
                $("#ibge").val("Carregando...");
                $("#numero").focus();

                //Consulta o webservice viacep.com.br/
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                    if (!("erro" in dados)) {
                        //Atualiza os campos com os valores da consulta.
                        $("#logradouro").val(dados.logradouro);
                        $("#bairro").val(dados.bairro);
                        $("#estado").val(dados.uf);
                        $("#cidade").val(dados.localidade);
                        $("#ibge").val(dados.ibge);

                        UIkit.notification({
                            message: '<i class="fa fa-check-circle"></i> CEP encontrado. Prossiga com o preenchimento!',
                            status: 'success',
                            pos: 'bottom-center',
                            timeout: 5000
                        })

                        $("#numero").focus();

                    } //end if.
                    else {
                        //CEP pesquisado não foi encontrado.
                        // alert("CEP não encontrado.");
                        $(".cep").focus();
                        UIkit.notification({
                            message: '<i class="fa fa-times-circle"></i> CEP não encontrado. Digite novamente!',
                            status: 'danger',
                            pos: 'bottom-center',
                            timeout: 5000
                        })
                        limpa_formulário_cep();
                    }
                });
            } //end if.
            else {
                //cep é inválido.
                limpa_formulário_cep();
                // alert("Formato de CEP inválido.");
                $(".cep").focus();
                UIkit.notification({
                    message: '<i class="fa fa-check-circle"></i> Formato de CEP inválido. Digite novamente!',
                    status: 'danger',
                    pos: 'bottom-center',
                    timeout: 5000
                })
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    });
}