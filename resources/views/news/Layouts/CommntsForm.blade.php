    <div id="comments" class="comments-area block">
        <h3 class="block-title"><span>دیدگاه ها</span></h3>

        <ul class="comments-list">
            <li>
                @if ($UserLogin != 'admin')
                    @if ($Views == null )
                        <div style="font-size: 9px;color: #7b7b7b;" class="entry-content">
                            هنوز دیدگاهی ثبت نشده است!
                        </div>
                    @else
                        @foreach ($Views as $View)
                            @if ($View->id == $View->refrence)
                                <div class="comment">
                                    <img class="comment-avatar pull-left" alt="" src="/news/images/news/user1.png">
                                    <div class="comment-body">
                                        <div class="meta-data">
                                            <span class="comment-author">
                                                @if ($View->name == null)
                                                    {{ $View->RegsterUserName }} {{ $View->RegsterUserFamily }}
                                                @else
                                                    {{ $View->name }}
                                                @endif
                                            </span>
                                            <span
                                                class="comment-date pull-right">{{ $Persian->MyPersianDate($View->created_at, true) }}</span>
                                        </div>
                                        <div class="comment-content">
                                            <p style="font-size: 9px;text-align:justify;">{{ $View->message }}</p>
                                        </div>
                                        <div class="text-left">
                                            <a style="
                                            font-size: 8px;
                                            color: #7b7b7b;
                                        " class="comment-reply" href="#">پاسخ <i class="fa fa-reply"
                                                    aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- Comments end -->
                            @else
                                <ul class="comments-reply">
                                    <li>
                                        <div class="comment">
                                            <img class="comment-avatar pull-left" alt=""
                                                src="{{ url('/') . \App\myappenv::FavIcon }}">
                                            <div class="comment-body">
                                                <div class="meta-data">
                                                    <span class="comment-author">کارپتور</span>
                                                    <span
                                                        class="comment-date pull-right">{{ $Persian->MyPersianDate($View->created_at, true) }}</span>
                                                </div>
                                                <div class="comment-content">
                                                    <p style="font-size: 9px">{{ $View->message }}</p>
                                                </div>
                                                <div class="text-left">
                                                    <a style="
                                                    font-size: 8px;
                                                    color: #7b7b7b;
                                                " class="comment-reply" href="#">پاسخ <i class="fa fa-reply"
                                                            aria-hidden="true"></i></a>
                                                </div>
                                            </div>
                                        </div><!-- Comments end -->
                                    </li>
                                </ul><!-- comments-reply end -->
                            @endif
                        @endforeach
                    @endif
                @else

                    @foreach ($Views as $View)
                        @if ($View->id == $View->refrence)
                            <form method="post">
                                @csrf
                                <div class="comment">
                                    <img class="comment-avatar pull-left" alt="" src="/news/images/news/user1.png">
                                    <div class="comment-body">
                                        <div class="meta-data">
                                            <span class="comment-author">
                                                @if ($View->name == null)
                                                    {{ $View->RegsterUserName }} {{ $View->RegsterUserFamily }}
                                                @else
                                                    {{ $View->name }}
                                                @endif
                                            </span>
                                            <span
                                                class="comment-date pull-right">{{ $Persian->MyPersianDate($View->created_at, true) }}</span>
                                        </div>
                                        <div class="comment-content">
                                            <p>{{ $View->message }} <a
                                                    href="{{ route('editComment', ['commentID' => $View->id]) }}">ویرایش</a>
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            @if ($View->Status == 1)
                                                <button type="submit" name="publish_view"
                                                    value="{{ $View->id }}">انتشار
                                                </button>
                                                <button type="submit"
                                                    style="color: red;border: none;background: border-box;"
                                                    name="Delete_view" value="{{ $View->id }}"><i
                                                        class="fa fa-ban"></i>
                                                </button>
                                            @elseif($View->Status == 100)
                                                <textarea class="form-control required-field" name="message"
                                                    id="message" placeholder="پاسخ شما" required></textarea>
                                                <button type="submit"
                                                    style="color: green;border: none;background: border-box;"
                                                    name="publish_answer" value="{{ $View->id }}"><i
                                                        class="fa fa-check"></i></button>
                                                <button style="color: red;border: none;background: border-box;"
                                                    type="submit" name="Delete_view" value="{{ $View->id }}"><i
                                                        class="fa fa-ban"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div><!-- Comments end -->
                            </form>
                        @else
                            <form method="post">
                                @csrf
                                <ul class="comments-reply">
                                    <li>
                                        <div class="comment">
                                            <img class="comment-avatar pull-left" alt=""
                                                src="{{ url('/') . \App\myappenv::FavIcon }}">
                                            <div class="comment-body">
                                                <div class="meta-data">
                                                    <span class="comment-author">
                                                        @if ($View->name == null)
                                                            {{ $View->RegsterUserName }}
                                                            {{ $View->RegsterUserFamily }}
                                                        @else
                                                            {{ $View->name }}
                                                        @endif
                                                    </span>
                                                    <span
                                                        class="comment-date pull-right">{{ $Persian->MyPersianDate($View->created_at, true) }}</span>
                                                </div>
                                                <div class="comment-content">
                                                    <p>{{ $View->message }}<a
                                                            href="{{ route('editComment', ['commentID' => $View->id]) }}">ویرایش</a>
                                                    </p>
                                                </div>

                                            </div>
                                        </div><!-- Comments end -->
                                    </li>
                                </ul><!-- comments-reply end -->
                            </form>
                        @endif
                    @endforeach
                @endif
            </li><!-- Comments-list li end -->
        </ul><!-- Comments-list ul end -->
    </div><!-- Post comment end -->
    <div style="
    margin-top: -68px;
