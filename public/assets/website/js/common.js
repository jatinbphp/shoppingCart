function openWishlist() {
	document.getElementById("Wishlist").style.display = "block";
}

function closeWishlist() {
	document.getElementById("Wishlist").style.display = "none";
}

function openCart() {
	document.getElementById("Cart").style.display = "block";
}

function closeCart() {
	document.getElementById("Cart").style.display = "none";
}

function openSearch() {
	document.getElementById("Search").style.display = "block";
}

function closeSearch() {
	document.getElementById("Search").style.display = "none";
}
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