@if ($errors->any())
    <div class="card" style="position: absolute">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">{{__('error alert')}}</div>
        <div class="card-content card-content-padding">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    </div>
@endif
@if(session('error'))
    <div class="card" style="position: absolute">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">{{__('error alert')}}</div>
        <div class="card-content card-content-padding">
                <li> {{session('error')}}</li>
        </div>
    </div>
@endif
@if(session('lic_error'))
    <div class="card" style="position: absolute">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">{{__('license permission')}}</div>
        <div class="card-content card-content-padding">
            <li>{{session('lic_error')}}</li>
        </div>
    </div>
@endif
@if(session('success'))
    <div class="card" style="position: absolute">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">{{__('success alert')}}</div>
        <div class="card-content card-content-padding">
            <li>{{session('success')}}</li>
        </div>
    </div>

@endif
@if(isset($error) )
    <div class="card">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">{{__('error alert')}}</div>
        <div class="card-content card-content-padding">
            <li>{{$error}}</li>
        </div>
    </div>

@endif
@if(isset($success) )
    <div class="card">
        <div class="card-header gradient-purple-indigo 0-hidden pb-80">{{__('success alert')}}</div>
        <div class="card-content card-content-padding">
            <li>{{$success}}</li>
        </div>
    </div>

@endif



