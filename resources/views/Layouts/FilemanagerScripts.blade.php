<script src="{{ asset('assets/js/vendor/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/dropzone.script.js') }}"></script>
<script src="{{ asset('assets/filemanager/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/filemanager/popper.min.js') }}"></script>
<script>
    var route_prefix = "{{ URL('/') }}/filemanager";
</script>
<script>
    function selectedit_item($selectID) {

        $('#addelement').hide();
        $('#editeelement').show();
        $('#DeleteElement').show();

        $('#modal_order').val($('#order_' + $selectID).attr('name'));
        $('#modal_theme').val($('#theme_' + $selectID).attr('name'));
        $('#modal_pic').val($('#pic_' + $selectID).attr('name'));
        $('#modal_page').val($('#page_' + $selectID).attr('name'));
        $('#modal_title').val($('#title_' + $selectID).attr('name'));
        $('#modal_link').val($('#link_' + $selectID).attr('name'));
        $('#BoxName').val($('#BoxName_' + $selectID).attr('name'));
        document.getElementById("tableID").value = $selectID;
        var $status = $('#status_' + $selectID).attr('name');
        if ($status == '1') {
            $('#modal_active').prop('checked', true);
            $('#modal_deactive').prop('checked', false);
        } else {
            $('#modal_active').prop('checked', false);
            $('#modal_deactive').prop('checked', true);
        }

    }
    $('.edit_btn').on('click', function() {
        var $selectID = $(this).attr('id');
        $('#addelement').hide();
        $('#editeelement').show();
        $('#DeleteElement').show();

        $('#modal_order').val($('#order_' + $selectID).attr('name'));
        $('#modal_theme').val($('#theme_' + $selectID).attr('name'));
        $('#modal_pic').val($('#pic_' + $selectID).attr('name'));
        $('#modal_page').val($('#page_' + $selectID).attr('name'));
        $('#modal_title').val($('#title_' + $selectID).attr('name'));
        $('#modal_link').val($('#link_' + $selectID).attr('name'));
        $('#BoxName').val($('#BoxName_' + $selectID).attr('name'));
        document.getElementById("tableID").value = $selectID;
        var $status = $('#status_' + $selectID).attr('name');
        if ($status == '1') {
            $('#modal_active').prop('checked', true);
            $('#modal_deactive').prop('checked', false);
        } else {
            $('#modal_active').prop('checked', false);
            $('#modal_deactive').prop('checked', true);
        }


    });
    $('#addobject').on('click', function() {
        $('#addelement').show();
        $('#editeelement').hide();
        $('#DeleteElement').hide();
        $('#modal_order').val(null);
        $('#modal_theme').val(null);
        $('#modal_pic').val(null);
        $('#modal_title').val(null);

    });
