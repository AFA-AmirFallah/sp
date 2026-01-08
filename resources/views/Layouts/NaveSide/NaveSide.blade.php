@if (!\Illuminate\Support\Facades\Auth::check())
    @include('Layouts.NaveSide.sidebar_customer')
@elseif(Auth()->user()->Role == \App\myappenv::role_SuperAdmin)
    <!-- Super admin  -->
    @include('Layouts.NaveSide.NaveSideAdmin')
@elseif(Auth()->user()->Role == \App\myappenv::role_admin)
    @include('Layouts.NaveSide.sidebar_admin')
@elseif(Auth()->user()->Role == \App\myappenv::role_ShopOwner)
    @include('Layouts.NaveSide.NaveSideShopOwner')
@elseif(Auth()->user()->Role == \App\myappenv::role_Accounting)
    @include('Layouts.NaveSide.sidebar_Mali')
@elseif(Auth()->user()->Role == \App\myappenv::role_worker)
    @if (\App\myappenv::Lic['hiring'])
        @include('Layouts.NaveSide.sidebar_worker_hiring')
    @else
        @include('Layouts.NaveSide.sidebar_worker')
    @endif
@elseif(Auth()->user()->Role == \App\myappenv::role_customer)
    @include('Layouts.NaveSide.sidebar_customer')
@elseif(Auth()->user()->Role == \App\myappenv::role_ShopAdmin)
    @include('Layouts.NaveSide.NaveSideShopAdmin')
@elseif(Auth()->user()->Role == \App\myappenv::role_callcenter)
    @include('Layouts.NaveSide.NaveSideCallCenter')
@endif
