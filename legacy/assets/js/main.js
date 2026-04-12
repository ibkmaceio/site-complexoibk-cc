/*


FUNCAO RADIO BUTTON - CONTEUDO


*/
$('input[name="forma_entrega"]').click(function () {
    if ($('input[name="forma_entrega"]:checked').val() === "Venham") {
        $('#buscar_doador_conteudo').show();
        $('#levar_doador_conteudo').hide();
    } else {
        $('#levar_doador_conteudo').show();
        $('#buscar_doador_conteudo').show();

    }
});







/*

CALENDAR


*/

$(function () {

    function onSelectHandler(date, context) {
        /**
         * @date is an array which be included dates(clicked date at first index)
         * @context is an object which stored calendar interal data.
         * @context.calendar is a root element reference.
         * @context.calendar is a calendar element reference.
         * @context.storage.activeDates is all toggled data, If you use toggle type calendar.
         * @context.storage.events is all events associated to this date
         */

        var $element = context.element;
        var $calendar = context.calendar;
        var $box = $element.siblings('.box').show();
        var text = 'You selected date ';

        if (date[0] !== null) {
            text += date[0].format('YYYY-MM-DD');
        }

        if (date[0] !== null && date[1] !== null) {
            text += ' ~ ';
        }
        else if (date[0] === null && date[1] == null) {
            text += 'nothing';
        }

        if (date[1] !== null) {
            text += date[1].format('YYYY-MM-DD');
        }

        $box.text(text);
    }

    function onApplyHandler(date, context) {
        /**
         * @date is an array which be included dates(clicked date at first index)
         * @context is an object which stored calendar interal data.
         * @context.calendar is a root element reference.
         * @context.calendar is a calendar element reference.
         * @context.storage.activeDates is all toggled data, If you use toggle type calendar.
         * @context.storage.events is all events associated to this date
         */

        var $element = context.element;
        var $calendar = context.calendar;
        var $box = $element.siblings('.box').show();
        var text = 'You applied date ';

        if (date[0] !== null) {
            text += date[0].format('YYYY-MM-DD');
        }

        if (date[0] !== null && date[1] !== null) {
            text += ' ~ ';
        }
        else if (date[0] === null && date[1] == null) {
            text += 'nothing';
        }

        if (date[1] !== null) {
            text += date[1].format('YYYY-MM-DD');
        }

        $box.text(text);
    }

    // Default Calendar
    $('.calendar').pignoseCalendar({
        theme: 'blue',
        lang: 'pt',
    });
});







/*



SHARE EVENTS



*/

$("#shareIcons").jsSocials({
    showLabel: true,
    showCount: true,
    shareIn: "popup",
    shares: [
    { share: "facebook", label: "Compartihar" },
    "twitter", "googleplus", "linkedin", "whatsapp",

    ]
});





$(document).on('click', '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
});

jQuery('ul.nav li.dropdown').hover(function() {
    jQuery(this).find('.dropdown-menu').stop(true, true).delay(1).fadeIn();
}, function() {
    jQuery(this).find('.dropdown-menu').stop(true, true).delay(1).fadeOut();
});


