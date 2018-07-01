/***************************************
 * JQuery based script
 * Basket on client side
 * Created WebInside WebStudio (c) 2014
 * Use only for linked www.webinside.ru
 **************************************/

var local = {
  'basket_is_empty': '0',
  'name': 'Название',
  'price': 'Цена',
  'all': 'Всего',
  'order': 'ОФОРМИТЬ',
  'basket': 'корзина',
  'num': 'кол-во',
  'send': 'Спасибо за покупку!\nМы свяжемся с Вами в ближайшее время',
  'goods': 'Подарков: ',
  'amount': 'Сумма: ',
};

function WICard(obj, plugins) {
  this.widjetX = 0;
  this.widjetY = 0;
  this.widjetObj;
  this.widjetPos;
  this.cardID = '';
  this.DATA = {};
  this.IDS = [];
  this.objNAME = obj;
  this.CONFIG = {};
  this.IMG = 'iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAABpFBMVEUAAABEREBEREBEREBEREASEhEJCQgGBgYBAQEAAAAGBgUHBwYAAAAAAAADAwNEREBEREAJCQkICAcGBgYFBQUJCQgnJyVEREAICAgBAQEAAAAICAcAAAAAAAAAAAAJCQgAAAAGBgYBAQEQEA8NDQwHBwcBAQEMDAsSEhEJCQkBAQEBAQEBAQFAQDxEREBEREADAwIAAAABAQESEhEkJCIAAAAICAgAAAAQEA9EREAAAAATExIAAAAKCgkNDQwAAAAAAAABAQETExIHBwcDAwMDAwMTExIAAAAAAAABAQEAAAAAAAAAAAAAAAAAAAAAAAADAwIAAAAGBgUBAQEWFhUAAAAAAAAHBwYBAQEVFRMDAwMHBwcUFBMWFhUBAQETExIAAAAAAAADAwMMDAsAAAAAAAASEhEAAAAUFBMAAAAJCQkrKygDAwMAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAADAwMAAAAJCQgAAAAiIiABAQEAAAAAAAAAAAAAAAAAAAAAAAAAAAABAQFEREAFBQUBAQEAAAAGBgYICAgHBwcBAQEJW8x2AAAAhXRSTlMAAQcIAjJ0kZqZnp+LaygNDxKw/v6wIwPY1A+upf4nenGWvXCg/Pubc8eSmLkcHxpW+vlhBr6hl3EDUl9pop5Q+fhe+1FPXVT8mlxfXWD9+1dbnPRRRved9ldI+Fhd+mBaVlSYWJN1V2dqwwVTA8ORvJXAknRzKii2rCjc3BUTqagrepgUbRZwswAAAAlwSFlzAAAASAAAAEgARslrPgAAAb1JREFUOMuNk2dTwkAQhpdiCZagotiwd5RYQeyKJdii2FDsvffeG0TJnza3lzg4kBnv0zt5NpvdZ3IA/zs6vUGv00wAxrj4hESGnERTkomk5JRU1swaFZ6WnhEMieSEgl9qsmRmWVWe/R2W8KkUjkw5uUr/vNhcEvPpLHEZGly0FYA8pb4wqMFFscioBzAU06lKSsvKKa+orKqmqYY1yB3smGvrHFx9A0mNTQ6uuQU7Oc1yB50Lc6uDc0ObXNHYTlIHfqmTJaZcmLvkpwDdPb19hAODkzjRlAuzpx93GhhEPsTjpF6gBTg1PyxnN4d8hHKJoQUhuhU/qvKxcWVTWmAPKlsLE5RP8qoJLND5vhQ/U9PIYWZWNcWgyTnFpH+ecoCFgNKTQZM+atK/qHI3txSg73gjTC6vIF9dw0nXhSiTG8g3eaEeJ92KMrlN+I4gSp5dkvaiTO4fAKwJ6PQQ4Og4wuQJ3fp070zZXzhJOafpAgsuQ2Gtf+4KC64tWtx2gybZW61/8g7QpPn+ITZ/fAI0yVqfX2wx+r8+gxVNkl3f3j+cnU4v3j4vSa73NwDrJ5qkt+f3Jv5N6u3Vvt0/UGcpYbC85ecAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTMtMDUtMThUMDY6MDM6MzEtMDU6MDALk1CfAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDEzLTA1LTE4VDA2OjAzOjMxLTA1OjAwes7oIwAAAABJRU5ErkJggg==';

  this.init = function(widjetID, config) {
    this.CONFIG = config || {};
    try {
      this.DATA = JSON.parse(localStorage.getItem(widjetID));
      if ($.isEmptyObject(this.DATA)) {
        this.DATA = {};
      }
    }
    catch (e) {
      this.DATA = {};
    }
    try {
      this.IDS = JSON.parse(localStorage.getItem(widjetID + '_ids'));
      if ($.isEmptyObject(this.IDS)) {
        this.IDS = [];
      }
    }
    catch (e) {
      this.IDS = [];
    }

    this.cardID = widjetID;

    this.widjetObj = $('#' + widjetID);

    if ($.isEmptyObject(this.DATA)) {
      this.widjetObj.html(local.basket_is_empty);
      $('.message').show();
    }
    else {
      $('.message').hide();
      this.reCalc();
      this.renderBasketTable();
    }

  };

  /***********************************************************************************************
   * example: onclick="cart.addToCart(this, '2', 'Name of comic 2', '25500')
   **********************************************************************************************/
  this.addToCart = function(curObj, id, params) {
    var kol = 1;

    if ($('input').is('#' + wiNumInputPrefID + id)) {
      kol = parseInt($('#' + wiNumInputPrefID + id).val());
    }
    // photo

    var item_photo = '<img class="wi-item-photo" src="' +
        $('#wiphoto_' + id).attr('src') + '" />';

    id = ($.isNumeric(id)) ? 'ID' + id.toString() : id;

    if (typeof WICartObjToString == 'function') {
      var id_ = ($.isEmptyObject(params.subid)) ?
          id :
          id + WICartObjToString(params.subid, '_id', '_'); // WICartObjToString [wicart.optional.js]
      var name_ = ($.isEmptyObject(params.subid)) ?
          params.name :
          params.name + WICartObjToString(params.subid, '_name', ' / '); // WICartObjToString [wicart.optional.js]
      var weight_ = ($.isEmptyObject(params.subid)) ?
          params.weight :
          params.weight + WICartObjToString(params.subid, '_weight', ' / '); // WICartObjToString [wicart.optional.js]
    }
    else {
      var id_ = id;
      var name_ = params.name;
      var weight_ = params.weight;

    }
    // для плагина optional.js
    var price = (typeof params.totalprice != 'undefined') ?
        params.totalprice :
        params.price;

    var goodieLine = {
      'id': id_,
      'name': name_,
      'price': price,
      'num': kol,
      'url': document.location.href,
      'photo': item_photo,
      'weight': weight_,
    };

    if ($.isEmptyObject(this.DATA)) {
      this.DATA[id_] = goodieLine;
      this.IDS.push(id_);
    }
    else
      for (var idkey in this.DATA) {

        if ($.inArray(id_, this.IDS) === -1) {
          this.DATA[id_] = goodieLine;
          this.IDS.push(id_);

        }
        else if (idkey == id_) {

          this.DATA[idkey].num += kol;

        }
      }

    localStorage.setItem(this.cardID, JSON.stringify(this.DATA));
    localStorage.setItem(this.cardID + '_ids', JSON.stringify(this.IDS));
    this.reCalc();

    this.renderBasketTable();

    if (this.CONFIG.showAfterAdd) {
      cart.showWinow('bcontainer', 1);
    }
  };
  this.reCalc = function() {
    var num = 0;
    var sum = 0;
    for (var idkey in this.DATA) {
      num += parseInt(this.DATA[idkey].num);
      sum += parseFloat(parseInt(this.DATA[idkey].num) *
          parseFloat(this.DATA[idkey].price));
    }

    // *** currency plugin *** //

    if (typeof WICartConvert == 'function') {
      sum = WICartConvert(sum);
    }

    // *** //
    this.widjetObj.html(num);
    localStorage.setItem(this.cardID, JSON.stringify(this.DATA));
  };
  this.clearBasket = function() {
    this.DATA = {};
    this.IDS = [];
    this.widjetObj.html(local.basket_is_empty);
    localStorage.setItem(this.cardID, '{}');
    localStorage.setItem(this.cardID + '_ids', '[]');
    $('#btable').html('');
    $('#htable').html('');
    $('#bcontainer').remove();
    $('#blindLayer').remove();
  };
  this.renderBasketTable = function() {

    if ($('#bcontainer').length == 0) {
      $('body').append(' \
				<div id=\'bcontainer\' class=\'bcontainer\'> \
				<table class=\'btable\' id=\'btable\'></table> \
				<div class=\'delivery_info_basket\'>\
                    СУММА <span class=\'card_body_right\' id=\'bsum\'>...</span>\
                    </div>\
				<div id=\'bfooter\'><button class=\'bbutton-basket\' onclick="cart.showWinow(\'order\', 1)">' +
          local.order + '</button></div> \
				<table id=\'htable\' class=\'hidden\'></table> \
				</div> \
			');

    }
    else {
      $('#btable').html('');
      $('#htable').html('');
    }
    this.center($('#bcontainer'));

    for (var idkey in this.DATA) {

      with (this.DATA[idkey]) {
        var productLine = '<div class="card_body"> \
										<div class="table"> \
											<div class="row"> \
												<div class="col cell_img">' + photo + '</div> \
												<div class="col cell_info c100" style="vertical-align:top; text-align:left;"> \
												<div class="card_body_inline">\
													<b>' + name + '</b> \
													</br><span id="lineprice_' + id +
            '"class="wigoodprice">' + price + '</span> Ք \
												</div>\
													<div class="card_body_inline card_body_right">\
													\<div class="col" style="width:20px; text-align:center; padding-top: 2px;"><center><b><span id="basket_num_' +
            id + '" style="font-size: 16px;">' + num + '</span></b></center></div> \
													<div class="col" style="vertical-align:top; width:20px; text-align:center;"><a class="cart_mp" id="minus_' +
            id + '"><img src="icons/icon-minus.png" width="25"/></a></div> \
													<div class="col" style="vertical-align:top; width:20px; text-align:center;"><a class="cart_mp" id="plus_' +
            id + '"><img src="icons/icon-plus.png" width="25"/></a></div> \
													</div>\
												</div> \
												<div class="col cell_info" style="vertical-align:top; width: 30px; text-align:center;"><a href="#" class="bdel" onclick="' +
            this.objNAME + '.delItem(\'' + id + '\')"><img src="icons/icon-close.png" width="25"/></a> \
												</div> \
											</div> \
										</div> \
									</div>';
      }

      $('#btable').append(productLine);

      /**** Скрытая таблица *******************/
      with (this.DATA[idkey]) {
        var hProductLine = '<tr class="bitem" id="hwigoodline-' + id + '"> \
								<td>' + id + '</td> \
								<td><a href="' + url + '">' + name + '</a></td> \
								<td id="hlineprice_' + id + '"class="wigoodprice">' + price + '</td> \
								<td><span id="hbasket_num_' + id + '">' + num + '</td> \
								<td id="hlinesum_' + id + '">' + parseFloat(price * num) + '</td> \
								</tr>';
      }

      // $("#htable").append(hProductLine);

      $('.basket_num_buttons').data('min-value');
    }
    //* кнопки +/-
    var self = this;
    for (var ids in this.IDS) {
      $('#minus_' + this.IDS[ids]).bind('click', function() {
        var cartItemID = $(this).attr('id').substr(6);
        var cartNum = parseInt($('#basket_num_' + cartItemID).text());
        var cartNum = (cartNum > 1) ? cartNum - 1 : 1;
        self.DATA[cartItemID].num = cartNum;

        $('#basket_num_' + cartItemID).html(cartNum);
        $('#hbasket_num_' + cartItemID).html(cartNum);
        var price = parseFloat($('#lineprice_' + cartItemID).html());
        $('#linesum_' + cartItemID).html(parseFloat(price * cartNum));
        $('#hlinesum_' + cartItemID).html(parseFloat(price * cartNum));
        self.sumAll();

        self.reCalc();

      });

      $('#plus_' + this.IDS[ids]).bind('click', function() {
        var cartItemID = $(this).attr('id').substr(5);
        var cartNum = parseInt($('#basket_num_' + cartItemID).text());
        var cartNum = (cartNum < 1000000) ? cartNum + 1 : 1000000;
        self.DATA[cartItemID].num = cartNum;
        $('#basket_num_' + cartItemID).html(cartNum);
        $('#hbasket_num_' + cartItemID).html(cartNum);
        var price = parseFloat($('#lineprice_' + cartItemID).html());
        $('#linesum_' + cartItemID).html(parseFloat(price * cartNum));
        $('#hlinesum_' + cartItemID).html(parseFloat(price * cartNum));
        self.sumAll();
        self.reCalc();

      });

    }
    this.sumAll();

  };
  this.sumAll = function() {
    var sum = 0;
    for (var idkey in this.DATA) {
      sum += parseFloat(this.DATA[idkey].price * this.DATA[idkey].num);
    }
    $('#bsum').html(sum + ' Ք');

    //if (sum == 0) document.location.href = 'index.html';
  };
  this.center = function(obj) {

  };
  this.showWinow = function(win, blind) {
    //alert(1)
    $('#' + win).show();
    $('html, body').animate({scrollTop: $('#formToSend').offset().top}, 500);
    if (blind)
      $('#blindLayer').show();
  };
  this.closeWindow = function(win, blind) {
    $('#' + win).hide();
    if (blind)
      $('#blindLayer').hide();
  };
  this.delItem = function(id) {


    //if (confirm("Удалить #" + id + "?"))
    //	{
    $('#btable').html('');
    $('#htable').html('');
    delete this.DATA[id];
    this.IDS.splice($.inArray(id, this.IDS), 1);
    this.reCalc();
    this.renderBasketTable();
    localStorage.setItem(this.cardID, JSON.stringify(this.DATA));
    localStorage.setItem(this.cardID + '_ids', JSON.stringify(this.IDS));
    $(this).trigger('deleteItem');
    if (this.IDS.length == 0) {
      this.widjetObj.html(local.basket_is_empty);
      $('.message').show();
      $('#bfooter').hide();
      $('#formToSend').hide();
      $('.bbutton').hide();
    }
    //	}
  };

  this.sendOrder = function(domElm) {



    $('.overlay').addClass('loading');
    if (this.CONFIG.validate) {
      var valid = this.CONFIG.validate.validationEngine('validate');
      if (!valid) {
        $('.overlay').removeClass('loading');
        return false;
      }
      $('.formError').remove();
    }

    var bodyHTML = '';
    var arr = domElm.split(',');

    for (var f = 0; f < arr.length; f++) {

      //alert(document.getElementById(arr[f]).outerHTML);

      bodyHTML += this.getForm(arr[f]) + '<br><br>';

    }
    ;
    $('.basket_num_buttons').remove();
    //$.post( "sendmail.php?subj=Order WICart", { "order": bodyHTML }).done(function( data ) {
    //cart.closeWindow("bcontainer", 1)
    //cart.closeWindow("order", 0);
    if (cart.CONFIG.clearAfterSend) {
      $(this).trigger('clickSendForm');
      cart.clearBasket();
    }
    $('#post-order').val(bodyHTML);

    $('#post-form').submit();

    //alert(local.send);
    //});

  };

  this.getForm = function(formId) {
    var formObj = document.getElementById(formId);

    //alert( $(formObj).html() );

    var copyForm = formObj.cloneNode(true);

    INPUTS = [].slice.call(copyForm.querySelectorAll('input,select,textarea'));

    INPUTS.forEach(function(elm) {
      if ((elm.tagName == 'INPUT') && (elm.type == 'checkbox')) {
        var spanReplace = document.createElement('span');
        spanReplace.innerHTML = (elm.checked) ? elm.value : '';
        elm.parentNode.replaceChild(spanReplace, elm);
      }
      else if ((elm.tagName == 'INPUT') && (elm.type == 'radio')) {
        var spanReplace = document.createElement('span');
        spanReplace.innerHTML = (elm.checked) ? elm.value : '';
        elm.parentNode.replaceChild(spanReplace, elm);
      }
      else if ((elm.tagName == 'INPUT') &&
          ((elm.type == 'text') || (elm.type == 'hidden'))) {
        //var subjP = document.createElement('b');
        //subjP.innerHTML = elm.placeholder;
        //elm.parentNode.insertBefore(subjP, elm);
        var spanReplace = document.createElement('div');
        spanReplace.innerHTML = elm.value;
        elm.parentNode.replaceChild(spanReplace, elm);
      }
      else if (elm.tagName == 'TEXTAREA') {
        //var subjP = document.createElement('b');
        //subjP.innerHTML = elm.placeholder;
        //elm.parentNode.insertBefore(subjP, elm);
        var spanReplace = document.createElement('div');
        spanReplace.innerHTML = $('#' + elm.id).val();
        elm.parentNode.replaceChild(spanReplace, elm);
      }
      if (elm.tagName == 'SELECT') {
        var selVal = $('#' + elm.id + ' option:selected').val();
        $(elm).replaceWith(selVal);
      }

    });

    return copyForm.outerHTML;
  };
}
	