</script>
<!-- TinyMCE init -->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    var editor_config = {
        path_absolute: "",
        selector: "textarea[name=tm]",
        plugins: [
            "link image"
        ],
        relative_urls: false,
        height: 129,
        file_browser_callback: function(field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName(
                'body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document
                .getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + route_prefix + '?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }
            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        }
    };
    tinymce.init(editor_config);
</script>
<script>
    {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/stand-alone-button.js')) !!}
</script>
<script>
    $('#lfm').filemanager('image', {
        prefix: route_prefix
    });
    $('#lfm_1').filemanager('image', {
        prefix: route_prefix
    });
    $('#lfm_2').filemanager('image', {
        prefix: route_prefix
    });
    $('#lfm_3').filemanager('image', {
        prefix: route_prefix
    });
    $('#lfm_4').filemanager('image', {
        prefix: route_prefix
    });

    $('#lfm1').filemanager('file', {
        prefix: route_prefix
    });
    // $('#lfm').filemanager('file', {prefix: route_prefix});
</script>
<script>
    var lfm = function(id, type, options) {
        let button = document.getElementById(id);
        button.addEventListener('click', function() {
            var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
            var target_input = document.getElementById(button.getAttribute('data-input'));
            var target_preview = document.getElementById(button.getAttribute('data-preview'));
            window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager',
                'width=900,height=600');
            window.SetUrl = function(items) {
                var file_path = items.map(function(item) {
                    return item.url;
                }).join(',');
                // set the value of the desired input to image url
                target_input.value = file_path;
                target_input.dispatchEvent(new Event('change'));
                // clear previous preview
                target_preview.innerHtml = '';
                // set or change the preview image src
                items.forEach(function(item) {
                    let img = document.createElement('img')
                    img.setAttribute('style', 'height: 5rem')
                    img.setAttribute('src', item.thumb_url)
                    target_preview.appendChild(img);
                });
                // trigger change event
                target_preview.dispatchEvent(new Event('change'));
            };
        });
    };
    lfm('lfm2', 'file', {
        prefix: route_prefix
    });
</script>
<link href="https://sepehrmall.com/summernote.css" rel="stylesheet">
<script src="https://sepehrmall.com/summernote.js"></script>
<style>
    .popover {
        top: auto;
        left: auto;
    }
</style>
<script>
    $(document).ready(function() {
        // Define function to open filemanager window
        var lfm = function(options, cb) {
            var route_prefix = (options && options.prefix) ? options.prefix : '/filemanager';
            window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager',
                'width=900,height=600');
            window.SetUrl = cb;
        };
        // Define LFM summernote button
        var LFMButton = function(context) {
            var ui = $.summernote.ui;
            var button = ui.button({
                contents: '<i class="note-icon-picture"></i> ',
                tooltip: 'Insert image with filemanager',
                click: function() {
                    lfm({
                        type: 'image',
                        prefix: '/filemanager'
                    }, function(lfmItems, path) {
                        lfmItems.forEach(function(lfmItem) {
                            context.invoke('insertImage', lfmItem.url);
                        });
                    });
                }
            });
            return button.render();
        };
        // Initialize summernote with LFM button in the popover button group
        // Please note that you can add this button to any other button group you'd like
        $('#summernote-editor').summernote({
            toolbar: [
                ['popovers', ['lfm']],
            ],
            buttons: {
                lfm: LFMButton
            }
        })
    });
</script>

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('ckeditor/ckjquery.js') }}"></script>
<script>
    $('.ckeditor-basic').ckeditor({
        contentsLangDirection: 'rtl',
        //editorplaceholder: 'ssss',
        toolbarGroups: [{
            "name": "paragraph",
            "groups": ["list", "blocks"]
        }],
        height: 500,
        language: 'fa',
    });
    $('textarea[name=CustomerInput]').ckeditor({
        contentsLangDirection: 'rtl',
        //editorplaceholder: 'ssss',
        toolbarGroups: [{
            "name": "paragraph",
            "groups": ["list", "blocks"]
        }],
        height: 500,
        language: 'fa',
    });
    $('textarea[name=ce]').ckeditor({
        justifyClasses: ["txt-left", "txt-center", "txt-right", "txt-justify"],
        contentsLangDirection: 'rtl',
        height: 500,
        language: 'fa',
        filebrowserImageBrowseUrl: route_prefix + '?type=Images',
        filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{ csrf_token() }}',
        filebrowserBrowseUrl: route_prefix + '?type=Files',
        filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{ csrf_token() }}'
    });
    $('textarea[name=Titel]').ckeditor({
        height: 100,
        filebrowserImageBrowseUrl: route_prefix + '?type=Images',
        filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{ csrf_token() }}',
        filebrowserBrowseUrl: route_prefix + '?type=Files',
        filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{ csrf_token() }}'
    });
</script>
<script>
    $('textarea[name=ce1]').ckeditor({
        justifyClasses: ["txt-left", "txt-center", "txt-right", "txt-justify"],
        contentsLangDirection: 'rtl',
        height: 500,
        language: 'fa',
        filebrowserImageBrowseUrl: route_prefix + '?type=Images',
        filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{ csrf_token() }}',
        filebrowserBrowseUrl: route_prefix + '?type=Files',
        filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{ csrf_token() }}'
    });
    $('textarea[name=Titel]').ckeditor({
        height: 100,
        filebrowserImageBrowseUrl: route_prefix + '?type=Images',
        filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{ csrf_token() }}',
        filebrowserBrowseUrl: route_prefix + '?type=Files',
        filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{ csrf_token() }}'
    });
</script>
