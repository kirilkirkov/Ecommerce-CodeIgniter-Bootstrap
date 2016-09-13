// Shopping Cart Manager
$('.add-to-cart a').click(function() {
	var reload = false;
	var article_id = $(this).data('id');
	if($(this).hasClass('refresh-me')) {
		reload = true;
	}
	manageShoppingCart('add', article_id, reload);
});
function removeArticle(id, reload) {
	manageShoppingCart('remove', id, reload);
}
function manageShoppingCart(action, article_id, reload = false) {
	var action_error_msg = lang.error_to_cart;
	if(action == 'add') {
		$('.add-to-cart a[data-id="'+article_id+'"] span').hide();
		$('.add-to-cart a[data-id="'+article_id+'"] img').show();
		var action_success_msg = lang.added_to_cart;
	}
	if(action == 'remove') {
		var action_success_msg = lang.remove_from_cart;
	}
	$.ajax({
		type: "POST",
		url: "manageShoppingCart",
		data: {article_id: article_id, action:action}
	}).done(function (data) {
		var num_added = parseInt($('[data-artticle-id="'+article_id+'"] .num_added').text());
		if(action == 'add') {
			if(data == '1') {
				if(num_added > 1)  {
					$('[data-artticle-id="'+article_id+'"] .num_added').empty().text(num_added+1);
					var num_added_single = parseInt($('[data-artticle-id="'+article_id+'"] .prices .num-added-single').text())+1;
					var price_single = parseFloat($('[data-artticle-id="'+article_id+'"] .prices .price-single').text().replace(',',''));
					var sum_price_single = parseFloat($('[data-artticle-id="'+article_id+'"] .prices .sum-price-single').text().replace(',',''));
					var new_sum_price_single = num_added_single*price_single;
					$('[data-artticle-id="'+article_id+'"] .prices .num-added-single').text(num_added_single);
					$('[data-artticle-id="'+article_id+'"] .prices .sum-price-single').text(new_sum_price_single);
				} else {
					$('[data-artticle-id="'+article_id+'"] .num_added').text(2);
					var price_single = parseFloat($('[data-artticle-id="'+article_id+'"] .prices').text().replace(',',''));
					$('[data-artticle-id="'+article_id+'"] .prices').empty().append(
					'<span class="num-added-single">2</span> x <span class="price-single">'+price_single+'</span> - <span class="sum-price-single">'+price_single*2+'</span>'
					);
				}
			} else {
				var price_single = parseFloat($(data).find('.prices').text());
				console.log(price_single);
				if($('ul.dropdown-cart li').length == 2) { // its first item
					$('.cleaner').show().nextAll().remove();
					$('ul.dropdown-cart').append('<li class="divider"></li><li class="divider"></li><li class="text-center"><a class="go-checkout btn btn-default btn-sm" href="">'+lang.checkout+' - <span class="finalSum">'+price_single+'</span> <span class="glyphicon glyphicon-hand-right"></span></a></li>');
					var its_first = true;
				}
				$('ul.dropdown-cart li:nth-child(2)').after(data);
			}
			var sum_of_items = parseInt($('.sumOfItems').text());
			$('.sumOfItems').empty().text(sum_of_items+1);
			if(its_first != true) {
				var finalSum = parseFloat($('.finalSum').text().replace(',',''));
				$('.finalSum').text(finalSum+price_single);
			}
		}
		if(action == 'remove') {
			if(num_added-1 > 1)  {
				$('[data-artticle-id="'+article_id+'"] .num_added').empty().text(num_added-1);
				var num_added_single = parseInt($('[data-artticle-id="'+article_id+'"] .prices .num-added-single').text())-1;
				var price_single = parseFloat($('[data-artticle-id="'+article_id+'"] .prices .price-single').text());
				var sum_price_single = parseFloat($('[data-artticle-id="'+article_id+'"] .prices .sum-price-single').text());
				var new_sum_price_single = num_added_single*price_single;
				$('[data-artticle-id="'+article_id+'"] .prices .num-added-single').text(num_added_single);
				$('[data-artticle-id="'+article_id+'"] .prices .sum-price-single').text(new_sum_price_single);
			} else if(num_added-1 == 1) {
				$('[data-artticle-id="'+article_id+'"] .num_added').text(1);
				var price_single = parseFloat($('[data-artticle-id="'+article_id+'"] .prices .price-single').text());
				$('[data-artticle-id="'+article_id+'"] .prices').empty().append(price_single);
			} else {
				var price_single = parseFloat($('[data-artticle-id="'+article_id+'"] .prices').text());
				$('[data-artticle-id="'+article_id+'"]').remove();
			}
			
			var sum_of_items = parseInt($('.sumOfItems').text())-1;
			$('.sumOfItems').empty().text(sum_of_items);
			if(sum_of_items == 0) {
				$('.cleaner').hide().nextAll().remove();
				$('ul.dropdown-cart').append('<li class="text-center">'+lang.no_products+'</li>');
				$('.sumOfItems').text(0);
			} else {
				var finalSum = parseFloat($('.finalSum').text());
				$('.finalSum').text(finalSum-price_single);
			
			}
		}
		var url = window.location.href; 
		var lastSegment = url.split('/').pop();
		if(lastSegment == 'checkout' || reload == true)  location.reload(false);
		ShowNotificator('alert-success', action_success_msg);
	}).fail(function (err) {
		ShowNotificator('alert-danger', action_error_msg);
	}).always(function () {
		if(action == 'add') {
			$('.add-to-cart a[data-id="'+article_id+'"] span').show();
			$('.add-to-cart a[data-id="'+article_id+'"] img').hide();
		}
	});
}

