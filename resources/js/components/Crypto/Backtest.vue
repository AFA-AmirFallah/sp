<template>
    <div class="row g-4">
        <div v-for="(backtest) in backtest_arr" class="col-xl-4 col-lg-6 col-md-6">
            <div class="card">
                <div class="card-header primary-font">
                    <div class="d-flex align-items-start">
                        <div class="d-flex align-items-start">
                            <div class="avatar me-3">
                                <img v-bind:src="backtest.pic" alt="Avatar" class="rounded-circle">
                            </div>
                            <div class="me-2">
                                <h5 class="mb-1"><a href="javascript:;" class="h5 stretched-link">بک تست ۲۴ ساعته</a>
                                </h5>
                                <div class="client-info d-flex align-items-center text-nowrap">
                                    <h6 class="mb-0 me-1">نام نماد:</h6>
                                    <span>{{ backtest.curency }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="ms-auto">
                            <div class="dropdown zindex-2">
                                <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="javascript:void(0);"> بررسی </a></li>
                                    <li><a class="dropdown-item" href="javascript:void(0);"> اجرای مجدد</a></li>
                                    <li> <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-grid-alt"></i>
                                            اجرای ربات</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item text-danger" href="javascript:void(0);"><i
                                                class="bx bx-trash"></i> حذف بک تست</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center flex-wrap">
                        <div class="bg-lighter p-2 rounded me-auto mb-3">
                            <h6 class="mb-1">مبلغ شروع </h6>
                            <h6 class="mb-1">{{ backtest.OpenPrice }}<span class="text-body fw-normal"> تتر</span></h6>
                        </div>
                        <div>
                            
                        </div>
                        <img v-if="backtest.C1HourPercent > 0 || backtest.C2HourPercent > 0 || backtest.C4HourPercent > 0" src="https://finoward.com/storage/photos/winner.png" style="width: 100px;" alt="winner">
                        <div class="text-end mb-3">
                            <h6 class="mb-1">زمان شروع </h6>
                            <h6 class="mb-1"><span class="text-body fw-normal">{{ backtest.created_at }}</span></h6>
                        </div>
                    </div>
                </div>
                <div class="card-body border-top">
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-1"> رشد در 5 دقیقه: </h6>
                        <span style="direction: ltr;" v-if="backtest.C5MuinPercent == null"
                            class="badge bg-label-warning ms-auto">هنوز فعال نشده</span>
                        <span style="direction: ltr;" v-if="backtest.C5MuinPercent != null && backtest.C5MuinPercent >= 0"
                            class="badge bg-label-success ms-auto">{{ backtest.C5MuinPercent }}%</span>
                        <span style="direction: ltr;" v-if="backtest.C5MuinPercent != null && backtest.C5MuinPercent < 0"
                            class="badge bg-label-danger ms-auto">{{ backtest.C5MuinPercent }}% </span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-1"> رشد در 15 دقیقه: </h6>
                        <span style="direction: ltr;" v-if="backtest.C15MuinPercent == null"
                            class="badge bg-label-warning ms-auto">هنوز فعال نشده</span>
                        <span style="direction: ltr;"
                            v-if="backtest.C15MuinPercent != null && backtest.C15MuinPercent >= 0"
                            class="badge bg-label-success ms-auto">{{ backtest.C15MuinPercent }}%</span>
                        <span style="direction: ltr;" v-if="backtest.C15MuinPercent != null && backtest.C15MuinPercent < 0"
                            class="badge bg-label-danger ms-auto">{{ backtest.C15MuinPercent }}% </span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-1"> رشد در 30 دقیقه: </h6>
                        <span style="direction: ltr;" v-if="backtest.C30MuinPercent == null"
                            class="badge bg-label-warning ms-auto">هنوز فعال نشده</span>
                        <span style="direction: ltr;"
                            v-if="backtest.C30MuinPercent != null && backtest.C30MuinPercent >= 0"
                            class="badge bg-label-success ms-auto">{{ backtest.C30MuinPercent }}%</span>
                        <span style="direction: ltr;" v-if="backtest.C30MuinPercent != null && backtest.C30MuinPercent < 0"
                            class="badge bg-label-danger ms-auto">{{ backtest.C30MuinPercent }}% </span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-1"> رشد در 1 ساعت: </h6>
                        <span style="direction: ltr;" v-if="backtest.C1HourPercent == null"
                            class="badge bg-label-warning ms-auto">هنوز فعال نشده</span>
                        <span style="direction: ltr;" v-if="backtest.C1HourPercent != null && backtest.C1HourPercent >= 0"
                            class="badge bg-label-success ms-auto">{{ backtest.C1HourPercent }}%</span>
                        <span style="direction: ltr;" v-if="backtest.C1HourPercent != null && backtest.C1HourPercent < 0"
                            class="badge bg-label-danger ms-auto">{{ backtest.C1HourPercent }}% </span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-1"> رشد در ۲ ساعت: </h6>
                        <span style="direction: ltr;" v-if="backtest.C2HourPercent == null"
                            class="badge bg-label-warning ms-auto">هنوز فعال نشده</span>
                        <span style="direction: ltr;" v-if="backtest.C2HourPercent != null && backtest.C2HourPercent >= 0"
                            class="badge bg-label-success ms-auto">{{ backtest.C2HourPercent }}%</span>
                        <span style="direction: ltr;" v-if="backtest.C2HourPercent != null && backtest.C2HourPercent < 0"
                            class="badge bg-label-danger ms-auto">{{ backtest.C2HourPercent }}% </span>

                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-1"> رشد در ۴ ساعت: </h6>
                        <span style="direction: ltr;" v-if="backtest.C4HourPercent == null"
                            class="badge bg-label-warning ms-auto">هنوز فعال نشده</span>
                        <span style="direction: ltr;" v-if="backtest.C4HourPercent != null && backtest.C4HourPercent >= 0"
                            class="badge bg-label-success ms-auto">{{ backtest.C4HourPercent }}%</span>
                        <span style="direction: ltr;" v-if="backtest.C4HourPercent != null && backtest.C4HourPercent < 0"
                            class="badge bg-label-danger ms-auto">{{ backtest.C4HourPercent }}% </span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="mb-1"> رشد در ۲۴ ساعت: </h6>
                        <span style="direction: ltr;" v-if="backtest.C24HourPercent == null"
                            class="badge bg-label-warning ms-auto">هنوز فعال نشده</span>
                        <span style="direction: ltr;"
                            v-if="backtest.C24HourPercent != null && backtest.C24HourPercent >= 0"
                            class="badge bg-label-success ms-auto">{{ backtest.C24HourPercent }}%</span>
                        <span style="direction: ltr;" v-if="backtest.C24HourPercent != null && backtest.C24HourPercent < 0"
                            class="badge bg-label-danger ms-auto">{{ backtest.C24HourPercent }}% </span>

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
            backtest_arr: []

        };
    },
    mounted() {

        this.get_my_backtest()
    },
    methods: {
        get_my_backtest() {
            {

                axios.post('/analyzer/vue', {
                    axios: true,
                    function: 'get_my_backtest'
                }, {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                })

                    .then((response) => {
                        console.log(response.data)
                        response.data.forEach((item, index) => {
                            this.backtest_arr.push(item);
                        })

                    })

            }
        }

    },
};



</script>