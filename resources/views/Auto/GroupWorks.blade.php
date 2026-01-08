@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.MainPage')
@section('page-header-left')
@endsection
@section('MainCountent')
    <style>
        .btnaria-header {
            margin-right: -7px;
            margin-bottom: -32px;
        }

        .select2-container--default .select2-results>.select2-results__options {
            width: max-content !important;
        }
    </style>
    <div class="modal fade" id="ModalCenter_task" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ایجاد وظیفه</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div style="all: unset" class="modal-body">
                    @include('Auto.SubView.tasks_add')
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modal_body" style="all: unset" class="modal-body">
                    ...
                </div>
            </div>
        </div>
    </div>

    <div class="breadcrumb">
        <h1>گروه {{ $group_src->name }}</h1>
    </div>

    <div class="separator-breadcrumb border-top"></div>


    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-3">
                    <div class="card card-primary card-icon mb-4">
                        <div class="card-body text-center"><i class="i-Check"></i>
                            <p class="mt-2 mb-2">وظایف </p>
                            <p class="text-primary text-24 line-height-1 m-0">0</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div id="table-continer" class="targetForm col-md-12">
                <div class="card o-hidden mb-4">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h3 id="Table-card-header" class="w-50 text-white float-left card-title m-0">وظایف</h3>
                        <button type="button" style="float: left;" class="btn btn-success" data-toggle="modal"
                            data-target="#ModalCenter_task">
                            ایجاد وظیفه
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="MainTable" class="table  text-center">
                                <tbody id="MainTable_body">
                                    @foreach ($user_class->get_my_tasks() as $task)
                                        <tr>
                                            <td style="text-align: right"><button type="button" class="btn btn-primary" data-toggle="modal"
                                                    onclick="add_task({{ $task->id }})"
                                                    data-target="#ModalCenter">نمایش</button>   {{ $task->title }} </td>
                                            <td>
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{ $task->progress }}%;"
                                                        aria-valuenow="{{ $task->progress }}" aria-valuemin="0"
                                                        aria-valuemax="100"> {{ $task->progress }}%</div>
                                                </div>
                                            </td>
                                            <td>{{ $task->tags }}</td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>







    <!-- end of row-->

    <!-- end of row-->
@endsection

@section('page-js')
    <script>
        function add_task(task_id) {
            $('#modal_title').html('ویرایش وظیفه ' + task_id);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    AjaxType: 'edit_task',
                    id: task_id
                },

                function(data, status) {
                    $('#modal_body').html(data);
                    intEditTaskEvents(task_id);
                });

        }
    </script>
@endsection
@section('bottom-js')
    @include('Auto.SubView.tasks_editـscript')
    <script src="{{ url('/') }}/persian-datepicker/Mh1PersianDatePicker.js"></script>
    <script type="text/javascript" src="{{ url('/') }}/assets/js/bootstrap-clockpicker.min.js"></script>
    <script type="text/javascript">
        $('.clockpicker').clockpicker({
            placement: 'top',
            align: 'left',
            donetext: 'ثبت'
        });
    </script>

    <script>وظایف
        const textarea = document.getElementById('description');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto'; // اول ریست کنیم
            this.style.height = this.scrollHeight + 'px'; // بعد تنظیم بر اساس محتوای واقعی
        });
    </script>
    <script>
        $('select').select2({
            createTag: function(params) {
                // Don't offset to create a tag if there is no @ symbol
                if (params.term.indexOf('@') === -1) {
                    // Return null to disable tag creation
                    return null;
                }

                return {

                    id: params.term,
                    text: params.term
                }
            }
        });
        $("#SelectTags").select2({
            tags: true
        });
        $("#responsible").select2({
            tags: true
        });
    </script>
    <script>
        const checklist = document.getElementById('checklist');
        let itemIndex = 0; // برای ساخت name یکتا برای هر آیتم

        function createItem(value = '') {
            const itemWrapper = document.createElement('div');
            itemWrapper.className = 'row g-2 align-items-center mb-2';

            // فیلد متنی
            const colInput = document.createElement('div');
            colInput.className = 'col-8';
            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control';
            input.placeholder = 'آیتم جدید...';
            input.name = `items[${itemIndex}]`; // نام قابل POST به صورت آرایه
            input.value = value;
            colInput.appendChild(input);
            // دکمه +
            const colAdd = document.createElement('div');
            colAdd.className = 'col-2';
            const addBtn = document.createElement('button');
            addBtn.type = 'button';
            addBtn.className = 'btn btn-success w-100';
            addBtn.textContent = '+';
            colAdd.appendChild(addBtn);

            // دکمه حذف 🗑️
            const colDelete = document.createElement('div');
            colDelete.className = 'col-2';
            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.className = 'btn btn-danger w-100';
            deleteBtn.textContent = '🗑️';
            colDelete.appendChild(deleteBtn);
            // دکمه افزودن
            addBtn.addEventListener('click', () => {
                if (input.value.trim() !== '') {
                    createItem();
                    //input.disabled = true;
                    addBtn.disabled = true;
                    addBtn.classList.remove('btn-success');
                    addBtn.classList.add('btn-secondary');
                }
            });

            // دکمه حذف
            deleteBtn.addEventListener('click', () => {
                checklist.removeChild(itemWrapper);
                activateLastAddButton();
            });

            itemWrapper.appendChild(colInput);
            itemWrapper.appendChild(colAdd);
            itemWrapper.appendChild(colDelete);
            checklist.appendChild(itemWrapper);
            input.focus();
            itemIndex++; // افزایش ایندکس برای نام یکتا
        }

        function activateLastAddButton() {
            const items = checklist.querySelectorAll('.row');
            if (items.length === 0) {
                createItem();
                return;
            }
            const lastItem = items[items.length - 1];
            const addBtn = lastItem.querySelector('button.btn');
            if (addBtn) {
                addBtn.disabled = false;
                addBtn.classList.remove('btn-secondary');
                addBtn.classList.add('btn-success');
                const input = lastItem.querySelector('input');
                if (input) input.disabled = false;
            }
        }

        // ایجاد اولین آیتم هنگام بارگذاری
        createItem();


        function autoResize() {
            const lines = textarea.value.split('\n');

            // پیدا کردن طولانی‌ترین خط
            const longestLine = lines.reduce((a, b) => a.length > b.length ? a : b, '');

            // ساخت span موقت برای محاسبه عرض
            const span = document.createElement('span');
            span.style.visibility = 'hidden';
            span.style.position = 'absolute';
            span.style.whiteSpace = 'pre';
            span.style.fontFamily = 'monospace';
            span.textContent = longestLine || ' ';
            document.body.appendChild(span);

            // اعمال اندازه‌ها
            textarea.style.width = (span.offsetWidth + 20) + 'px'; // حاشیه برای اسکرول و padding
            textarea.style.height = (lines.length * 20 + 10) + 'px'; // حدوداً 20px برای هر خط

            span.remove();
        }

        function add_report(task_id) {
            report_txt = $('#report_txt').val();
            if (report_txt.length == 0) {
                alert('متن گزارش را وارد کنید ');
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    AjaxType: 'add_report',
                    TaskId: task_id,
                    ReportTxt: report_txt
                },

                function(data, status) {
                    if (data == true) {
                        add_task(task_id);
                    }
                }
            );
        }

        textarea.addEventListener('input', autoResize);
        window.addEventListener('load', autoResize);
    </script>


@endsection