$('.banner-principal').owlCarousel({
    loop:true,
    autoplay:true,
    animateOut: 'fadeOut',
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    margin:10,
    nav:false,
    dots: true,
    responsive:{
        0:{
            items:1,
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})

$('.carousel-programacao').owlCarousel({
    loop:true,
    autoplay:false,
    autoplayTimeout:3000,
    autoplayHoverPause:true,
    margin:5,
    dots:true,
    responsive:{
        0:{
            items:1
        },
        769:{
            items:2
        },
        1000:{
            items:3
        }
    }
})

$('.banner-calendario').owlCarousel({
    loop:true,
    autoplay:true,
    animateOut: 'fadeOut',
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1,
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})

$('.banner-leitura').owlCarousel({
    loop:true,
    autoplay:true,
    animateOut: 'fadeOut',
    autoplayTimeout:5000,
    autoplayHoverPause:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1,
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})

$('.owl-dots').removeClass('disabled');


/*


LIDERANÇAS



*/



var cards = document.querySelectorAll('.card');

function transition() {
  if (this.classList.contains('active')) {
    this.classList.remove('active');
  } else {
    this.classList.add('active');
  }
}

cards.forEach(function (card) {return card.addEventListener('click', transition);});




/*


TV



*/
var _createClass = function () {function defineProperties(target, props) {for (var i = 0; i < props.length; i++) {var descriptor = props[i];descriptor.enumerable = descriptor.enumerable || false;descriptor.configurable = true;if ("value" in descriptor) descriptor.writable = true;Object.defineProperty(target, descriptor.key, descriptor);}}return function (Constructor, protoProps, staticProps) {if (protoProps) defineProperties(Constructor.prototype, protoProps);if (staticProps) defineProperties(Constructor, staticProps);return Constructor;};}();function _classCallCheck(instance, Constructor) {if (!(instance instanceof Constructor)) {throw new TypeError("Cannot call a class as a function");}}var $window = $(window);
var $body = $('body');var

Slideshow = function () {
  function Slideshow() {var _this = this;var userOptions = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : {};_classCallCheck(this, Slideshow);
    var defaultOptions = {
      $el: $('.slideshow'),
      showArrows: false,
      showPagination: true,
      duration: 10000,
      autoplay: true };


    var options = Object.assign({}, defaultOptions, userOptions);

    this.$el = options.$el;
    this.maxSlide = this.$el.find($('.js-slider-home-slide')).length;
    this.showArrows = this.maxSlide > 1 ? options.showArrows : false;
    this.showPagination = options.showPagination;
    this.currentSlide = 1;
    this.isAnimating = false;
    this.animationDuration = 1200;
    this.autoplaySpeed = options.duration;
    this.interval;
    this.$controls = this.$el.find('.js-slider-home-button');
    this.autoplay = this.maxSlide > 1 ? options.autoplay : false;

    this.$el.on('click', '.js-slider-home-next', function (event) {return _this.nextSlide();});
    this.$el.on('click', '.js-slider-home-prev', function (event) {return _this.prevSlide();});
    this.$el.on('click', '.js-pagination-item', function (event) {
      if (!_this.isAnimating) {
        _this.preventClick();
        _this.goToSlide(event.target.dataset.slide);
      }
    });

    this.init();
  }_createClass(Slideshow, [{ key: 'init', value: function init()

    {
      this.goToSlide(1);

      /* if (this.showArrows) {
            this.$el.append(`<div class="c-header-home_footer">
         <div class="o-container">
         <div class="c-header-home_controls -nomobile o-button-group">
            <div class="js-parallax is-inview" data-speed="1" data-position="top" data-target="#js-header">
                <button class="o-button -white -square -left js-slider-home-button js-slider-home-prev" type="button">
                    <span class="o-button_label">
                        <svg class="o-button_icon" role="img"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-prev"></use></svg>
                    </span>
                </button>
                <button class="o-button -white -square js-slider-home-button js-slider-home-next" type="button">
                    <span class="o-button_label">
                        <svg class="o-button_icon" role="img"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-next"></use></svg>
                    </span>
                </button>
            </div>
         </div>
         </div>
         </div>`);
          }
          */
      if (this.autoplay) {
        this.startAutoplay();
      }

      if (this.showPagination) {
        var paginationNumber = this.maxSlide;
        var pagination = '<div class="pagination"><div class="container">';

        for (var i = 0; i < this.maxSlide; i++) {
          var item = '<span class="pagination__item js-pagination-item ' + (i === 0 ? 'is-current' : '') + '" data-slide=' + (i + 1) + '>' + (i + 1) + '</span>';
          pagination = pagination + item;
        }

        pagination = pagination + '</div></div>';

        this.$el.append(pagination);
      }
    } }, { key: 'preventClick', value: function preventClick()

    {var _this2 = this;
      this.isAnimating = true;
      this.$controls.prop('disabled', true);
      clearInterval(this.interval);

      setTimeout(function () {
        _this2.isAnimating = false;
        _this2.$controls.prop('disabled', false);
        if (_this2.autoplay) {
          _this2.startAutoplay();
        }
      }, this.animationDuration);
    } }, { key: 'goToSlide', value: function goToSlide(

    index) {
      this.currentSlide = parseInt(index);

      if (this.currentSlide > this.maxSlide) {
        this.currentSlide = 1;
      }

      if (this.currentSlide === 0) {
        this.currentSlide = this.maxSlide;
      }

      var newCurrent = this.$el.find('.js-slider-home-slide[data-slide="' + this.currentSlide + '"]');
      var newPrev = this.currentSlide === 1 ? this.$el.find('.js-slider-home-slide').last() : newCurrent.prev('.js-slider-home-slide');
      var newNext = this.currentSlide === this.maxSlide ? this.$el.find('.js-slider-home-slide').first() : newCurrent.next('.js-slider-home-slide');

      this.$el.find('.js-slider-home-slide').removeClass('is-prev is-next is-current');
      this.$el.find('.js-pagination-item').removeClass('is-current');

      if (this.maxSlide > 1) {
        newPrev.addClass('is-prev');
        newNext.addClass('is-next');
      }

      newCurrent.addClass('is-current');
      this.$el.find('.js-pagination-item[data-slide="' + this.currentSlide + '"]').addClass('is-current');
    } }, { key: 'nextSlide', value: function nextSlide()

    {
      this.preventClick();
      this.goToSlide(this.currentSlide + 1);
    } }, { key: 'prevSlide', value: function prevSlide()

    {
      this.preventClick();
      this.goToSlide(this.currentSlide - 1);
    } }, { key: 'startAutoplay', value: function startAutoplay()

    {var _this3 = this;
      this.interval = setInterval(function () {
        if (!_this3.isAnimating) {
          _this3.nextSlide();
        }
      }, this.autoplaySpeed);
    } }, { key: 'destroy', value: function destroy()

    {
      this.$el.off();
    } }]);return Slideshow;}();


(function () {
  var loaded = false;
  var maxLoad = 3000;

  function load() {
    var options = {
      showPagination: true };


    var slideShow = new Slideshow(options);
  }

  function addLoadClass() {
    $body.addClass('is-loaded');

    setTimeout(function () {
      $body.addClass('is-animated');
    }, 600);
  }

  $window.on('load', function () {
    if (!loaded) {
      loaded = true;
      load();
    }
  });

  setTimeout(function () {
    if (!loaded) {
      loaded = true;
      load();
    }
  }, maxLoad);

  addLoadClass();
})();








/*



MASCARAS



*/

$(function() {
    $('.dt_nascimento').mask('00/00/0000');
    $('.time').mask('00:00:00');
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000000');
    $('#cartaoVencimento').mask('00/0000');
    $('.telefone').mask('(00) 0000-0000');
    $('.phone_us').mask('(000) 000-0000');
    $('.mixed').mask('AAA 000-S0S');
    $('.ip_address').mask('099.099.099.099');
    $('.percent').mask('##0,00%', {reverse: true});
    $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
    $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
    $('.fallback').mask("00r00r0000", {
        translation: {
            'r': {
                pattern: /[\/]/,
                fallback: '/'
            },
            placeholder: "__/__/____"
        }
    });

    $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});

    $('.cep_with_callback').mask('00000-000', {onComplete: function(cep) {
        console.log('Mask is done!:', cep);
    },
    onKeyPress: function(cep, event, currentField, options){
        console.log('An key was pressed!:', cep, ' event: ', event, 'currentField: ', currentField.attr('class'), ' options: ', options);
    },
    onInvalid: function(val, e, field, invalid, options){
        var error = invalid[0];
        console.log ("Digit: ", error.v, " is invalid for the position: ", error.p, ". We expect something like: ", error.e);
    }
});
    $('.crazy_cep').mask('00000-000', {onKeyPress: function(cep, e, field, options){
        var masks = ['00000-000', '0-00-00-00'];
        mask = (cep.length>7) ? masks[1] : masks[0];
        $('.crazy_cep').mask(mask, options);
    }});

    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.money').mask('#.##0,00', {reverse: true});

    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    },
    spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
        }
    };

    $('.telefone').mask(SPMaskBehavior, spOptions);

    $(".bt-mask-it").click(function(){
        $(".mask-on-div").mask("000.000.000-00");
        $(".mask-on-div").fadeOut(500).fadeIn(500)
    })

    $('pre').each(function(i, e) {hljs.highlightBlock(e)});
});





