@php
    $Persian = new App\Functions\persian();
    
@endphp

<div class="col-lg-6 mb-6">
    <div class="card">
        <div class="card-header bg-transparent">
            <h3 class="card-title">گروه هدف </h3>
        </div>
        <form method="post">
            @csrf
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table  text-center">
                        <thead>
                            <td>نام</td>
                            <td>مسئول</td>
                            <td>وضعیت</td>
                            <td>عملیات</td>
                        </thead>
                        <tbody>
                            @foreach ($Desk->get_Project_team_UserList($ProjectID, 0) as $Person)
                                <tr>
                                    <td>
                                        {{ $Person->Name }} {{ $Person->Family }}
                                    </td>
                                    <td id="AssinedPerson_{{ $Person->UserName }}">
                                        @if ($Person->ActionOwner == null)
                                            تخصیص نشده
                                        @else
                                            {{ $Person->ActionOwnerName }} {{ $Person->ActionOwnerFamily }}
                                        @endif

                                    </td>
                                    <td id="Status_{{ $Person->UserName }}">
                                        @switch($Person->Fstatus)
                                            @case(0)
                                                در انتظار تخصیص
                                            @break

                                            @case(1)
                                                ارجاع شده
                                            @break

                                            @default
                                                نا مشخص
                                        @endswitch
                                    </td>
                                    <td id="Operation_{{ $Person->UserName }}">
                                        @switch($Person->Fstatus)
                                            @case(0)
                                                <button id="assign_{{ $Person->UserName }}" type="button"
                                                    onclick="assignwork({{ $ProjectID }},'{{ $Person->UserName }}')"
                                                    class="btn btn-primary">تخصیص</button>
                                            @break
                                        @endswitch

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </form>

        <!-- end::form -->
    </div>
</div>
<div class="col-lg-6 mb-6">
    <div class="card">
        <div class="card-header bg-transparent">
            <h3 class="card-title">گروه عملیات</h3>
        </div>
        <form method="post">
            @csrf
            <div class="card-body">
                <div class="form-row ">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table  text-center">
                                <thead>
                                    <td>نام</td>
                                    <td>انتخاب</td>
                                </thead>
                                <tbody>
                                    @foreach ($Desk->get_Project_team_UserList($ProjectID, 1) as $Person)
                                        <tr>
                                            <td>
                                                {{ $Person->Name }} {{ $Person->Family }}
                                            </td>
                                            <td>
                                                <input type="radio" id="html" class="form-control ownerItems"
                                                    name="owner" value="{{ $Person->UserName }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="ProjectTeamIndexList mc-footer">
                    <div class="row">

                    </div>
                </div>
            </div>


        </form>


        <!-- end::form -->
    </div>
</div>
<script>
    function assignwork($ProjectID, $UserName) {
        $Owner = null;
        $('input.ownerItems:radio:checked').each(function() {
            $Owner = $(this).val();

        });
        if ($Owner == null) {
            alert('لطفا از تیم عملیات فرد مورد نظر را انتخاب فرمایید');
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post('', {
                    func: 'assignwork',
                    Owner: $Owner,
                    UserName: $UserName,
                    ProjectID: $ProjectID
                },

                function(data, status) {
                    $('#AssinedPerson_'+$UserName).text(data);
                    $('#Status_'+$UserName).text('ارجاع شده');
                    $('#Operation_'+$UserName).text('');
                });

        }


    }
</script>
