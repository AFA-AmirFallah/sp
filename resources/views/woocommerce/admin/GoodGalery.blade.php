@php
    $Persian = new App\Functions\persian();
    if ($iframe) {
        $Layout = 'iframe';
    } else {
        $Layout = null;
    }
@endphp

@extends('Layouts.MainPage', ['layout' => $Layout])
@section('page-header-left')
@endsection
@section('MainCountent')
    @if (!$iframe)
        <div class="breadcrumb">
            <h1>عملیات کالا</h1>
            <ul>
                <li><a href="">گالری </a></li>
                <li>کالا</li>
            </ul>
        </div>
        <div class="separator-breadcrumb border-top"></div>
    @endif

    <form method="post">
        @csrf
        <div class="2-columns-form-layout">
            <div class="">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- start card -->
                        <div class="card">
                            @if (!$iframe)
                                <div class="card-header bg-transparent">
                                    <h3 class="card-title"> گالری {{ $good->NameFa }}</h3>
                                </div>
                            @endif
                            <!--begin::form-->
                            <div class="card-body">
                                @php
                                    $Counter = 1;
                                @endphp
                                @foreach ($picrefrence as $picrefrenceItem)
                                    <div class="form-group row">
                                        <div class="form-group col-md-2">
                                            {{ $picrefrenceItem->name }}
                                        </div>
                                        <div class="form-group col-md-2">
                                            <a id="lfm_{{ $Counter }}" data-input="modal_pic_{{ $Counter }}"
                                                data-preview="holder" class="btn btn-primary text-white">
                                                انتخاب تصویر
                                            </a>
                                            <button type="button" onclick="deletepic('{{ $picrefrenceItem->id }}')"
                                                class="btn btn-danger text-white">
                                                حذف
                                            </button>
                                            <input id="modal_pic_{{ $Counter }}" class="form-control nested"
                                                type="text" name="pic_{{ $picrefrenceItem->id }}"
                                                value=@if ($ImageArray != null) 
                                                @foreach ($ImageArray as $ImageArrayItem)
                                                @if ($ImageArrayItem->RefrenceID == $picrefrenceItem->id)
                                                    "{{ $Picurl = $ImageArrayItem->PicUrl }}" 
                                                    @endif
                                                @endforeach
                                        @else
                                            "{{ $Picurl = '' }}"

                                @endif
                                onchange="imagesetter({{ $Counter }})">
                            </div>
                            <div class="form-group col-md-8">
                                <img style="max-width: 300px" id="imagepreviw_{{ $Counter }}"
                                    src="{{ $Picurl }}" alt="">
                            </div>
                            @php
                                $Counter++;
                            @endphp

                        </div>

                        @endforeach

                        <div class="card-footer">
                            <div class="mc-footer">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary m-1" name="submit"
                                            value="UpdateGoods">ثبت تصاویر </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end::form -->
                </div>
            </div>
        </div>
        </div>
        </div>
    </form>
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/vendor/dropzone.min.js') }}"></script>
    <script src="{{ asset('assets/js/dropzone.script.js') }}"></script>
    <script src="{{ asset('assets/filemanager/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/filemanager/popper.min.js') }}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
    <script>
        var route_prefix = "{{ URL('/') }}/filemanager";
    </script>
    <script>
        function deletepic($selectID) {
            $('#modal_pic_' + $selectID).val('');
            document.getElementById("imagepreviw_" + $selectID).src = '';
        }
        $('.edit_btn').on('click', function() {
            var $selectID = $(this).attr('id');
            $('#addelement').hide();
            $('#editeelement').show();
            $('#modal_order').val($('#order_' + $selectID).attr('name'));
            $('#modal_theme').val($('#theme_' + $selectID).attr('name'));
            $('#modal_pic').val($('#pic_' + $selectID).attr('name'));
            $('#modal_title').val($('#title_' + $selectID).attr('name'));
            //  $('#tableID').val($selectID);
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
            $('#modal_order').val(null);
            $('#modal_theme').val(null);
            $('#modal_pic').val(null);
            $('#modal_title').val(null);

        });
    </script>

    <script>
        $('textarea[name=ce]').ckeditor({
            height: 100,
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

    <script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/ckeditor.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/ckeditor/4.5.11/adapters/jquery.js"></script>
    <script>
        $('textarea[name=ce]').ckeditor({
            height: 100,
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
        function imagesetter(id) {
            document.getElementById("imagepreviw_" + id).src = document.getElementById("modal_pic_" + id).value;
        }
    </script>
@endsection