/*


TIMELINE


*/

var inputs = $('.input-timeline');
var paras = $('.description-flex-container').find('.flex-cont-timeline');
$(inputs).click(function(){
  var t = $(this),
  ind = t.index(),
  matchedPara = $(paras).eq(ind);

  $(t).add(matchedPara).addClass('active');
  $(inputs).not(t).add($(paras).not(matchedPara)).removeClass('active');
});






/*



CART - SOMATORIOS DA COMPRA



*/

// var total_final = 0;
// var taxa_percent = parseInt($('#tax_val').val(), 10) || 0;





// function calculaTotal() {
//     var total = $('#valor_doacao');

//     $('.subtotal_un').each(function(index, item) {
//         var valor_formatado = $(item).find('span').text().replace('.', '').replace(',', '.');
//         var valor = parseInt(valor_formatado, 10) || 0;
//         total = total + valor;
//     });

//     var taxa = (total * taxa_percent) / 100;
//     total_final = total + taxa;

//     $('#subtotal').find('span').text(currencyFormatted(total));
//     $('#taxa').find('span').text(currencyFormatted(taxa));
//     $('#valor_doacao').text(currencyFormatted(total));
//     $('.totalinput').find('input').val(currencyFormatted2(total_final));


//     $('.total_taxa_final').find('input').val(currencyFormatted2(taxa));
// }

