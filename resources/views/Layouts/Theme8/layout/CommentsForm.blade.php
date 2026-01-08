<div class="insert-comment mb-5">
    <h3 class="text-gray mb-4">دیدگاهتان را بنویسید</h3>

    <form method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="holder-input mb-sm-3 mb-2">
                    <label class="mb-2">
                        نام و نام خانوادگی
                    </label>
                    <input required name="name" id="name" placeholder="نام و نام خانوادگی" value="">

                </div>
            </div>
            <div class="col-md-6">
                <div class="holder-input mb-sm-3 mb-2">
                    <label class="mb-2">
                        تلفن همراه
                    </label>
                    <input name="MobileNumber" placeholder=" تلفن همراه" type="number" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="holder-input mb-sm-3 mb-2">
                    <label class="mb-2">
                        ایمیل
                    </label>
                    <input name="WriterEmail" id="email" placeholder="ایمیل" type="email" required>
                    <div class="err text-error"></div>
                </div>
            </div>
            <div class="col-12">
                <div class="holder-input mb-sm-3 mb-2">
                    <label>دیدگاه</label>
                    <textarea rows="5" name="message" placeholder="دیدگاه"></textarea>
                    <div class="err text-error"></div>
                    <li> نظرات حاوی هرگونه
                        توهین و یا نسبت ناروا به اشخاص حقیقی و حقوقی منتشر نمی‌شود.</li>
                    <li>نظرات به غیر از زبان
                        فارسی و یا غیر‌مرتبط با مطلب، منتشر نمی‌شود.</li>

                </div>
            </div>
        </div>
        <div class="text-right">
            <button class="btn-submit" name="view_submit" value="{{ $posts->id }}" type="submit">
                ارسال دیدگاه
            </button>
        </div>
    </form>
</div>

