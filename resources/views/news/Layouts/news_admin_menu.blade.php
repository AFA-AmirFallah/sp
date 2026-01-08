<div style="text-align: left">
    <button type="button" class="btn bg-white _r_btn border-0" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <span class="_dot _inline-dot bg-primary"></span>
        <span class="_dot _inline-dot bg-primary"></span>
        <span class="_dot _inline-dot bg-primary"></span>
    </button>
    <div class="dropdown-menu " style="text-align: right" x-placement="bottom-start">
        <a class="dropdown-item ul-widget__link--font" href="{{ route('NewsList') }}">لیست محتوا</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item ul-widget__link--font {{$active_menu == 'MakeNews' ?   'active' :  ''}} " href="{{ route('MakeNews') }}">افزودن محتوا</a>
        <a class="dropdown-item ul-widget__link--font" {{$active_menu == 'MakeTagCover' ?   'active' :  ''}} href="{{ route('MakeTagCover') }}">افزودن پوشش
        </a>
        <a class="dropdown-item ul-widget__link--font" href="{{ route('NewsList', ['ListType' => 'news']) }}">لیست خبر ها
        </a>
        <a class="dropdown-item ul-widget__link--font"  href="{{ route('NewsList', ['ListType' => 'banners']) }}">لیست بنر ها
        </a>
        <a class="dropdown-item ul-widget__link--font" href="{{ route('NewsList', ['ListType' => 'hotnews']) }}">لیست خبرهای داغ
        </a>
        <a class="dropdown-item ul-widget__link--font" href="{{ route('NewsList', ['ListType' => 'ads']) }}">لیست تبلیغات
        </a>
        <a class="dropdown-item ul-widget__link--font" href="{{ route('NewsList', ['ListType' => 'covers']) }}">لیست پوشش ها
        </a>
        
        <a class="dropdown-item ul-widget__link--font" href="{{ route('MenuWorks') }}">مدیریت منوها
        </a>
    </div>
</div>