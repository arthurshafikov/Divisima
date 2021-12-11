require('./bootstrap');

// app.blade.php -> let enviroment

$(document).ready(function () {
    $('select').selectric();

    $("#add-review-form").submit(function (e) {
        e.preventDefault();
        log('submit');
        let url = $(this).attr('action');
        log(url);
        let data = $(this).serialize();
        let $this = $("#add-review .preloader");
        let errorBox = $("#add-review .form-errors");
        $.ajax({
            method: 'POST',
            url: url,
            data: data,
            beforeSend: function (xhr) {
                $this.addClass('active');
                errorBox.text('');
            },
            success: function (res) {
                if (res === '1') {
                    $.fancybox.close();
                    showSuccessMessage();
                } else {
                    errorBox.html(res);
                }
            },
            error: function (xhr) {
                putErrorInErrorBox(xhr, errorBox)
                log(xhr);
            },
            complete: function (xhr) {
                $this.removeClass('active');
            },
        });
    });

    let page = 1;
    $("body").on("click", ".reviews-load", function (e) {
        e.preventDefault();
        let reviewsBox = $('#reviews');
        let preloader = reviewsBox.find('.preloader');
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
        let url = $(this).attr('href') + "?page=" + page;

        $.ajax({
            method: 'GET',
            url: url,
            data: {},
            beforeSend: function (xhr) {
                preloader.addClass('active');
            },
            success: function (res) {
                log(res);
                reviewsBox.find('.reviews-wrapper').append(res);
            },
            error: function (xhr) {
                log(xhr);
            },
            complete: function (xhr) {
                preloader.removeClass("active");
                page++;
            },
        });

    });

    $("body").on("submit", ".delete-review-form", function (e) {
        e.preventDefault();
        log('submit');
        let url = $(this).attr('action');
        let data = $(this).serialize();
        let review = $(this).parents('.review');
        let preloader = $('#reviews .preloader');
        $.ajax({
            method: 'POST',
            url: url,
            data: data,
            beforeSend: function (xhr) {
                preloader.addClass('active');
            },
            success: function (res) {
                if (res === '1') {
                    review.slideUp();
                } else {
                    alert(res);
                }
            },
            error: function (xhr) {
                log(xhr);
                alert('500 error!');
            },
            complete: function (xhr) {
                preloader.removeClass("active");
            },
        });
    });

    if ($(".top-products").length > 0) {
        loadTopSellingProducts();
        $(".product-filter-menu .category-select a").click(function (e) {
            e.preventDefault();
            loadTopSellingProducts($(this));
        });
    }

    $(".contact-form").submit(function (e) {
        e.preventDefault();
        let url = $(this).attr('action');
        let errorBox = $(this).find('.form-errors');
        let preloader = $(this).find('.preloader');
        let data = $(this).serialize();
        $.ajax({
            method: 'POST',
            url: url,
            data: data,
            beforeSend: function (xhr) {
                errorBox.html('');
                preloader.addClass('active');
            },
            success: function (res) {
                showSuccessMessage();
            },
            error: function (xhr) {
                putErrorInErrorBox(xhr, errorBox)
                log(xhr);
            },
            complete: function (xhr) {
                preloader.removeClass('active');
            },
        });

    });

    $("body").on("click", ".wishlist-btn", function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let btn = $(this);
        $.ajax({
            method: 'GET',
            url: url,
            data: {},
            success: function (res) {
                btn.addClass('success');
            },
            error: function (xhr) {
                log(xhr);
            }
        });
    });

    $(".wishlist-remove").click(function (e) {
        e.preventDefault();
        let url = $(this).attr('href');
        let item = $(this).parents('tr');
        $.ajax({
            method: 'GET',
            url: url,
            data: {},
            success: function (res) {
                log(res);
                item.remove();
            },
            error: function (xhr) {
                log(xhr);
            }
        });
    });

    $('.filter-form').submit(function (e) {
        e.preventDefault();

        let params = $(this).serialize();
        const urlParams = new URLSearchParams(params);
        let brands = urlParams.getAll('brand[]');
        urlParams.delete('brand[]');
        urlParams.set('brand', brands.join(','));

        let newUrl = urlParams.toString();
        location.assign(window.location.pathname + '?' + newUrl);
    });

    addQuantityChangeButtonsInCart();
    /* Add to cart */

    $("body").on("click", ".add-cart-open-modal", function (e) {
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
            }
        });
    });

    $("body").on("click", ".add-to-cart", function (e) {
        let url = $(this).attr('href');
        let size, color;

        let attributes = $(this).parents(".modal-content").find(".product-attributes");
        let qty = attributes.find('input.qty').val()

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
                changeCartQuantity(res);
                $this.text('Success!');
                $this.addClass('success');
            },
            error: function (xhr) {
                log(xhr);
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
            },
        });
    })

    $("body").on("click", ".cart-update", function (e) {
        e.preventDefault();

        let products = $(".cart-product");
        let url = $(this).attr('href');
        let data = [];

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

        $.ajax({
            method: 'GET',
            url: url,
            data: {
                items: data
            },
            dataType: 'json',
            beforeSend: function (xhr) {
                $(".cart-table .preloader").addClass('active');
            },
            success: function (res) {
                log(res);
                $(".cart-section.spad > .container").html(res.html);
                addQuantityChangeButtonsInCart();
                changeCartQuantity(res.count);
                $('select').selectric();
            },
            error: function (xhr) {
                log(xhr);
            },
            complete: function (xhr) {
                $(".cart-table .preloader").removeClass('active');
            },
        });
    });

    $('#upload-avatar-form #avatar-file').change(function (e) {
        previewFile(this, $('#preview-avatar'));
        $("#upload-avatar-form button").slideDown();
    });

    $('#upload-avatar-form').submit(function (e) {
        e.preventDefault();
        let thisForm = $(this)[0];
        let url = $(this).attr('action');
        let formData = new FormData(thisForm);
        let btn = $(thisForm).find('button[type="submit"]');
        $.ajax({
            method: 'POST',
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function (xhr) {
                $(thisForm).parents('.popup').find('.preloader').addClass('active');
                $(thisForm).find(".form-errors").html('');
                btn.text('Sending...');
            },
            success: function (res) {
                $("#avatar").attr('src', '/storage/' + res.text);
                btn.text('Success');
                $.fancybox.close();
                showSuccessMessage();
            },
            error: function (xhr) {
                btn.text('Error!');
                console.log(xhr)
                putErrorInErrorBox(xhr, $(thisForm).find(".form-errors"))
            },
            complete: function (xhr) {
                $(thisForm).parents('.popup').find('.preloader').removeClass('active');
            },
        });
    });

    $('#change-profile-form').submit(function (e) {
        e.preventDefault();
        let thisForm = this;
        let url = $(this).attr('action');
        let formData = $(this).serialize();
        let btn = $(thisForm).find('button[type="submit"]');
        $.ajax({
            method: 'POST',
            url: url,
            data: formData, // данные, которые передаем
            beforeSend: function (xhr) {
                $(thisForm).find(".form-errors").html('');
                $(thisForm).parents('.popup').find('.preloader').addClass('active');
                btn.text('Sending...');
            },
            success: function (res) {
                $.fancybox.close();
                showSuccessMessage();
                btn.text('Success!');
            },
            error: function (xhr) {
                log(xhr);
                putErrorInErrorBox(xhr, $(thisForm).find(".form-errors"))
            },
            complete: function (xhr) {
                $(thisForm).parents('.popup').find('.preloader').removeClass('active');
            },
        });
    });
});

