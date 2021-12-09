require('./bootstrap');

// app.blade.php -> enviroment

$(document).ready(function () {

    initializeSelectFields();


    $("#add-review-form").submit(function (e) {
        e.preventDefault();
        log('submit');
        var url = $(this).attr('action');
        log(url);
        var data = $(this).serialize();
        var $this = $("#add-review .preloader");
        var errorBox = $("#add-review .form-errors");
        $.ajax({
            method: 'POST',
            url: url,
            data: data,
            // dataType:'json',
            beforeSend: function (xhr) {
                log('before');
                $this.addClass('active');
                errorBox.text('');
            },
            success: function (res) {
                log('success');
                if (res === '1') {
                    $.fancybox.close();
                    showSuccessMessage();
                } else {
                    errorBox.html(res);
                }
                log(res);
            },
            error: function (xhr) {
                var errors = xhr.responseJSON.errors;
                var resp = '';
                for (error in errors) {
                    resp += '<p>' + errors[error] + '</p>';
                }
                errorBox.html(resp);
                showSuccessMessage('Error!');
                log(xhr);
                log('error');
            },
            complete: function (xhr) {
                log('complete');
                $this.removeClass('active');
            },
        });
    });

    var page = 1;
    $("body").on("click", ".reviews-load", function (e) {
        // $(".reviews-load").click(function(e){
        e.preventDefault();
        var reviewsBox = $('#reviews');
        var preloader = $('#reviews .preloader');
        if ($(this).hasClass('load-more')) {
            $(this).remove();
        } else {
            $.fancybox.open(reviewsBox, {
                touch: false,
            });
            if (page > 1) {
                return false;
            }
        }
        var url = $(this).attr('href');
        url += "?page=" + page;

        $.ajax({
            method: 'GET',
            url: url,
            data: {},
            // dataType:'json',
            beforeSend: function (xhr) {
                preloader.addClass('active');
                log('before');
            },
            success: function (res) {
                log('success');
                log(res);
                reviewsBox.find('.reviews-wrapper').append(res);

            },
            error: function (xhr) {
                log(xhr);
                log('error');
            },
            complete: function (xhr) {
                log('complete');

                preloader.removeClass("active");
                page++;
            },
        });

    });

    $("body").on("submit", ".delete-review-form", function (e) {
        e.preventDefault();
        log('submit');
        var url = $(this).attr('action');
        var data = $(this).serialize();
        var review = $(this).parents('.review');
        var preloader = $('#reviews .preloader');
        $.ajax({
            method: 'POST',
            url: url,
            data: data,
            // dataType:'json',
            beforeSend: function (xhr) {
                log('before');
                preloader.addClass('active');
            },
            success: function (res) {
                log('success');
                log(res);
                if (res === '1') {
                    review.slideUp();
                } else {
                    alert(res);
                }
            },
            error: function (xhr) {
                log(xhr);
                log('error');
                alert('500 error!');
            },
            complete: function (xhr) {
                log('complete');
                preloader.removeClass("active");
            },
        });
    });

    if ($(".top-products").length > 0) {
        var preloader = $(".product-filter-section .preloader");
        loadTopSellingProducts(preloader);
        $(".product-filter-menu .category-select a").click(function (e) {
            e.preventDefault();
            log('click');
            var select = $(this);
            page = 1;
            loadTopSellingProducts(preloader, select);
        });
    }

    $(".contact-form").submit(function (e) {
        e.preventDefault();
        var url = $(this).attr('action');
        var errorBox = $(this).find('.form-errors');
        var preloader = $(this).find('.preloader');
        var data = $(this).serialize();
        $.ajax({
            method: 'POST',
            url: url,
            data: data,
            // dataType:'json',
            beforeSend: function (xhr) {
                preloader.addClass('active');
                log('before');
            },
            success: function (res) {
                showSuccessMessage();
                log('success');
                log(res);
                errorBox.html('');
            },
            error: function (xhr) {
                var errors = xhr.responseJSON.errors;
                var resp = '';
                for (error in errors) {
                    resp += '<p>' + errors[error] + '</p>';
                }
                errorBox.html(resp);
                log(xhr);
                log('error');
            },
            complete: function (xhr) {
                preloader.removeClass('active');
                log('complete');
            },
        });

    });


    $("body").on("click", ".wishlist-btn", function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var btn = $(this);
        $.ajax({
            method: 'GET',
            url: url,
            data: {},
            success: function (res) {
                log('success');
                log(res);
                btn.addClass('success');
            },
            error: function (xhr) {
                log(xhr);
                log('error');
            },
            complete: function (xhr) {
                log('complete');
            },
        });
    });
    $(".wishlist-remove").click(function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var item = $(this).parents('tr');
        $.ajax({
            method: 'GET',
            url: url,
            data: {},
            // dataType:'json',
            beforeSend: function (xhr) {
                log('before');
            },
            success: function (res) {
                log('success');
                log(res);
                item.remove();
            },
            error: function (xhr) {
                log(xhr);
                log('error');
            },
            complete: function (xhr) {
                log('complete');
            },
        });
    });

    $('.filter-form').submit(function (e) {
        e.preventDefault();

        var params = $(this).serialize();

        const urlParams = new URLSearchParams(params);

        log(urlParams.toString());

        var brands = urlParams.getAll('brand[]');

        urlParams.delete('brand[]');

        urlParams.set('brand', brands.join(','));


        var newurl = urlParams.toString();
        location.assign(window.location.pathname + '?' + newurl);
    });


    addQuantityChangeInCart();
    /* Add to cart */

    $("body").on("click", ".add-cart-open-modal", function (e) { // rename
        e.preventDefault();

        let url = $(this).attr('href');
        $.ajax({
            method: 'GET',
            url: url,
            success: function (res) {
                let attributesModal = $('.attributes-select')
                attributesModal.modal('show');
                attributesModal.find(".modal-content").html(res);
            },
            error: function (xhr) {
                log(xhr);
                log('error');
            }
        });
    });

    $("body").on("click", ".add-to-cart", function (e) {
        let url = $(this).attr('href');
        let qty, size, color;

        let attributes = $(this).parents(".modal-content").find(".product-attributes");

        qty = attributes.find('input.qty').val()

        if (attributes.length > 0) {
            let size_check = attributes.find('.fw-size-choose input:checked');
            let color_check = attributes.find('.fw-color-choose input:checked');

            size = size_check.val();
            color = color_check.val();
        }

        let attributesData = {
            color,
            size,
        }
        attributes.find(".select-attribute").each((a, el) => {
            attributesData[$(el).attr('name')] = $(el).val()
        })

        if (qty === undefined) {
            qty = 1;
        }
        let $this = $(this);
        let data = {
            qty,
            attributes: attributesData,
        }
        log(data)
        $.ajax({
            method: 'GET',
            url: url,
            data: data,
            dataType:'json',
            beforeSend: function (xhr) {
                $this.removeClass('error');
                $this.removeClass('success');
                $this.text('Adding...');
                $this.addClass('loading');
            },
            success: function (res) {
                log(res);
                changeCartQuantity(res);
                $this.text('Success!');
                $this.addClass('success');
            },
            error: function (xhr) {
                log(xhr);
                log('error');
                $this.addClass('error');
                $this.text('Error!');
            },
            complete:function (xhr) {
                $this.removeClass('loading');
            },
        });
    })

    $("body").on("submit", ".remove-col form", function (e) {
        e.preventDefault()

        let cartProduct = $(this).parents(".cart-product")
        let url = $(this).attr('action')
        $.ajax({
            method: 'DELETE',
            data: {
                _token: $(this).find('input[name="_token"]').val(),
            },
            url: url,
            success: function (res) {
                changeCartQuantity(res);
                cartProduct.remove()
            },
            error: function (xhr) {
                log(xhr);
                log('error');
            },
        });
    })

    $("body").on("click", ".cart-update", function (e) {
        e.preventDefault();

        var products = $(".cart-product");
        var url = $(this).attr('href');
        var data = [];

        products.each(function (key, product) {
            let qty = $(product).find('.pro-qty input').val()
            if (qty < 1) {
                return
            }

            data.push({
                id: $(product).data('id'),
                qty: qty,
            });
        });
        log(data);

        $.ajax({
            method: 'GET',
            url: url,
            data: {
                items: data
            },
            dataType: 'json',
            beforeSend: function (xhr) {
                log('before');
                $(".cart-table .preloader").addClass('active');
            },
            success: function (res) {
                log('success');
                log(res);
                $(".cart-section.spad > .container").html(res.html);
                addQuantityChangeInCart();
                changeCartQuantity(res.count);
                initializeSelectFields();
            },
            error: function (xhr) {
                log(xhr);
                log('error');
            },
            complete: function (xhr) {
                log('complete');
                $(".cart-table .preloader").removeClass('active');
            },
        });
    });



    // $('.upload-avatar').click(function (e) {
    //     log('click-popup');

    // });
    $('#upload-avatar-form #avatar-file').change(function (e) {
        previewFile(this, $('#preview-avatar'));
        $("#upload-avatar-form button").slideDown();
    });

    $('#upload-avatar-form').submit(function (e) {
        e.preventDefault();
        var thisForm = $(this)[0];
        var url = $(this).attr('action');
        var formData = new FormData(thisForm);
        var btn = $(thisForm).find('button[type="submit"]');
        $.ajax({
            method: 'POST',
            url: url,
            data: formData, // данные, которые передаем
            cache: false, // кэш и прочие настройки писать именно так (для файлов)
            // (связано это с кодировкой и всякой лабудой)
            contentType: false, // нужно указать тип контента false для картинки(файла)
            processData: false, // для передачи картинки(файла) нужно false
            dataType: 'json',
            beforeSend: function (xhr) {
                log('before');
                $(thisForm).parents('.popup').find('.preloader').addClass('active');
                $(thisForm).find(".form-errors").html('');
                btn.text('Sending...');
            },
            success: function (res) {
                log('success');
                log(res);
                var src = '/storage/' + res.text;
                // src = src.replace(/avatars\/.*/, obj.text);
                $("#avatar").attr('src', src);
                btn.text('Success');
                $(thisForm).parents('.popup').find('.preloader').removeClass('active');
                $.fancybox.close();
                showSuccessMessage();
            },
            error: function (data) {
                btn.text('Error!');
                console.log(data)
                if (data.responseJSON.errors != false && data.responseJSON.errors != undefined) {
                    var errordata = data.responseJSON.errors.avatar;
                    $(thisForm).find(".form-errors").text(errordata[0]);
                } else {
                    $(thisForm).find(".form-errors").text('500 error!');
                }
            },
            complete: function (xhr) {
                log('complete');
            },
        });
    });

    $('#change-profile-form').submit(function (e) {
        e.preventDefault();
        var thisForm = $(this)[0];
        var url = $(this).attr('action');
        var formData = $(this).serialize();
        var btn = $(thisForm).find('button[type="submit"]');
        $.ajax({
            method: 'POST',
            url: url,
            data: formData, // данные, которые передаем
            // dataType: 'json',
            beforeSend: function (xhr) {
                $(thisForm).find(".form-errors").html('');
                $(thisForm).parents('.popup').find('.preloader').addClass('active');
                btn.text('Sending...');
            },
            success: function (res) {
                log('success');
                log(res);
                btn.text('Success!');
            },
            error: function (data) {
                btn.text('Error!');
                log(data);
                if (data.responseJSON != undefined) {
                    if (data.responseJSON.errors != false && data.responseJSON.errors != undefined) {
                        for (error in data.responseJSON.errors) {
                            $(thisForm).find(".form-errors").append(data.responseJSON.errors[error] + '<br>');
                        }
                    } else {
                        $(thisForm).find(".form-errors").text('500 error!');
                    }
                }

            },
            complete: function (xhr) {
                log('complete');
                $(thisForm).parents('.popup').find('.preloader').removeClass('active');
                $.fancybox.close();
                showSuccessMessage();
            },
        });
    });

});