<div class="comments mb-5">

    @if ($UserLogin != 'admin')
        @if ($Views == null)
            <div class="comment p-3">
                <div class="comment-info">
                    <div style="height: 100px;text-align:center;vertical-align: baseline;padding-top: 35px;"
                        class="font-semibold bg-white  text-gray-dark mb-2">
                        هنوز دیدگاهی ثبت نشده است!
                    </div>
                </div>
            </div>
        @else
            @foreach ($Views as $View)
                @if ($View->id == $View->refrence)
                    <div class="comment-holder mb-3">
                        <div class="user-icon">
                            <svg class="w-100" viewBox="0 0 77 77" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M38.4969 0C43.71 0 48.6787 1.04012 53.2214 2.91985L53.2903 2.95118C57.9709 4.89983 62.1877 7.75075 65.7154 11.2846C69.2618 14.8248 72.119 19.0667 74.0739 23.7848C75.9599 28.3213 76.9937 33.2963 76.9937 38.5031C76.9937 43.7163 75.9536 48.685 74.0739 53.2277L74.0426 53.2966C72.0876 57.9771 69.243 62.194 65.7091 65.7216C62.1689 69.268 57.927 72.1252 53.2089 74.0802C48.6725 75.9661 43.6975 77 38.4906 77C33.2838 77 28.3087 75.9599 23.7661 74.0802L23.6971 74.0488C19.0166 72.1002 14.7997 69.2492 11.2721 65.7216L11.2784 65.7091C7.73196 62.1627 4.87477 57.927 2.91985 53.2214C1.04012 48.6787 0 43.71 0 38.4969C0 33.2837 1.04012 28.315 2.91985 23.7723L2.95118 23.7034C4.89983 19.0229 7.75075 14.806 11.2784 11.2784H11.2846C14.8311 7.73196 19.0667 4.87477 23.7786 2.91985C28.315 1.04012 33.2838 0 38.4969 0ZM10.6455 59.1927L10.7959 59.105C14.4927 57.0435 24.1169 56.3606 28.1145 53.5723C28.409 53.1337 28.7223 52.4946 29.0293 51.7991C29.4867 50.7527 29.9065 49.6061 30.1697 48.8291C29.0544 47.5133 28.0957 46.0283 27.1809 44.5684L24.1545 39.75C23.0518 38.0959 22.4753 36.5921 22.4377 35.3515C22.4189 34.7687 22.5192 34.2424 22.7385 33.7725C22.964 33.2837 23.3087 32.8765 23.7786 32.5632C23.9979 32.4128 24.2423 32.2875 24.5117 32.1935C24.3112 29.5807 24.2423 26.2912 24.3676 23.5342C24.4302 22.8826 24.5618 22.2247 24.7372 21.573C25.5142 18.8098 27.4503 16.5855 29.8501 15.0566C31.1722 14.2108 32.6258 13.5779 34.1359 13.1518C35.1008 12.8761 33.3151 9.80592 34.3113 9.69941C39.1172 9.20441 46.893 13.5967 50.2514 17.2246C51.9307 19.0417 52.9896 21.454 53.2152 24.6433L53.0272 32.5005C53.8668 32.7574 54.4057 33.29 54.6187 34.1484C54.8631 35.1071 54.5999 36.448 53.7853 38.2838C53.7728 38.3152 53.754 38.3528 53.7352 38.3841L50.2828 44.0671C49.0171 46.1536 47.7263 48.2527 46.0534 49.9006C46.21 50.1261 46.3667 50.3454 46.5171 50.5647C47.2 51.5673 47.8893 52.5698 48.7727 53.4658C48.8041 53.4971 48.8291 53.5284 48.8479 53.5598C52.8204 56.3668 62.4885 57.0498 66.1978 59.1175L66.3482 59.2052C70.6528 53.4282 73.1967 46.2664 73.1967 38.5094C73.1967 28.929 69.3119 20.251 63.0336 13.9789C56.7678 7.69436 48.0898 3.80959 38.5094 3.80959C28.929 3.80959 20.251 7.69436 13.9789 13.9727C7.6881 20.2384 3.80332 28.9165 3.80332 38.4969C3.80332 46.2539 6.34722 53.4157 10.6455 59.1927Z"
                                    fill="#85888E" />
                            </svg>
                        </div>
                        <div class="comment p-3">
                            <div class="comment-info">
                                <div class="font-semibold text-gray-dark mb-2">
                                    @if ($View->name == null)
                                        {{ $View->RegsterUserName }} {{ $View->RegsterUserFamily }}
                                    @else
                                        {{ $View->name }}
                                    @endif
                                </div>
                                <div class="text-sm text-gray mb-3">
                                    {{ $Persian->MyPersianDate($View->created_at) }}
                                </div>
                                <div class="comment-text text-gray">
                                    <p>
                                        {{ $View->message }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <ul class="comments-reply">
                        <li>
                            <div class="comment">
                                <img class="comment-avatar pull-left" alt=""
                                    src="{{ url('/') . \App\myappenv::FavIcon }}">
                                <div class="comment-body">
                                    <div class="meta-data">
                                        <span class="comment-author">{{ \App\myappenv::CenterName }}</span>
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
                                "
                                            class="comment-reply" href="#">پاسخ <i class="fa fa-reply"
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
                    <div class="comment-holder mb-3">
                        <div class="user-icon">
                            <svg class="w-100" viewBox="0 0 77 77" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M38.4969 0C43.71 0 48.6787 1.04012 53.2214 2.91985L53.2903 2.95118C57.9709 4.89983 62.1877 7.75075 65.7154 11.2846C69.2618 14.8248 72.119 19.0667 74.0739 23.7848C75.9599 28.3213 76.9937 33.2963 76.9937 38.5031C76.9937 43.7163 75.9536 48.685 74.0739 53.2277L74.0426 53.2966C72.0876 57.9771 69.243 62.194 65.7091 65.7216C62.1689 69.268 57.927 72.1252 53.2089 74.0802C48.6725 75.9661 43.6975 77 38.4906 77C33.2838 77 28.3087 75.9599 23.7661 74.0802L23.6971 74.0488C19.0166 72.1002 14.7997 69.2492 11.2721 65.7216L11.2784 65.7091C7.73196 62.1627 4.87477 57.927 2.91985 53.2214C1.04012 48.6787 0 43.71 0 38.4969C0 33.2837 1.04012 28.315 2.91985 23.7723L2.95118 23.7034C4.89983 19.0229 7.75075 14.806 11.2784 11.2784H11.2846C14.8311 7.73196 19.0667 4.87477 23.7786 2.91985C28.315 1.04012 33.2838 0 38.4969 0ZM10.6455 59.1927L10.7959 59.105C14.4927 57.0435 24.1169 56.3606 28.1145 53.5723C28.409 53.1337 28.7223 52.4946 29.0293 51.7991C29.4867 50.7527 29.9065 49.6061 30.1697 48.8291C29.0544 47.5133 28.0957 46.0283 27.1809 44.5684L24.1545 39.75C23.0518 38.0959 22.4753 36.5921 22.4377 35.3515C22.4189 34.7687 22.5192 34.2424 22.7385 33.7725C22.964 33.2837 23.3087 32.8765 23.7786 32.5632C23.9979 32.4128 24.2423 32.2875 24.5117 32.1935C24.3112 29.5807 24.2423 26.2912 24.3676 23.5342C24.4302 22.8826 24.5618 22.2247 24.7372 21.573C25.5142 18.8098 27.4503 16.5855 29.8501 15.0566C31.1722 14.2108 32.6258 13.5779 34.1359 13.1518C35.1008 12.8761 33.3151 9.80592 34.3113 9.69941C39.1172 9.20441 46.893 13.5967 50.2514 17.2246C51.9307 19.0417 52.9896 21.454 53.2152 24.6433L53.0272 32.5005C53.8668 32.7574 54.4057 33.29 54.6187 34.1484C54.8631 35.1071 54.5999 36.448 53.7853 38.2838C53.7728 38.3152 53.754 38.3528 53.7352 38.3841L50.2828 44.0671C49.0171 46.1536 47.7263 48.2527 46.0534 49.9006C46.21 50.1261 46.3667 50.3454 46.5171 50.5647C47.2 51.5673 47.8893 52.5698 48.7727 53.4658C48.8041 53.4971 48.8291 53.5284 48.8479 53.5598C52.8204 56.3668 62.4885 57.0498 66.1978 59.1175L66.3482 59.2052C70.6528 53.4282 73.1967 46.2664 73.1967 38.5094C73.1967 28.929 69.3119 20.251 63.0336 13.9789C56.7678 7.69436 48.0898 3.80959 38.5094 3.80959C28.929 3.80959 20.251 7.69436 13.9789 13.9727C7.6881 20.2384 3.80332 28.9165 3.80332 38.4969C3.80332 46.2539 6.34722 53.4157 10.6455 59.1927Z"
                                    fill="#85888E" />
                            </svg>
                        </div>
                        <div class="comment p-3">
                            <div class="comment-info">
                                <div class="font-semibold text-gray-dark mb-2">
                                    @if ($View->name == null)
                                        {{ $View->RegsterUserName }} {{ $View->RegsterUserFamily }}
                                    @else
                                        {{ $View->name }}
                                    @endif
                                </div>
                                <div class="text-sm text-gray mb-3">
                                    {{ $Persian->MyPersianDate($View->created_at, true) }}
                                </div>
                                <div class="comment-text text-gray">
                                    <p>
                                        {{ $View->message }}
                                    </p>
                                </div>
                            </div>
                            <div class="replay">
                                @if ($View->Status == 1)
                                    <button type="submit" name="publish_view" value="{{ $View->id }}">انتشار
                                    </button>
                                    <button type="submit" style="color: red;border: none;background: border-box;"
                                        name="Delete_view" value="{{ $View->id }}"><i class="fa fa-ban"></i>
                                    </button>
                                @elseif($View->Status == 100)
                                    <textarea class="form-control required-field" name="message" id="message" placeholder="پاسخ شما" required></textarea>
                                    <button type="submit" style="color: green;border: none;background: border-box;"
                                        name="publish_answer" value="{{ $View->id }}"><i
                                            class="fa fa-check"></i></button>
                                    <button style="color: red;border: none;background: border-box;" type="submit"
                                        name="Delete_view" value="{{ $View->id }}"><i class="fa fa-ban"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        @endforeach
    @endif
</div>