function loadTopSellingProducts(select = null) {
    let preloader = $(".product-filter-section .preloader");
    let category = null;
    if (select !== null) {
        category = select.data('cat-id');
    } else {
        select = $(".product-filter-section .category-select:first-child a");
    }
    let url = $('.loadTopSellingProducts').data('action');
    $.ajax({
        method: 'GET',
        url: url,
        data: {
            category,
        },
        beforeSend: function (xhr) {
            preloader.addClass('active');
            $(".product-filter-section .category-select a.active").removeClass('active');
        },
        success: function (res) {
            $(".top-products").html(res);
            log(res);
        },
        error: function (xhr) {
            log(xhr);
        },
        complete: function (xhr) {
            log('complete');
            preloader.removeClass('active');
            select.addClass('active');
        },
    });
}

function showSuccessMessage(text = 'Success!') {
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

function log(variable) {
    if (enviroment === 'production') {
        return '';
    }
    if (typeof variable !== 'undefined') {
        console.log(variable);
    }
}

function changeCartQuantity(quantity)
{
    if (Number.isInteger(parseInt(quantity))) {
        $("#shopping-cart-count").text(quantity);
    }
}

function addQuantityChangeButtonsInCart() {
    let proQty = $('.pro-qty');
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on('click', '.qtybtn', function () {
        let $button = $(this);
        let oldValue = $button.parent().find('input').val();
        let newVal = 0;
        if ($button.hasClass('inc')) {
            newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                newVal = parseFloat(oldValue) - 1;
            }
        }
        $button.parent().find('input').val(newVal);
    });
}

function previewFile(input, preview) {
    let file    = input.files[0];
    let reader  = new FileReader();
    reader.onloadend = function () {
        preview.attr("src",reader.result);
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
    }
}

function putErrorInErrorBox(xhr, errorBox) {
    if (typeof xhr.responseJSON !== 'undefined') {
        let resp = '';
        for (let error in xhr.responseJSON.errors) {
            resp += '<p>' + xhr.responseJSON.errors[error] + '</p>';
        }
        errorBox.html(resp);
    } else {
        errorBox.html(xhr.statusText);
    }
}