function loadTopSellingProducts(preloader, select = null, page = 1)
{
    if (select !== null) {
        var category = select.data('cat-id');
    } else {
        select = $(".product-filter-section .category-select:first-child a");
        var category = null;
    }
    var url = $('.loadTopSellingProducts').data('action');
    $.ajax({
        method: 'GET',
        url: url,
        data: {
            category,
            page,
        },
        // dataType:'json',
        beforeSend: function (xhr) {
            log('before');
            preloader.addClass('active');
            $(".product-filter-section .category-select a.active").removeClass('active');
        },
        success: function (res) {
            log('success');
            $(".top-products").html(res);
            log(res);
        },
        error: function (xhr) {
            log(xhr);
            log('error');
        },
        complete: function (xhr) {
            log('complete');
            preloader.removeClass('active');
            select.addClass('active');
        },
    });
}
function showSuccessMessage(text = 'Success!')
{
    $("#suc-mes h2").text(text);
    $.fancybox.open({
        src: '#suc-mes',
        type: 'inline',
        opts: {
            afterShow: function (instance, current) {
                console.info('done!');
            }
        }
    });
}
function log(variable)
{
    if (enviroment === 'production') {
        return '';
    }
    if (typeof variable !== 'undefined') {
        console.log(variable);
    }
}
function changeCartQuantity(quantity)
{
    var count = $("#shopping-cart-count");
    log(quantity);
    log(Number.isInteger(parseInt(quantity)));
    if (Number.isInteger(parseInt(quantity))) {
        count.text(quantity);
    }
}

function addQuantityChangeInCart()
{
    /*-------------------
        Quantity change asfasfs
    --------------------- */
    var proQty = $('.pro-qty');
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on('click', '.qtybtn', function () {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find('input').val(newVal);
    });
}
function previewFile(input,preview)
{
    var file    = input.files[0];
    var reader  = new FileReader();
    reader.onloadend = function () {
        preview.attr("src",reader.result);
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
    }
};
function initializeSelectFields()
{
    $('select:not(.color-select)').selectric();

    $('.color-select').selectric({
        onInit: function () {
            var colorClass = $(this).data('color');
            var button = $(this).parents('.selectric-color-select').find('.button');
            button.addClass(colorClass);
        },
    });
}
/*
$.ajax({
    method:'POST',
    url: url,
    data:{},
    // dataType:'json',
    beforeSend:function(xhr){
        log('before');
    },
    success:function(res){
        log('success');
        log(res);
    },
    error:function(xhr){
        log(xhr);
        log('error');
    },
    complete:function(xhr){
        log('complete');
    },
});
*/
