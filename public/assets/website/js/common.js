function openSearch() {
	document.getElementById("Search").style.display = "block";
}

function closeSearch() {
	document.getElementById("Search").style.display = "none";
}

$(document).ready(function() {
    $('#categories_id').select2();
});

$(function () {
    $('.filter_wraps .single_fitres a').on('click',function(e) {
        if($(this).hasClass('list')) {
            $('.filter_wraps .single_fitres a.list').addClass('active');
            $('.filter_wraps .single_fitres a.grid').removeClass('active');
            $('.rows-products').removeClass('grid').addClass('list');
            $('.rows-products .col-6').removeClass('col-xl-4 col-lg-4 col-md-6 col-6').addClass('col-12');
            $('.product_grid .card-footer .text-left .d-none').removeClass('d-none').addClass('d-block');
        }
        else if ($(this).hasClass('grid')) {
            $('.filter_wraps .single_fitres a.grid').addClass('active');
            $('.filter_wraps .single_fitres a.list').removeClass('active');
            $('.rows-products').removeClass('list').addClass('grid');
            $('.rows-products .col-12').removeClass('col-12').addClass('col-xl-4 col-lg-4 col-md-6 col-6');
            $('.product_grid .card-footer .text-left .d-block').removeClass('d-block').addClass('d-none');
        }
    });

    $(document).on('click', '#quickview', function (event) {
        event.preventDefault();

        var $slider = $('.quick_view_slide');
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");

        $.ajax({
            url: url,
            type: "GET",
            data: {
                'id': id,
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(data){
                $('#quickviewModal .modal-content').html(data);
                initSlickSlider();
                $('#quickviewModal').modal('show');
            }
        });
    });

    // Snackbar for wishlist Product
    $(document).on('click', '.snackbar-wishlist', function(event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");

        $.ajax({
            url: url,
            type: "POST",
            data: {
                'id': id,
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(data) {

                $('.wishlist-counter').text(data.total);

                var msg = 'Your product was added to wishlist successfully!';
                
                Snackbar.show({
                    text: msg,
                    pos: 'top-right',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#151515'
                });
            }
        });
    });

    $(document).on('click', '.remove-wishlist', function(event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");

        $.ajax({
            url: url,
            type: "POST",
            data: {
                'id': id,
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(data) {

                $('.wishlist-counter').text(data.total);

                var msg = 'Your product was removed from the wishlist successfully!';

                $("#open-wishlist-sidebar").click();
                
                Snackbar.show({
                    text: msg,
                    pos: 'top-right',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#151515'
                });
            }
        });
    });

    $(document).on('click', '#open-wishlist-sidebar', function(event) {
        event.preventDefault();
        document.getElementById("Wishlist").style.display = "block";
        var url = $(this).attr('data-url');

        $.ajax({
            url: url,
            type: "GET",
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(data) {
                $('#Wishlist .right-ch-sideBar').html(data);
            }
        });
    });

    $(document).on('click', '#close-wishlist-sidebar', function(event) {
        document.getElementById("Wishlist").style.display = "none";
    });

    $(document).on('click', '#open-cart-sidebar', function(event) {
        event.preventDefault();
        document.getElementById("Cart").style.display = "block";
        var url = $(this).attr('data-url');

        $.ajax({
            url: url,
            type: "GET",
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(data) {
                $('#Cart .right-ch-sideBar').html(data);
            }
        });
    });

    $(document).on('click', '#close-cart-sidebar', function(event) {
        document.getElementById("Cart").style.display = "none";
    });

    $(document).on('click', '.remove-cart', function(event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");

        $.ajax({
            url: url,
            type: "POST",
            data: {
                'id': id,
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(data) {

                $('.cart-counter').text(data.total);

                var msg = 'Your product was removed from the cart successfully!';

                $("#open-cart-sidebar").click();
                
                Snackbar.show({
                    text: msg,
                    pos: 'top-right',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#151515'
                });
            }
        });
    });

    $(document).on('click', '#submit-subscriber-form', function (event) {
        event.preventDefault();

        var url = $(this).attr('data-url');
        var subscriber_email = $('#subscriber_email').val();
        var error_message = '';

        if (!subscriber_email) {
            error_message = 'Email field is required.';
        } else if (!isValidEmail(subscriber_email)) {
            error_message = 'Please enter a valid email address.';
        }

        if(error_message!=''){
            $('#subscribe_message').html('<div class="text-danger">'+error_message+'</div>');
            setTimeoutFun('#subscribe_message', 2000)
            return;
        }   

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                '_token': $('input[name="_token"]').val(),
                'email': subscriber_email
            },
            success: function(response) {
                $('#subscribe_message').html('<div class="text-success">'+response.success+'</div>');
                setTimeoutFun('#subscribe_message', 2000)
                $('#subscriber_email').val(''); 
            },
            error: function(xhr) {
                var errors = xhr.responseJSON;
                if (errors && errors.error) {
                    $('#subscribe_message').html('<div class="text-danger">' + errors.error + '</div>');
                    setTimeoutFun('#subscribe_message', 2000);
                }
            }
        });
    });

    // Add product in the Cart
    $(document).on("click", "#add_to_cartproduct", function(e) {
        e.preventDefault();
        var form = $(this).closest("form");

        // AJAX request
        $.ajax({
            url: form.attr("action"),
            type: 'POST',
            data: form.serialize(),
            success: function(response){

                $('.cart-counter').text(response)
                $('#quickviewModal').modal('hide');
                $('#addProductToCartForm')[0].reset(); // Resetting the form
                
                var msg = 'Your product was added to cart successfully!';
                
                Snackbar.show({
                    text: msg,
                    pos: 'top-right',
                    showAction: false,
                    actionText: "Dismiss",
                    duration: 3000,
                    textColor: '#fff',
                    backgroundColor: '#151515'
                });
            },
            error: function(xhr, status, error){
                var errors = JSON.parse(xhr.responseText).errors;
                $.each(errors, function(key, value) {

                    if(key=='product_id' || key=='quantity'){
                        $('.'+key).html('<strong>' + value + '</strong>');
                    } else {
                        $('.options_error').html('<strong>All options field is required.</strong>');
                    }

                });
            }
        });
    });

});

function initSlickSlider() {
    $('.quick_view_slide').slick({
        slidesToShow: 1,
        arrows: true,
        dots: true,
        infinite: true,
        autoplaySpeed: 2000,
        autoplay: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    arrows: true,
                    dots: true,
                    slidesToShow: 1
                }
            },
            {
                breakpoint: 600,
                settings: {
                    arrows: true,
                    dots: true,
                    slidesToShow: 1
                }
            }
        ]
    });
}

function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function setTimeoutFun(id, timevar) {
    setTimeout(function() {
        $(id).empty();
    }, timevar);
}