" class="comments-form">
        <div class="col-md-12">
            <div class="col-md-3"></div>
            <div style="padding-right: 8px;margin-bottom: -15px;" class="col-md-6">
                <h3 style="font-size: 12px" class="title-normal">نظرات شما:</h3>
                <li style="
                 font-size: 8px;margin-bottom:-8px;
             "> نظرات حاوی هرگونه توهین و یا نسبت ناروا به اشخاص حقیقی و حقوقی منتشر نمی‌شود.</li>
                <li style="
                 font-size: 8px;margin-bottom:-1px;
             ">نظرات به غیر از زبان فارسی و یا غیر‌مرتبط با مطلب، منتشر نمی‌شود.</li>

            </div>
            <div class="col-md-3"></div>

        </div>


        <form method="post">
            @csrf
            <div class="row">
                @if (!\Illuminate\Support\Facades\Auth::check())
                    <div style="
                margin-bottom: -10px;
            " class="col-md-12">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="
                        margin-top: 15px;
                    ">
                            <div class="form-group">
                                <input style="padding-right: 3px" class="form-control" name="name" id="name"
                                    placeholder="نام" type="text" required>
                            </div>
                        </div><!-- Col end -->
                        <div class="col-md-3"></div>
                    </div>
                    <div style="
                margin-bottom: 5px;
            " class="col-md-12">
                        <div class="col-md-3"></div>
                        <div style="padding-left: 1px" class="col-md-3">
                            <input style="padding-right: 3px" class="form-control" name="WriterEmail" id="email"
                                placeholder="ایمیل" type="email" required>
                        </div>

                        <div style="padding-right: 1px" class="col-md-3">
                            <input style="padding-right: 3px" class="form-control" name="MobileNumber"
                                placeholder=" تلفن همراه" type="number" required>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                @else
                    <div style="
                margin-bottom: -10px;
            " class="col-md-12">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="
                        margin-top: 15px;
                    ">

                            <div class="col-md-3"></div>
                        </div>
                        <div style="
                margin-bottom: 5px;
            " class="col-md-12">
                            <div class="col-md-3"></div>
                            <div style="padding-left: 1px" class="col-md-3">
                                <p> {{ Auth::user()->Name }} {{ Auth::user()->Family }} </p>

                            </div>

                            <div style="padding-right: 1px" class="col-md-3">

                            </div>
                            <div class="col-md-3"></div>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea style="padding-right: 3px" class="form-control required-field" name="message"
                                id="message" placeholder=" متن" required></textarea>
                        </div>
                    </div><!-- Col end -->
                    <div class="col-md-3"></div>
                </div>

            </div><!-- Form row end -->
            <div class="col-md-12">
                <div class="col-md-3"></div>
                <div style="padding-right: 8px;margin-top:-15px" class="col-md-6">
                    <button style="
                height: 18px;
                border-radius: 4px;
                width: 52px;
                padding:0px;
                font-size: 10px;
                text-align: center;
                margin-top: 5px;
                float:left;
            " class="comments-btn btn btn-primary" name="view_submit" value="{{ $posts->id }}" type="submit">
                        ثبت
                    </button>
                </div>
                <div class="col-md-3"></div>

            </div>
        </form><!-- Form end -->
    </div><!-- Comments form end -->
