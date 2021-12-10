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

    // Add active state to sidbar nav links
    var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
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
        log('click');
        var example = $(".multipleItems .item-example");
        log(example);
        var clone = example.clone(true).removeClass('item-example');
        // clone.find('input').attr('type', 'text');
        clone.find('input').attr('disabled', false);
        log(clone);
        clone.appendTo(".multipleItems");

    });
    $(".remove-item").click(function (e) {
        e.preventDefault();
        $(this).parent('label').remove();
    });


    $("body").on('click', ".media-img", function (e) {
        log('click');
        $(this).toggleClass('selected');
    });

    var fancyBox_opener = null;
    $(".media-load").click(function () {
        fancyBox_opener = $(this);
    });

    $('[data-src="media"]').fancybox({
        preventCaptionOverlap: false,
        smallBtn: false,
        scrolling : 'yes',

    });

    $("body").on('click', ".accept-media", function (e) {
        log('accept');
        // var obj = $.fancybox.getInstance();
        var parent = $(this).parents('.media-wrapper');
        var media = parent.find('.media-blocks .media-img.selected');
        var ids = [];
        var srcs = [];
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
            var form_group = fancyBox_opener.parents('.form-group');
            var hidden = form_group.find('input');

            hidden.val(ids.join(','));

            //append gallery images
            var object = form_group.find('.gallery');
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
        log('delete');
        var url = $(this).data('url');
        var parent = $(this).parents('.media-wrapper');
        var media = parent.find('.media-blocks .media-img.selected');
        var ids = [];
        var srcs = [];
        media.each(function (index, item) {
            ids.push($(item).data('id'));
            srcs.push($(item).find('img').attr('src'));
        });
        if (ids.length < 1) {
            return false;
        } else if (!confirm('Are you sure to delete these ' + ids.length + ' images?')) {
            return false;
        }
        var data = {
            image_ids: ids,
        };
        $.ajax({
            method: 'DELETE',
            url: url,
            data: data,
            dataType:'json',
            beforeSend: function (xhr) {

                $(".media-popup .preloader").addClass('active');
            },
            success: function (res) {
                log('success');
                log(res);
                media.remove();

            },
            error: function (xhr) {
                log(xhr);
                log('error');
            },
            complete: function (xhr) {
                log('complete');
                $(".media-popup .preloader").removeClass('active');
            },
        });
    });

    var loadGalleryImages = function (object, gallery) {
        log(media);

        var url = $(object).data('url');
        var data = {
            gallery,
        };
        log(url);
        log(data);
        log('TEST2223334445!!!!');
        $.ajax({
            method: 'GET',
            url: url,
            data: data,
            dataType: 'json',
            success: function (res) {
                log('success');
                log(res);
                object.html(res);
                object.removeClass('loading');
            },
            error: function (xhr) {
                log(xhr);
                log('error');
            },
            complete: function (xhr) {
                log('complete');
            },
        });
    }

    $("body").on('click', ".cancel-media", function (e) {
        var parent = $(this).parents('.media-wrapper');
        var media = parent.find('.media-blocks .media-img.selected');
        media.removeClass('selected');
        fancyBox_opener = null;
        $.fancybox.close();
    });



    $("body").on('submit', '#upload-file', function (e) {
        e.preventDefault();
        log('submit');

        var url = $(this).attr('action');

        var thisForm = $(this)[0];
        var formData = new FormData(thisForm);

        $.ajax({
            method: 'POST',
            url: url,
            // data:data,
            data: formData, // данные, которые передаем
            cache: false, // кэш и прочие настройки писать именно так (для файлов)
            // (связано это с кодировкой и всякой лабудой)
            contentType: false, // нужно указать тип контента false для картинки(файла)
            processData: false, // для передачи картинки(файла) нужно false
            dataType: 'json',
            beforeSend: function (xhr) {
                log('before');
                $(".media-popup .preloader").addClass('active');
            },
            success: function (res) {
                log('success');
                log(res);
                $(".media-blocks").prepend(res);
            },
            error: function (xhr) {
                log(xhr);
                log('error');
            },
            complete: function (xhr) {
                log('complete');
                $(".media-popup .preloader").removeClass('active');
            },
        });
    });



    var media_block = $(".media-popup");
    var button = media_block.find(".load-more");
    var page = 2;
    var loading = false;
    var scrollHandling = {
        allow: true,
        reallow: function () {
            scrollHandling.allow = true;
        },
        delay: 400,
    };

    // $("body").on('scroll','.media-popup',function(e){
    //     log('123');
    //     mediaScroll;
    // });
    var mediaScroll = function () {
        if (!loading && scrollHandling.allow) {
            scrollHandling.allow = false;
            setTimeout(scrollHandling.reallow, scrollHandling.delay);
            var offset = $(button).offset().top;// - $(window).scrollTop();
            if (1000 > offset) {
                loading = true;
                var data = {
                    page: page,
                    // query: query,
                };
                var url = '/dashboard/gallery/get'; // todo remove hardcode
                $.get(url, data, function (res) {
                    log('res');
                    media_block.find('.media-blocks').append(res);
                    media_block.find('.media-blocks').append(button);


                    page = page + 1;
                    loading = false;

                }).fail(function (xhr, textStatus, e) {
                    log(xhr.responseText);
                    // log("fail");
                });
            }
        }
    }


    $(".media-popup").scroll(mediaScroll);


    function log(variable)
    {
        console.log(variable);
    }
});
