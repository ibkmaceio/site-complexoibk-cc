// LOADING PÄGINA

function loaderSystem(acao){
  if(acao){
    $('#loaderSistema').show();
  }else{
    $('#loaderSistema').hide();
  }
}

// AUTOCOMPLETE - FALSE
if (navigator.userAgent.toLowerCase().indexOf("chrome") >= 0) {
    $(window).load(function(){
        $('input:-webkit-autofill').each(function(){
            var text = $(this).val();
            var name = $(this).attr('name');
            $(this).after(this.outerHTML).remove();
            $('input[name=' + name + ']').val(text);
        });
    });
}

// MINIMIZE > MAXIME PAINEL

jQuery(document).ready(function() {
   jQuery('.minimize').click(function(){
      var t = jQuery(this);
      var p = t.closest('.panel');
      if(!jQuery(this).hasClass('maximize')) {
         p.find('.panel-body, .panel-footer').slideUp(200);
         t.addClass('maximize');
         t.html('&plus;');
      } else {
         p.find('.panel-body, .panel-footer').slideDown(200);
         t.removeClass('maximize');
         t.html('&minus;');
      }
      return false;
   });
});



// EDITOR TEXTAREA

$('textarea').summernote({
   toolbar: [
   // [groupName, [list of button]]
   ['style', ['bold', 'italic', 'underline', 'clear']],
   // ['font', ['strikethrough', 'superscript', 'subscript']],
   // ['fontsize', ['fontsize']],
   // ['para', ['ul', 'ol', 'paragraph']],
   // ['height', ['height']],
   // ['insert', ['picture', 'link', 'video', 'table', 'hr']],
   // ['misc', ['fullscreen', 'codeview']],
   ],
   minHeight: 150,             // set minimum height of editor
   maxHeight: 500,             // set maximum height of editor
   focus: false,
});

  var postForm = function() {
      var content = $('textarea').html($('#summernote').code());
  }

// MASCARAS

$(".data").mask("99/99/9999");
$(".cep").mask("99999999");
$(".cpf").mask("999.999.999-99");
$(".cnpj").mask("99.999.999/9999-99");
 $('.money').mask("#.##9,99", {reverse: true});

jQuery("input.telefone")
.mask("(99) 9999-9999?9")
.focusout(function (event) {
   var target, phone, element;
   target = (event.currentTarget) ? event.currentTarget : event.srcElement;
   phone = target.value.replace(/\D/g, '');
   element = $(target);
   element.unmask();
   if(phone.length > 10) {
     element.mask("(99) 99999-999?9");
  } else {
     element.mask("(99) 9999-9999?9");
  }
});



// BUSCA CEP

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
      //Atualiza os campos com os valores.
      document.getElementById('endereco').value=(conteudo.logradouro);
      // document.getElementById('bairro').value=(conteudo.bairro);
      document.getElementById('cidade').value=(conteudo.localidade);
      document.getElementById('estado').value=(conteudo.uf);
  } //end if.
  else {
      //CEP não Encontrado.
      limpa_formulário_cep();
      alert("CEP não encontrado.");
   }
}

function pesquisacep(valor) {

  //Nova variável "cep" somente com dígitos.
  var cep = valor.replace(/\D/g, '');

  //Verifica se campo cep possui valor informado.
  if (cep != "") {

      //Expressão regular para validar o CEP.
      var validacep = /^[0-9]{8}$/;

      //Valida o formato do CEP.
      if(validacep.test(cep)) {

          //Preenche os campos com "..." enquanto consulta webservice.
          document.getElementById('endereco').value="Carregando ...";
          // document.getElementById('bairro').value="Carregando ...";
          document.getElementById('cidade').value="Carregando ...";
          document.getElementById('estado').value="Carregando ...";

          //Cria um elemento javascript.
          var script = document.createElement('script');

          //Sincroniza com o callback.
          script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

          //Insere script no documento e carrega o conteúdo.
          document.body.appendChild(script);

      } //end if.
      else {
          //cep é inválido.
          limpa_formulário_cep();
          alert("Formato de CEP inválido.");
       }
  } //end if.
  else {
      //cep sem valor, limpa formulário.
      limpa_formulário_cep();
   }
};

$('.senha').bsStrongPass();