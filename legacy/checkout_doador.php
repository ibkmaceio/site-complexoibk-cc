<div class="col-md-2 col-xs-12">
    <label for="">
        <p>CPF</p>
        <input type="text" placeholder="999.999.999-99" class="cpf" name="cpf" id="cpf">

    </label>
</div>
<div class="col-md-4 col-xs-12">
    <label for="">
        <p>Nome completo</p>
        <input type="text" placeholder="Ex: José da Silva" name="nome" id="nome">
        <div class="clearfix"></div>
    </label>
</div>
<div class="col-md-2 col-xs-12">
    <label for="">
        <p>Data de nascimento</p>
        <input type="text" placeholder="99/99/9999" class="dt_nascimento" name="dt_nascimento" id="dt_nascimento">
        <div class="clearfix"></div>
    </label>
</div>
<div class="col-md-4 col-xs-12">
    <label for="">
        <p>Email</p>
        <input type="text" placeholder="Ex: email@contato.com.br" name="email" id="email">
        <div class="clearfix"></div>
    </label>
</div>
<div class="col-md-3 col-xs-12">
    <label for="">
        <p>Sexo</p>
        <div class="radio radio-inline">
            <input id="radio-7" name="sexo" type="radio" value="Masculino">
            <label for="radio-7" class="radio-label">
                Masculino
            </label>
        </div>


        <div class="radio radio-inline">
            <input id="radio-8" name="sexo" type="radio" value="Feminino">
            <label for="radio-8" class="radio-label">
                Feminino
            </label>
        </div>
    </label>
</div>
<div class="col-md-3 col-xs-12">
    <label for="">
        <p>RG</p>
        <input type="text" placeholder="99999999-9" name="rg" id="rg">
        <div class="clearfix"></div>
    </label>
</div>
<div class="col-md-3 col-xs-12">
    <label for="">
        <p>Telefone Celular</p>
        <input type="text" placeholder="(99) 99999-9999" class="telefone" name="tel_cel" id="tel_cel">
        <div class="clearfix"></div>
    </label>
</div>
<div class="col-md-3 col-xs-12">
    <label for="">
        <p>Telefone Comercial</p>
        <input type="text" placeholder="(99) 99999-9999" class="telefone" name="telefone" id="telefone">
    </label>
</div>




<!-- DIVIDER -->
<div class="clearfix"></div>


<div class="col-md-2 col-xs-12">
    <label for="">
        <p>CEP</p>
        <input type="text" placeholder="99999-999" class="cep" maxlength="8" onfocus="getEndereco()" name="cep" id="cep">
        <div class="clearfix"></div>
    </label>
</div>
<div class="col-md-5 col-xs-12">
    <label for="">
        <p>Endereço</p>
        <input type="text" placeholder="Rua, Avenida, Praça ..." name="endereco" id="logradouro">
        <div class="clearfix"></div>
    </label>
</div>
<div class="col-md-2 col-xs-12">
    <label for="">
        <p>Número</p>
        <input type="text" placeholder="99" name="numero" id="numero">
        <div class="clearfix"></div>
    </label>
</div>
<div class="col-md-3 col-xs-12">
    <label for="">
        <p>Complemento</p>
        <input type="text" placeholder="Ex: Bloco 2 - Apartamento 605" name="complemento" id="complemento">
        <div class="clearfix"></div>
    </label>
</div>
<div class="col-md-2 col-xs-12">
    <label for="">
        <p>Bairro</p>
        <input type="text" placeholder="Cidade Universitária" name="bairro" id="bairro">
        <div class="clearfix"></div>
    </label>
</div>
<div class="col-md-2 col-xs-12">
    <label for="">
        <p>Cidade</p>
        <input type="text" placeholder="Ex: Recife" name="cidade" id="cidade">
        <div class="clearfix"></div>
    </label>
</div>
<div class="col-md-2 col-xs-12">
    <label for="">
        <p>Estado</p>
        <input type="text" placeholder="Ex: Pernambuco" name="estado" id="estado">
        <div class="clearfix"></div>
    </label>
</div>



<script>
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
</script>