<template>
    <div class="row">
        <!-- Gamification Card -->
            <div  :class="{ 'nested': !isnested }" class="col-md-6 col-lg-4 mb-4 order-0">
                <div class="card h-100">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h3 class="card-title mb-2">نتایج بررسی اندیکاتورها
                        </h3>
                        <span class="d-block mb-4 text-nowrap primary-font">بررسی و تحلیل شده با
                            اندیکاتور RSI </span>
                        <h2 style="text-align: center" class="text-warning">درحال تست</h2>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-end">
                            <div class="col-6">
                                <div style="display: flex;align-items: baseline;">
                                    <span class="badge bg-label-danger"> </span>
                                    <h1 class="display-6 text-primary mb-2 pt-3 pb-2"></h1>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <img src="https://finoward.com/storage/photos/RSI.png" style="height: 133px;" width="100%"
                                    class="rounded-start" alt="View Sales">
                            </div>

                        </div>
                        <div style="text-align: center;">
                            <button style="margin: 10px;" type="button" v-on:click="RSI" class="btn btn-primary">
                                <i class="tf-icons bx bx-user"></i> بررسی با اندیکاتور RSI
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div  :class="{ 'nested': !isnested }" class="col-md-6 col-lg-4 mb-4 order-0">
                <div class="card h-100">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h3 class="card-title mb-2">نتایج بررسی اندیکاتورها
                        </h3>
                        <span class="d-block mb-4 text-nowrap primary-font">بررسی و تحلیل شده با
                            اندیکاتور MACD</span>
                        <h2 style="text-align: center" class="text-warning">درحال تست</h2>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-end">
                            <div class="col-6">
                                <div style="display: flex;align-items: baseline;">
                                    <span class="badge bg-label-danger"> </span>
                                    <h1 class="display-6 text-primary mb-2 pt-3 pb-2"></h1>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <img src="https://finoward.com/storage/photos/MACD.jpeg" style="height:133px;" width="100%"
                                    class="rounded-start" alt="View Sales">
                            </div>

                        </div>
                        <div style="text-align: center;">
                            <button style="margin: 10px;" type="button" v-on:click="SMI('down100')" class="btn btn-primary">
                                <i class="tf-icons bx bx-user"></i> شکست روند
                            </button>

                            <button type="button" v-on:click="SMI('up100')" class="btn btn-primary">
                                <i class="tf-icons bx bx-user"></i> شکست مقاوت
                            </button>
                        </div>

                    </div>
                </div>
            </div>
            <div  :class="{ 'nested': !isnested }" class="col-md-6 col-lg-4 mb-4 order-0">
                <div class="card h-100">
                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                        <h3 class="card-title mb-2">نتایج بررسی اندیکاتورها
                        </h3>
                        <span class="d-block mb-4 text-nowrap primary-font">بررسی و تحلیل شده با معتبر ترین
                            اندیکاتورها</span>
                        <h2 style="text-align: center" class="text-warning">درحال تست</h2>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-end">
                            <div class="col-6">
                                <div style="display: flex;align-items: baseline;">
                                    <span class="badge bg-label-danger"> </span>
                                    <h1 class="display-6 text-primary mb-2 pt-3 pb-2"></h1>
                                </div>
                            </div>
                            <div class="col-12 text-end">
                                <img src="https://finoward.com/storage/photos/admin/app/undertest.png" width="100%"
                                    class="rounded-start" alt="View Sales">
                            </div>

                        </div>
                        <button type="button" class="btn btn-primary">
                            <i class="tf-icons bx bx-user"></i> بررسی با اندیکاتور SMI
                        </button>
                    </div>
                </div>
            </div>
    </div>
    <div :class="{ 'nested': isnested }">
        <div style="text-align: left;margin-bottom: 10px;">
            <button type="button" v-on:click="backtomain()" class="btn btn-primary left"><i class='bx bx-up-arrow-alt'></i>
                بازگشت</button>
        </div>
        <div id="mainanalyzer" class="card">
            <div class="card-datatable table-responsive pt-0">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer">
                    <div class="card-header flex-column flex-md-row">
                        <div class="head-label text-center">
                            <h5 class="card-title mb-0"> {{ tableheeader }} </h5>
                        </div>

                    </div>

                    <table class="datatables-basic table table-bordered dataTable no-footer dtr-column"
                        id="DataTables_Table_0" role="grid">
                        <thead>
                            <tr role="row">

                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    aria-label="نام: فعال سازی نمایش به صورت صعودی">نام ارز</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    aria-label="تاریخ: فعال سازی نمایش به صورت صعودی">شاخص RSI</th>
                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                    aria-label="تاریخ: فعال سازی نمایش به صورت صعودی">عملیات </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="odd" v-for="(feild) in tableRows">
                                <td><img style="width: 30px;" v-bind:src="feild.pic" alt=""> {{ feild.MainName }} <span  v-if="feild.candate != null" class="badge bg-label-success me-1">بک تست</span></td>
                                <td>{{ feild.f4 }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu" style="">
                                            <a class="dropdown-item" target="_blank"
                                                v-bind:href="'/analyze/' + feild.MainName"><i class="bx bx-line-chart"></i>
                                                بررسی</a>
                                            <a class="dropdown-item" v-on:click="backtest(feild.MainName)"><i
                                                    class="bx bx-run"></i> اجرای بک تست</a>

                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">نمایش
                                1
                                تا 7 از 100 ردیف</div>
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

            tableRows: [],
            isnested: true,
            f4: '',
            changeRate: '',
            tableheeader: '',
            counter: 1,
        };
    },
    mounted() {


    },
    methods: {
        backtomain() {
            this.isnested = true;
            this.tableRows = [];
        },
        backtest(CoinName) {
            axios.post('/analyzer/vue', {
                axios: true,
                function: 'backtest',
                CoinName: CoinName
            }, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })

                .then((response) => {
                    if (response.data) {
                        alert('بک تست فعال شد');
                    } else {
                        alert('مشکلی در فعال سازی بک تست به وجود آمده است. لطفا با پشتیبانی تماس بگیرید!');
                    }

                })
        },
        RSI() {
            {
                this.isnested = false;
                this.tableheeader = 'نتیجه بررسی اندیکاتور RSI'
                this.tableRows = []
                axios.post('/analyzer/vue', {
                    axios: true,
                    function: 'RSI'
                }, {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                })

                    .then((response) => {
                        response.data.forEach((item, index) => {
                            this.counter++;
                            this.tableRows.push({ MainName: item.MainName, changeRate: item.changeRate, pic: item.pic, f4: item.f4, candate: item.candate });
                        })

                    })

            }
        }, SMI(parameter) {
            {
                this.tableRows = [];
                this.isnested = false;
                if (parameter == 'up100') {
                    this.tableheeader = 'نتیجه بررسی اندیکاتور MACD شکست مقاوت'
                }
                if (parameter == 'down100') {
                    this.tableheeader = 'نتیجه بررسی اندیکاتور MACD شکست روند'
                }

                axios.post('/analyzer/vue', {
                    axios: true,
                    function: 'SMI',
                    type: parameter
                }, {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                })

                    .then((response) => {
                        response.data.forEach((item, index) => {
                            this.counter++;
                            this.tableRows.push({ MainName: item.MainName, changeRate: item.changeRate, pic: item.pic, f4: item.f4, candate: item.candate });
                        })

                    })

            }
        },
        greet() {
            alert('salam this is my app')
        },
        beforetest() {
            alert('my before test')
        }

    },
};


</script>