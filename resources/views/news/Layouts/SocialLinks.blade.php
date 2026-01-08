<div style="text-align:center;background-color: #950316;color:white" >
    اگر این مطلب را می‌پسندید از طریق لینک‌های زیر در شبکه‌های اجتماعی به سایر علاقه مندان همرسانی کنید!
</div>
<div style="
padding-top: 0px;
margin-top: 7px;
" class="share-items clearfix">
    <ul style="text-align:center" class="unstyled footer-social">
        <li>
            <a title="Rss" href="#">
                <span class="social-icon"><i class="fa fa-rss"></i></span>
            </a>
            <a title="Facebook"  href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}" target="_blank">
                <span class="social-icon"><i class="fa fa-facebook"></i></span>
            </a>
            <a title="Twitter" href="http://twitter.com/share?url={{ url()->current() }}&text={{  $posts->Titel ?? ''  }}&hashtags=simplesharebuttons" target="_blank" >
                <span class="social-icon"><i class="fa fa-twitter"></i></span>
            </a>
            <a title="Google+" href="https://plus.google.com/share?url={{ url()->current() }}" target="_blank">
                <span class="social-icon"><i class="fa fa-google-plus"></i></span>
            </a>

            <a title="Linkdin" href="http://www.linkedin.com/shareArticle?mini=true&url={{ url()->current() }}" target="_blank">
                <span class="social-icon"><i class="fa fa-linkedin"></i></span>
            </a>
            <a target="_blank" title="whatsapp" href="whatsapp://send?text={{ url()->current()}}">
                <span class="social-icon"><i class="fa fa-whatsapp"></i></span>
            </a>
            <a title="pinterest" href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());">
                <span class="social-icon"><i class="fa fa-pinterest"></i></span>
            </a>
            <a title="instagram" href="https://www.instagram.com/?url={{ url()->current() }}" target="_blank">
                <span class="social-icon"><i class="fa fa-instagram"></i></span>
            </a>
        </li>
    </ul>
</div><!-- Share items end -->
