/*!
    * Start Bootstrap - SB Admin v6.0.1 (https://startbootstrap.com/templates/sb-admin)
    * Copyright 2013-2020 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
$(document).ready(function () {
    "use strict";

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Add active state to sidebar nav links
    let path = window.location.href;
    $("#layoutSidenav_nav .sb-sidenav a.nav-link").each(function () {
        if (this.href === path) {
            $(this).addClass("active");
        }
    });

    // Toggle the side navigation
    $("#sidebarToggle").on("click", function (e) {
        e.preventDefault();
        $("body").toggleClass("sb-sidenav-toggled");
    });


    $(".new-item").click(function (e) {
        e.preventDefault();
        let example = $(".multipleItems .item-example");
        let clone = example.clone(true).removeClass('item-example');
        clone.find('input').attr('disabled', false);
        clone.appendTo(".multipleItems");
    });

    $(".remove-item").click(function (e) {
        e.preventDefault();
        $(this).parent('label').remove();
    });

    $("body").on('click', ".media-img", function (e) {
        $(this).toggleClass('selected');
    });

    let fancyBox_opener = null;
    $(".media-load").click(function () {
        fancyBox_opener = $(this);
    });

    $('[data-src="media"]').fancybox({
        preventCaptionOverlap: false,
        smallBtn: false,
        scrolling : 'yes',
    });

    $("body").on('click', ".accept-media", function (e) {
        let parent = $(this).parents('.media-wrapper');
        let media = parent.find('.media-blocks .media-img.selected');
        let ids = [];
        let srcs = [];
        media.each(function (index, item) {
            ids.push($(item).data('id'));
            srcs.push($(item).find('img').attr('src'));
        });
        media.removeClass('selected');

        if (fancyBox_opener === null) {
            srcs.forEach(element => $('#content').summernote('insertImage', element, 'test.jpg'));
        } else {
            if (fancyBox_opener.hasClass('single-image') && ids.length > 1) {
                alert('You must select only one image!');
                return false;
            }
            let form_group = fancyBox_opener.parents('.form-group');
            let hidden = form_group.find('input');

            hidden.val(ids.join(','));

            //append gallery images
            let object = form_group.find('.gallery');
            if (object.length > 0) {
                object.addClass('loading');
                loadGalleryImages(object, ids);
            } else {
                form_group.find('#featured_preview').attr('src', srcs[0]);
            }
        }
        fancyBox_opener = null;
        $.fancybox.close();
    });


    $("body").on('click', ".delete-media", function (e) {
        let url = $(this).data('url');
        let parent = $(this).parents('.media-wrapper');
        let media = parent.find('.media-blocks .media-img.selected');
        let ids = [];
        media.each(function (index, item) {
            ids.push($(item).data('id'));
        });
        if (ids.length < 1) {
            return false;
        } else if (!confirm('Are you sure to delete these ' + ids.length + ' images?')) {
            return false;
        }
        $.ajax({
            method: 'DELETE',
            url: url,
            data: {
                image_ids: ids,
            },
            dataType:'json',
            beforeSend: function (xhr) {
                $(".media-popup .preloader").addClass('active');
            },
            success: function (res) {
                media.remove();
            },
            error: function (xhr) {
                console.log(xhr);
            },
            complete: function (xhr) {
                $(".media-popup .preloader").removeClass('active');
            },
        });
    });

    let loadGalleryImages = function (object, gallery) {
        $.ajax({
            method: 'GET',
            url: $(object).data('url'),
            data: {
                gallery,
            },
            dataType: 'json',
            success: function (res) {
                object.html(res);
                object.removeClass('loading');
            },
            error: function (xhr) {
                console.log(xhr);
            }
        });
    }

    $("body").on('click', ".cancel-media", function (e) {
        let parent = $(this).parents('.media-wrapper');
        let media = parent.find('.media-blocks .media-img.selected');
        media.removeClass('selected');
        fancyBox_opener = null;
        $.fancybox.close();
    });

    $("body").on('submit', '#upload-file', function (e) {
        e.preventDefault();
        let url = $(this).attr('action');
        let thisForm = this;
        let formData = new FormData(thisForm);

        $.ajax({
            method: 'POST',
            url: url,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function (xhr) {
                $(".media-popup .preloader").addClass('active');
            },
            success: function (res) {
                $(".media-blocks").prepend(res);
            },
            error: function (xhr) {
                console.log(xhr);
            },
            complete: function (xhr) {
                $(".media-popup .preloader").removeClass('active');
            },
        });
    });

    let media_block = $(".media-popup");
    let button = media_block.find(".load-more");
    let page = 2;
    let loading = false;
    let scrollHandling = {
        allow: true,
        reallow: function () {
            scrollHandling.allow = true;
        },
        delay: 400,
    };

    let mediaScroll = function () {
        if (!loading && scrollHandling.allow) {
            scrollHandling.allow = false;
            setTimeout(scrollHandling.reallow, scrollHandling.delay);
            let offset = $(button).offset().top - $(window).scrollTop();
            if (1000 > offset) {
                loading = true;
                let data = {
                    page: page,
                };
                let url = $(button).data('url');
                $.get(url, data, function (res) {
                    media_block.find('.media-blocks').append(res);
                    media_block.find('.media-blocks').append(button);

                    page++;
                    loading = false;
                }).fail(function (xhr, textStatus, e) {
                    console.log(xhr);
                });
            }
        }
    }

    media_block.scroll(mediaScroll);
});