function clearCart() {
	$.ajax({type: "POST", url: 'clearShoppingCart'});
	$('.cleaner').hide().nextAll().remove();
	$('ul.dropdown-cart').append('<li class="text-center">'+lang.no_products+'</li>');
	$('.sumOfItems').text(0);
	ShowNotificator('alert-success', lang.cleared_cart);
}

// Top Notificator
function ShowNotificator(add_class, the_text) {
	$('div#notificator').text(the_text).addClass(add_class).slideDown('slow').delay(3000).slideUp('slow', function() {
		$(this).removeClass(add_class).empty();
	});
}

// Bootstrap Confirmation
$('[data-toggle=confirmation]').confirmation({
  rootSelector: '[data-toggle=confirmation]',
  title: lang.are_you_sure,
  btnOkLabel: lang.yes,
  btnCancelLabel: lang.no
});

//DatePicker
$('.input-group.date').datepicker({
	format: "dd/mm/yy"
});

//Filters Technique
$('.go-category').click(function(){
	var category = $(this).data('categorie-id');
	$('[name="category"]').val(category);
	submitForm();
});
$('.in-stock').click(function(){
	var in_stock = $(this).data('in-stock');
	$('[name="in_stock"]').val(in_stock);
	submitForm()
});
$(".order").change(function() {
	var order_type = $(this).val();
	var order_to = $(this).data('order-to');
	$('[name="'+order_to+'"]').val(order_type);
	submitForm();
});
$("#search_in_title").keyup(function() {
  $('[name="search_in_title"]').val($(this).val());
});
$('#clear-form').click(function(){
	document.getElementById("bigger-search").reset();
	$('#search_in_title, [name="search_in_title"]').val('');
	submitForm();
});
$('.clear-filter').click(function(){ //clear filter in right col
	var type_clear = $(this).data('type-clear');
	$('[name="'+type_clear+'"]').val('');
	submitForm();
});
function submitForm() {
	document.getElementById("bigger-search").submit();
}
 
//Tootip activator
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});


//To deal with different heights
$(document).ready(function () {
    $("#products-side").eqHeight(".column-h");
});
