<div class="modal fade" id="{{$ModalID}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">@yield('ModalTitle'.$formid)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @yield('ModalBody'.$formid)
            </div>
            <div class="modal-footer">
                @yield('Modalfooter'.$formid)
            </div>
        </div>
    </div>
</div>
