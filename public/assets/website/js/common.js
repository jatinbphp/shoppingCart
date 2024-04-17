$( function() {
    $('#description').removeAttr('required');

    $("textarea[id=description]").summernote({
        height: 250,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize', 'height']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table','picture','link','map','minidiag']],
            ['misc', ['fullscreen', 'codeview']],
        ],
        callbacks: {
            onImageUpload: function(files) {
                for (var i = 0; i < files.length; i++)
                    upload_image(files[i], this);
            }
        },
    });

    // Re-enable the required attribute after initialization
    $('#description').on('summernote.init', function() {
        $(this).attr('required', 'true');
    });
});

$(document).on('click', '#show-more', function (event) {
    event.preventDefault();
    $('#commonModal').modal('toggle');
    $("#commonModal .modal-body").html("");
    var url = $(this).attr('data-url');

    $.ajax({
        url: url,
        type: "GET",
        headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
        success: function(data){
            $('#commonModal .modal-body').html(data.review_info.description);
            $('#commonModal').modal('show');
        }
    });
});

$(document).on('click', '#search-open', function (event) {
    event.preventDefault();
	document.getElementById("Search").style.display = "block";
});

$(document).on('click', '#search-close', function (event) {
    event.preventDefault();
	document.getElementById("Search").style.display = "none";
});

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
                SnackbarAlert(msg);
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
                SnackbarAlert(msg);
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
        var action_type = $(this).attr("data-type");

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
                SnackbarAlert(msg);

                if(action_type=='page-view'){
                    setTimeout(function() {
                        location.reload();
                    }, 1000);    
                } else {
                    $("#open-cart-sidebar").click();
                }
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
        var form_type = $(this).attr('data-type');

        // AJAX request
        $.ajax({
            url: form.attr("action"),
            type: 'POST',
            data: form.serialize(),
            success: function(response){
                $('.cart-counter').text(response)
                $('#quickviewModal').modal('hide');

                if(form_type=='product-details'){
                    $('#addProductToCartFormDetails')[0].reset(); // Resetting the form
                } else {
                    $('#addProductToCartForm')[0].reset(); // Resetting the form
                }
                
                var msg = 'Your product was added to cart successfully!';
                SnackbarAlert(msg);
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

    $(document).on('change', '#update-quantity', function (event) {
        event.preventDefault();

        var url = $(this).attr('data-url');
        var id = $(this).attr('data-id');
        var quantity = $(this).val();;

        $.ajax({
            url: url,
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            data: {
                'quantity': quantity,
                'id': id,
            },
            success: function(response) {
                SnackbarAlert(response.message);

                setTimeout(function() {
                    location.reload();
                }, 2000);                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });
    });

    $('#reviewForm').submit(function(e) {
        e.preventDefault(); 
        var formData = $(this).serialize();
        var full_name = $('#reviewForm #full_name').val();
        var email_address = $('#reviewForm #email_address').val();
        var description = $('#reviewForm #description').val();

        $('.full_name-text').text('');
        $('.email_address-text').text('');
        $('.description-text').text('');

        if (!full_name) {
            $('.full_name-text').text('Full name field is required.');
            $('#full_name').focus();
            return false;
        }

        if (!email_address) {
            $('.email_address-text').text('Email address field is required.');
            $('#email_address').focus();
            return false;
        } else if (!isValidEmail(email_address)) {
            $('.email_address-text').text('Please enter a valid email address.');
            $('#email_address').focus();
            return false;
        }

        if (!description) {
            $('.description-text').text('Description field is required.');
            $('#description').focus();
            return false;
        }

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: formData,
            success: function(response) {
                SnackbarAlert(response.message);
                $('#reviewForm')[0].reset(); // Resetting the form
                $('#description').summernote('code', '');
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

function AjaxUploadImage(obj,id){
    var file = obj.files[0];
    var imagefile = file.type;
    var match = ["image/jpeg", "image/png", "image/jpg"];
    if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))){
        $('#previewing'+URL).attr('src', 'noimage.png');
        alert("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
        return false;
    } else{
        var reader = new FileReader();
        reader.onload = imageIsLoaded;
        reader.readAsDataURL(obj.files[0]);
    }
}

function imageIsLoaded(e){
    $('#DisplayImage').css("display", "block");
    $('#DisplayImage').css("margin-top", "1.5%");
    $('#DisplayImage').attr('src', e.target.result);
    $('#DisplayImage').attr('width', '150');
}

$(function () {
    $('#reviewsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#route_name").val(),
        columns: [
            { data: 'id', name: 'id', orderable: true, visible: false },
            { data: 'review_informations', orderable: false },
        ],
        "order": [[0, "DESC"]]
    });

    $('#ordersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: $("#route_name").val(),
        columns: [
            { data: 'id', name: 'id', orderable: true, visible: false },
            { data: 'order_informations', orderable: false },
        ],
        "order": [[0, "DESC"]]
    });
});

function SnackbarAlert(msg) {
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