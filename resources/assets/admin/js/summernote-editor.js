/**
 * Settings for summernote editor.
 */

$(document).ready(function () {


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var editor = $('#content');

    var loadMediaButton = function (context) {
        var ui = $.summernote.ui;
      
        // create button
        var button = ui.button({
          contents: '<i class="fas fa-images"></i> Media',
        //   tooltip: 'hello',
          click: function () {
            $.fancybox.open({ src: '#media', type : 'inline' });
          }
        });//
      
        return button.render();   // return button as jquery object
    }

    
// $('#summernote').summernote('insertImage', url, filename);
    var configFull = {
        lang: 'ru-RU', // default: 'en-US'
        shortcuts: false,
        airMode: false,
        minHeight: 500, // set minimum height of editor
        maxHeight: null, // set maximum height of editor
        focus: false, // set focus to editable area after initializing summernote
        disableDragAndDrop: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link']],
            // ['insert', ['link', 'picture']],
            ['view', ['fullscreen', 'help']],
            ['mybutton',['MyMedia']],
        ],
        buttons: {
            MyMedia: loadMediaButton
        },
        callbacks: {
        }
    };

    // Featured editor
    editor.summernote(configFull);
    


});