// function verificaQuantidade(value, element) {
//     var inputs = $(element).parents('.card-info').find('input[type=hidden]');

//     if (parseInt(value) === 0) {
//         inputs.each(function(index, input) {
//             $(input).prop('disabled', true);
//         });

//         return;
//     }

//     inputs.each(function(index, input) {
//         $(input).prop('disabled', false);
//     });
// }

// $(document).ready(function(){
//     var field = $('.quantidade');

//     field.on('change', function(event) {
//         calculaSubtotal($(this), event.target.value);
//         verificaQuantidade(event.target.value, this);
//     });

//     field.each(function(index, select) {
//         calculaSubtotal($(this), select.value);
//         verificaQuantidade(select.value, this);
//     });
// });


/*



  FUNÇÕES PROSEGUIR



  */

  $("#prosseguir-dados-comprador").click(function() {

      // NOTIFICACAO PARA PROSSEGUIR
      UIkit.notification({
          message: '<i class="fa fa-check-circle"></i> Prossiga com o preenchimento dos dados!',
          status: 'success',
          pos: 'top-center',
          timeout: 5000
      });

      // DESABILITA OS BOTAO ANTERIOR
      $("#prosseguir-dados-comprador").addClass("disable");

      // EXIBI DIV
      $("#dados-comprador-pagador").fadeIn("slow");
  });


  $("#prosseguir-forma-pagamento").on('click', function() {

    $("form-doacao-valor").each(function() {
        $(this).validate(options);
    });


    UIkit.notification({
        message: '<i class="fa fa-check-circle"></i> Prossiga com a escolha dos meios de pagamento!',
        status: 'success',
        pos: 'top-center',
        timeout: 5000
    })

    $("#dados-forma-pagamento").fadeIn("slow");

    $("#input--cc input").focus();

});