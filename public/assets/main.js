jQuery(document).ready(function($) {
	'use strict';


		//DELETE CART ITEM
		$('.btn-remove').click(function() {
			console.log("Delete Button clicked");
			const cartItemId = $(this).data('id');
			const csrfToken = $('meta[name="csrf-token"]').attr('content');
		  
			if (confirm("Are you sure you want to delete this item from your cart?")) {
			  $.ajax({
				url: '/cart/remove/' + cartItemId,
				type: 'DELETE',
				headers: {
				  'X-CSRF-TOKEN': csrfToken
				},
				success: function(response) {
				  console.log(response);
				  if (response.success) {
					window.location.reload();
				  }
				}
			  });
			}
		  });
		  

		  $("#success-message").hide();
		  //ADD PRODUCT TO CART FROM PRODUCTS PAGE
		  $('.btn-cart').click(function() {
			var productId = $(this).data('product-id');
			var csrfToken = $('meta[name="csrf-token"]').attr('content');
		
			$.ajax({
			  url: '/cart/add/' + productId,
			  type: 'POST',
			  headers: {
				'X-CSRF-TOKEN': csrfToken
			  },
			  success: function(response) {
				// handle success response
				$('#success-message').html(response.message);
				$('#success-message').show();
				$('html, body').animate({
					scrollTop: 0
				}, 'slow');
				setTimeout(function() {
                    $('#success-message').fadeOut();
                }, 3000);
			  },
			  error: function(xhr, status, error) {
				// handle error response
			  }
			});
		  });



		//GET CART DATA FOR HEADER
$.ajax({
    url: '/cart/data',
    type: 'GET',
    dataType: 'json',
    success: function(data) {
        let cartCount = 0;
        let cartTotal = 0;

        // Update cart count and total
        if (data.count > 0) {
            $('.dropdown-menu-right .dropdown-cart-products').empty();

            data.items.forEach(item => {
                cartCount += item.quantity;
                cartTotal += item.quantity * item.product.price;

                $('.dropdown-cart-products').append(`
                <div class="product">
                    <div class="product-cart-details">
                        <h4 class="product-title">
                            <a href="/product/${item.product.link}">${item.product.title}</a>
                        </h4>

                        <span class="cart-product-info">
                            <span class="cart-product-qty">${item.quantity}</span>
                            x $${parseFloat(item.product.price).toFixed(2)}
                        </span>
                    </div><!-- End .product-cart-details -->

                    <figure class="product-image-container">
                        <a href="/product/${item.product.link}" class="product-image">
                            <img src="${item.product.thumbnail}" alt="${item.product.title}">
                        </a>
                    </figure>
                    <a href="#" class="btn-remove" title="Remove Product"><i class="icon-close"></i></a>
                </div>
                `);
            });

            // Hide empty cart message
            $('.empty-cart-message').hide();
        } else {
            $('.products-list').html('');
			$('.dropdown-cart-total').hide();
			$('.dropdown-cart-action').hide();
            $('.dropdown-cart-products').html('');
            $('.empty-cart-message').show();
        }

        // Update cart dropdown
        let cartDropdown = $('.cart-dropdown');
        let cartCountElement = cartDropdown.find('.cart-count');
        let cartTotalElement = cartDropdown.find('.cart-total-price');

        cartCountElement.text(cartCount);
        cartTotalElement.text('$' + parseFloat(cartTotal).toFixed(2));
    },
    error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus + ': ' + errorThrown);
    }
});

		







	$('.demo-filter a').on('click', function(e) {
		e.preventDefault();
		var filter = $(this).attr('href').replace('#', '');
		$('.demos').isotope({ filter: '.' + filter });
		$(this).addClass('active').siblings().removeClass('active');
	});

	$('.molla-lz').lazyload({
		effect: 'fadeIn',
		effect_speed: 400,
		appearEffect: '',
		appear: function(elements_left, settings) {
			
		},
		load: function(elements_left, settings) {
			$(this).removeClass('molla-lz').css('padding-top', '');
		}
	});

	// Mobile Menu Toggle - Show & Hide
	$('.mobile-menu-toggler').on('click', function (e) {
		$('body').toggleClass('mmenu-active');
		$(this).toggleClass('active');
		e.preventDefault();
	});

	$('.mobile-menu-overlay, .mobile-menu-close').on('click', function (e) {
		$('body').removeClass('mmenu-active');
		$('.menu-toggler').removeClass('active');
		e.preventDefault();
	});

	$('.goto-demos').on('click', function(e) {
		e.preventDefault();
		$('html, body').animate({scrollTop: $('.row.demos').offset().top}, 600);
	});

	$('.goto-features').on('click', function(e) {
		e.preventDefault();
		$('html, body').animate({scrollTop: $('.section-features').offset().top}, 800);
	});

	$('.goto-elements').on('click', function(e) {
		e.preventDefault();
		$('html, body').animate({scrollTop: $('.section-elements').offset().top}, 1000);
	});

	$('.goto-support').on('click', function(e) {
		e.preventDefault();
		$('html, body').animate({scrollTop: $('.section-support').offset().top}, 1200);
	});
});

jQuery(window).on('load', function() {
	jQuery('.demos').isotope({
		filter: '.homepages',
		initLayout: true,
		itemSelector: '.iso-item',
		layoutMode: 'masonry'
	}).on('layoutComplete', function(e) {
		jQuery(window).trigger('scroll');
	});
});