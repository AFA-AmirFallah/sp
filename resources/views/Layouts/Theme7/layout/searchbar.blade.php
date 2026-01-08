<form action="{{route('search_staff')}}" method="POST" class="dezPlaceAni">
    @csrf
    <div class="row">
        <div class="col-lg-4 col-md-6">
            <div class="form-group focused">
                <label>استعلام با کد پرستار بانک</label>
                <div class="input-group ">
                    <input type="text" class="form-control " name="code" inputmode="numeric"
                        value="{{ $code ?? '' }}" >
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="form-group focused ">
                <div class="input-group ">
                    <label>استعلام با شماره موبایل</label>
                    <input type="text" class="form-control" name="mobile" inputmode="numeric"
                        value="{{ $mobile ?? '' }}" >
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-mobile"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="form-group focused">
                <div class="input-group">
                    <label for="">استعلام مرکز خدمات دهنده</label>
                    <input type="text" class="form-control" name="center"
                        value="{{ $center ?? '' }}" >
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-home"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-2 col-md-6">
            <button type="submit" name="submit" value="search" href="browse-job-list.html"
                class="site-button btn-block">جستجو</button>
        </div>
    </div>
</form>