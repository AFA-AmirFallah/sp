<!--
<div style="border-color: #b53471;border-style: groove;" class="pwa_service_card_body card-body">
    <div class="pwa-card-title card-title">خدمات شفاتل</div>
    @if (!Request::is('/'))
        <div id="showbtn" class="pwa_Box_Open_Butom">
            <i class="i-Arrow-Down" onclick="ShowRouteBoxitem()"></i>
        </div>
        <div id="hidebtn" class="pwa_Box_Open_Butom">
            <i class="i-Arrow-Up" onclick="HideRouteBoxitem()"></i>
        </div>
    @endif
    <hr class="CustomerServiceCardHr">
    <div style="margin-right: -3px" class="main_item_nested">
        <a href="{{ url('/') }}/CustomerServices" class=" btn btn-icon rounded-circle m-2">
            <img class="line-btn" src="{{ asset('assets/images/healthcareservices.png') }}"
                alt=" خدمات درمانی و مراقبتی">
            خدمات درمانی و مراقبتی
        </a>

    </div>
    <div style="margin-right: -3px" class="main_item_nested">
        <a href="https://www.shafatel.com/product/اجاره-فروش-دستگاه-اکسیژن-ساز/" class=" btn btn-icon rounded-circle m-2">
            <img class="line-btn" src="{{ asset('assets/images/wheelchair.png') }}"
                alt="اجاره دستگاه اکسیژن ساز">
           اجاره و فروش دستگاه اکسیژن ساز
        </a>

    </div>
    <div class="main_item_nested">
        <button type="button" class="btn btn-icon rounded-circle m-1">
            <img class="line-btn" src="{{ asset('assets/images/capsul.png') }}" alt="">
        </button>
        ارسال دارو و لوازم مصرفی
    </div>
    <div name="ssss" class="main_item_nested">
        <a href="{{ url('/') }}/ShowCats/6/1" class="btn btn-icon rounded-circle m-1">
            <img class="line-btn" src="{{ asset('assets/images/moshavereh.png') }}" alt="خدمات مشاوره">
            خدمات مشاوره
        </a>
    </div>


</div>
-->


@if (!Request::is('/'))
    <script>
        var toggler = document.getElementsByClassName("main_item_nested");
        var showbtn = document.getElementById('showbtn');
        var hidebtn = document.getElementById('hidebtn');
        hidebtn.style.display = "none";
        for (i = 0; i < toggler.length; i++) {
            toggler[i].style.display = "none";
        }

        function ShowRouteBoxitem() {
            var showbtn = document.getElementById('showbtn');
            var hidebtn = document.getElementById('hidebtn');
            showbtn.style.display = "none";
            hidebtn.style.display = "block";
            var toggler = document.getElementsByClassName("main_item_nested");
            for (i = 0; i < toggler.length; i++) {
                toggler[i].style.display = "block";
            }


        }

        function HideRouteBoxitem() {
            var showbtn = document.getElementById('showbtn');
            var hidebtn = document.getElementById('hidebtn');
            hidebtn.style.display = "none";
            showbtn.style.display = "block";
            var toggler = document.getElementsByClassName("main_item_nested");
            for (i = 0; i < toggler.length; i++) {
                toggler[i].style.display = "none";
            }


        }
    </script>
@endif
