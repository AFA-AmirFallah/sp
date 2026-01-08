<template >
    <div class="breadcrumb">
        <h1>داشبورد</h1>
        <ul>
            <li>داشبورد همکاری</li>
        </ul>
    </div>
    <div class="row">
        <div class=" col-lg-4 col-md-4">
            <div class="navcard navcard-main card">
                <div class="card-body">
                    <div class="ul-widget__head pb-20 v-margin">
                        <div class="ul-widget__head-label">
                            <h3 class="ul-widget__head-title">
                                ارجاعات در یک نگاه
                            </h3>
                        </div>
                        <button type="button" class="btn btn-info dropdown-toggle _r_btn border-0" data-toggle="dropdown"
                            disabled aria-haspopup="true" aria-expanded="false">
                            امرزو
                        </button>
                        <div class="dropdown-menu" x-placement="bottom-start"
                            style="text-align: right; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(356px, 52px, 0px);">
                            <a class="dropdown-item ul-widget__link--font" href="#">
                                یک هفته</a>
                            <a class="dropdown-item ul-widget__link--font" href="#">
                                یک ماهه
                            </a>
                            <a class="dropdown-item ul-widget__link--font" href="#">
                                یک ساله </a>
                        </div>
                    </div>
                    <div class="ul-widget__body">
                        <div class="ul-widget1">
                            <div class="ul-widget4__item ul-widget4__users">
                                <div class="ul-widget4__pic-icon">
                                    <i class="i-Affiliate text-warning "></i>
                                </div>
                                <div class="ul-widget2__info ul-widget4__users-info">
                                    <a style="margin-right: 10px;" class="ul-widget4__title">
                                        تعداد ارجاع
                                    </a>
                                </div>
                                <div v-if="dashboard_data == []">
                                    <div style="font-size: 3px;" class="loader-bubble loader-bubble-success m-1"></div>
                                </div>
                                <div v-if="dashboard_data != []">
                                    <span class="ul-widget4__number t-font-boldest text-success">
                                        {{ dashboard_data['refers'] }}
                                    </span>
                                </div>
                            </div>
                            <div class="ul-widget4__item ul-widget4__users">
                                <div class="ul-widget4__pic-icon">
                                    <i class="i-Speach-Bubbles text-info "></i>
                                </div>
                                <div class="ul-widget2__info ul-widget4__users-info">
                                    <a style="margin-right: 10px;" class="ul-widget4__title">
                                        تعداد درخواست
                                    </a>
                                </div>
                                <div v-if="dashboard_data == []">
                                    <div style="font-size: 3px;" class="loader-bubble loader-bubble-info m-1"></div>
                                </div>
                                <div v-if="dashboard_data != []">
                                    <span class="ul-widget4__number t-font-boldest text-info">
                                        {{ dashboard_data['request'] }}
                                    </span>
                                </div>
                            </div>

                            <div class="ul-widget4__item ul-widget4__users">
                                <div class="ul-widget4__pic-icon">
                                    <i class="i-Full-Cart text-danger "></i>
                                </div>
                                <div class="ul-widget2__info ul-widget4__users-info">
                                    <a style="margin-right: 10px;" class="ul-widget4__title">
                                        تعداد قرارداد
                                    </a>
                                </div>
                                <div v-if="dashboard_data == []">
                                    <div style="font-size: 3px;" class="loader-bubble loader-bubble-warning m-1"></div>
                                </div>
                                <div v-if="dashboard_data != []">
                                    <span class="ul-widget4__number t-font-boldest text-danger">
                                        {{ dashboard_data['contract'] }}
                                    </span>
                                </div>

                            </div>

                            <div class="ul-widget4__item ul-widget4__users">
                                <div class="ul-widget4__pic-icon">
                                    <i class="i-Checkout text-success "></i>
                                </div>
                                <div class="ul-widget2__info ul-widget4__users-info">
                                    <a style="margin-right: 10px;" class="ul-widget4__title">
                                        تعداد قرارداد انجام شده
                                    </a>
                                </div>
                                <div v-if="dashboard_data == []">
                                    <div style="font-size: 3px;" class="loader-bubble loader-bubble-warning m-1"></div>
                                </div>
                                <div v-if="dashboard_data != []">
                                    <span class="ul-widget4__number t-font-boldest text-danger">
                                        {{ dashboard_data['done_contract'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-8">
            <div style="border: none;background-color: white;box-shadow: none;" class="card mb-4">
                <div class=" row card-body p-0">
                    <div class=" col-lg-4 col-md-6 col-sm-6">
                        <div class="bg-primary text-warning card card-icon mb-4">
                            <div class="card-body text-center text-white">
                                <i style="color: white;" class="i-Data-Upload"></i>
                                <p style="color: white;" class="mt-2 mb-2">درصد واریزی</p>
                                <p style="color: white;" class=" text-24 line-height-1 m-0">۵٪</p>
                            </div>
                        </div>
                    </div>

                    <div class=" col-lg-4 col-md-6 col-sm-6">
                        <div class="bg-info card card-icon mb-4">
                            <div class="card-body text-center">
                                <i style="color: white;" class="i-Add-User"></i>
                                <p style="color: white;" class=" mt-2 mb-2">تعداد ارجاع</p>
                                <p style="color: white;" class=" text-24 line-height-1 m-0">
                                <div v-if="dashboard_data == []">
                                    <div style="font-size: 3px;" class="loader-bubble loader-bubble-info m-1"></div>
                                </div>
                                <div v-if="dashboard_data != []">
                                    <span class="ul-widget4__number t-font-boldest">
                                        {{ dashboard_data['total_refers'] }}
                                    </span>
                                </div>

                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="bg-warning card card-icon mb-4">
                            <div class="card-body text-center">
                                <i class="i-Money-2"></i>
                                <p class="text-muted mt-2 mb-2"> مبلغ قابل واریز</p>
                                <p class="text-primary text-24 line-height-1 m-0">
                                <div v-if="dashboard_data == []">
                                    <div style="font-size: 3px;" class="loader-bubble loader-bubble-info m-1"></div>
                                </div>
                                <div v-if="dashboard_data != []">
                                    <span class="ul-widget4__number t-font-boldest text-info">
                                        {{ dashboard_data['UserCredit'] }} ریال
                                    </span>
                                </div>


                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card card-ecommerce-3 o-hidden mb-4">
                            <div class="d-flex flex-column flex-sm-row">
                                <div class="">
                                    <img class="card-img-left"
                                        src="https://panel.shafatel.com/storage/photos/banners/de1d48db2bf73adc611524e475891ad1b8c1f201.webp"
                                        alt="">
                                </div>
                                <div class="flex-grow-1 p-4">
                                    <h5 class="m-0">لینک ارجاع من</h5>
                                    <p class="m-0 text-small text-muted">شما می توانید با استفاده از لینک انحصاری خود ارجاع
                                        کنید</p>
                                    <p class="text-muted mt-3">شفاتل ارجاعات شما را به مراکز ارائه خدمات یا کالا ارائه نموده
                                        و تا انجام فروش یا لغو درخواست، ارجاع شما را پیگیری می نماید.</p>

                                    <div style="direction: ltr;" class="input-group mb-3">
                                        <input style="    border-top-left-radius: 0.25rem;
    border-bottom-left-radius: 0.25rem;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;" type="text" class="form-control" v-bind:value="this.affilite_id"
                                            aria-label="Recipient's username" aria-describedby="basic-addon2" readonly>
                                        <div class="input-group-append">
                                            <span style="margin-left: -69px;
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
    border-top-left-radius: 5px;
    margin-top: 3px;
    border-bottom-left-radius: 5px;
    height: 28px;
    width: 62px;
    color: white;
    z-index: 10;
    text-align: center;" class="input-group-text bg-success" v-on:click="copy_to_clipboard()"
                                                id="basic-addon2">کپی</span>
                                        </div>
                                    </div>
                                    <div class="actions">
                                        <p>در نظر داشته باشید پس از پرداخت و قطعی شدن انجام خدمت توسط مرکز انجام دهنده مبلغ
                                            به کیف پول شما واریز می گردد .</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            targetpage: '',
            affilite_id: '',
            dashboard_data: [],
        };
    },
    mounted() {
        this.load_dashboard(1)
    },
    runner() {


    },
    methods: {
        async copy_to_clipboard() {
            try {
                await navigator.clipboard.writeText('https://shafatel.com?MC=' + window.affilite_id);
                alert('آدرس همکاری کپی شد!');
            } catch ($e) {
                alert('مشکلی در کپی شدن آدرس به وجود آمده است! ');
            }
        },
        load_dashboard($duration) {
            this.targetpage = 'dashboard'
            this.affilite_id = 'https://shafatel.com?MC=' + window.affilite_id
            axios.post('', {
                axios: true,
                function: 'load_dashboard',
                duration: $duration
            }, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
                .then((response) => {
                    if (response.data.result) {
                        this.dashboard_data['refers'] = response.data.refers;
                        this.dashboard_data['request'] = response.data.request;
                        this.dashboard_data['contract'] = response.data.contract;
                        this.dashboard_data['done_contract'] = response.data.done_contract;
                        this.dashboard_data['UserCredit'] = response.data.UserCredit;
                        this.dashboard_data['total_refers'] = response.data.total_refers;
                    } else {
                        alert(response.data.msg)
                    }
                })

        }


    },
};

</script>