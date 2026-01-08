<style>
.menu_bar {}



@media screen and (max-width: 800px) {
    .menu_bar p {
        display: none;
    }

    .menu_bar .col {
        padding-right: 0px;
        padding-left: 0px;
    }

    .menu_bar .navcard {
        border-radius: 50%;
        width: 60px;
        height: 60px;
    }

    .menu_bar .card-body {
        padding-top: 10px;
    }
}
</style>
<template >
    <div class="container" v-if="show_flag">
        <div v-if="PatientSet">
            <div class="menu_bar row">
                <div v-if="targetpage != 'Dashboard'" class="col">
                    <a v-on:click="gotopage('/')">
                        <div class="navcard navcard-main card  card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i class="i-Bar-Chart"></i>
                                <p class=" mt-2 mb-2"> داشبورد کاربری </p>
                            </div>
                        </div>
                    </a>
                </div>
                <div v-if="targetpage == 'Dashboard'" class="col">
                    <a v-on:click="gotopage('/')">
                        <div class="navcard active-navcard card  card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i style="color: white;" class="i-Bar-Chart"></i>
                                <p class="text-white mt-2 mb-2"> داشبورد کاربری </p>
                            </div>
                        </div>
                    </a>
                </div>

                <div v-if="targetpage != 'CustomerOrder'" class="col">
                    <a v-on:click="gotopage('/CustomerOrder')">
                        <div class="navcard navcard-main card card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i class="i-Full-Basket text-success"></i>
                                <p class=" mt-2 mb-2 text-success">درخواست خدمات</p>
                            </div>
                        </div>
                    </a>
                </div>                
                <div v-if="targetpage != 'CustomerOrder'" class="col">
                    <a v-on:click="gotopage('/Product')">
                        <div class="navcard navcard-main card card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i class="i-Full-Basket text-success"></i>
                                <p class=" mt-2 mb-2 text-success">فروشگاه</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div v-if="targetpage == 'CustomerOrder'" class="col">
                    <a v-on:click="gotopage('/CustomerOrder')">
                        <div class="navcard active-navcard card card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i style="color: white;" class="i-Full-Basket"></i>
                                <p class="text-white mt-2 mb-2">درخواست خدمات</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div v-if="targetpage == 'Invoice'" class="col">
                    <a v-on:click="gotopage('/Invoice/')">
                        <div class="navcard active-navcard card card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i style="color: white;" class="i-Diploma"></i>
                                <p class="text-white mt-2 mb-2"> صورت حساب‌ها</p>
                            </div>
                        </div>
                    </a>
                </div>

                <div v-if="targetpage != 'Invoice'" class="col">
                    <a v-on:click="gotopage('/Invoice/')">
                        <div class="navcard navcard-main card card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i class="i-Diploma"></i>
                                <p class=" mt-2 mb-2"> صورت حساب‌ها</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div v-if="targetpage != 'PatShiftDone'" class="col">
                    <a v-on:click="gotopage('/PatShiftDone/')">
                        <div class="navcard navcard-main card card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i class="i-Bar-Chart-4"></i>
                                <p class=" mt-2 mb-2">شیفت‌ها</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div v-if="targetpage == 'PatShiftDone'" class="col">
                    <a v-on:click="gotopage('/PatShiftDone/')">
                        <div class="navcard active-navcard card card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i style="color: white;" class="i-Bar-Chart-4"></i>
                                <p class="text-white mt-2 mb-2">شیفت‌ها</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div v-if="targetpage != 'RentDevice'" class="col">
                    <a v-on:click="gotopage('/RentDevice/')">
                        <div class="navcard navcard-main card card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i class="i-Fluorescent"></i>
                                <p class=" mt-2 mb-2">اجاره تجهیزات</p>

                            </div>
                        </div>
                    </a>
                </div>
                <div v-if="targetpage == 'RentDevice'" class="col">
                    <a v-on:click="gotopage('/RentDevice/')">
                        <div class="navcard active-navcard card card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i style="color: white;" class="i-Fluorescent"></i>
                                <p class="text-white mt-2 mb-2">اجاره تجهیزات</p>

                            </div>
                        </div>
                    </a>
                </div>

                <div v-if="targetpage != 'PatDoc'" class="col">
                    <a v-on:click="gotopage('/PatDoc/')">
                        <div class="navcard navcard-main card card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i class="i-File-Love"></i>
                                <p class=" mt-2 mb-2">پرونده الکترونیک</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div v-if="targetpage == 'PatDoc'" class="col">
                    <a v-on:click="gotopage('/PatDoc/')">
                        <div class="navcard active-navcard card card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i style="color: white;" class="i-File-Love"></i>
                                <p class="text-white mt-2 mb-2">پرونده الکترونیک</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </div>
    <hr>
</template>
<script>
import axios from 'axios';
export default {
    data() {
        return {
            show_flag: true,
            username: '',
            page_username: '',
            PatientRegister: true,
            PatientSet: false,
            searchtext: '',
            ADDName: '',
            ADDFamily: '',
            ADDMobileNumber: '',
            ADDMelliID: '',
            ADDMailAddress: '',
            submitdisable: false,
            sex: 'f',
            targetpage: '',
            user_arr: []
        };
    },
    mounted() {
        this.runer()
    },
    methods: {
        register() {
            if (this.ADDName != '' && this.ADDName.length > 2) {
                if (this.ADDFamily != '' && this.ADDFamily.length > 2) {
                    if (this.ADDMobileNumber != '' && this.ADDMobileNumber.length == 11) {
                        this.submitdisable = true;
                        if (this.ADDMelliID == '' || this.ADDMelliID.length == 10) {
                            axios.post('/login', {
                                axios: true,
                                function: 'add_patient',
                                Name: this.ADDName,
                                Family: this.ADDFamily,
                                MobileNo: this.ADDMobileNumber,
                                MelliID: this.ADDMelliID,
                                sex: this.sex,
                                MailAddress: this.ADDMailAddress
                            }, {
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded'
                                }
                            })
                                .then((response) => {
                                    if (response.data.result) {
                                        this.submitdisable = false;
                                        this.selectuser(response.data.data);
                                    } else {
                                        this.submitdisable = false;
                                        alert(response.data.msg)
                                    }
                                })
                        } else {
                            alert('کد ملی وارد شده اشتباه است!');
                        }
                    } else {
                        alert('لطفا شماره موبایل بیمار را به طور صحیح وارد نمایید!');
                    }
                } else {
                    alert('لطفا نام خانوادگی بیمار را مشخص فرمایید!');
                }

            } else {
                alert('لطفا نام بیمار را مشخص فرمایید!');
            }

        },
        set_to_search() {
            this.PatientRegister = true;
        },
        set_to_register() {
            this.PatientRegister = false;
        },
        removeuser() {
            axios.post('/ajax', {
                axios: true,
                function: 'PatientSetter',
                AjaxType: 'PatientSetter',
                UserName: 'null',
            }, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })

                .then((response) => {
                    this.admin_meta_info = response.data;
                    if (response.data) {
                        this.user_arr = []
                        this.PatientSet = false;
                        window.location.href = '/patdashboard'

                    } else {
                        alert('عملیات با خطا مواجه شد!')
                    }
                })
        },
        selectuser(username) {
            axios.post('/ajax', {
                axios: true,
                function: 'PatientSetter',
                AjaxType: 'PatientSetter',
                UserName: username,
            }, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
                .then((response) => {
                    this.admin_meta_info = response.data;
                    if (response.data == 'nok') {
                        this.user_arr = []
                        alert('فیلدی در دیتابیس یافته نشد!')
                    } else {
                        this.user_arr = response.data;
                        this.username = username;
                        this.PatientSet = true;

                    }
                })
        },
        newpage(direction) {
            window.open(direction, 'newwindow', 'width=1000,height=600');
        },
        gotopage(direction) {

            window.location.href = direction
        },
        runer() {

            this.username = window.main_username.trim()
            this.page_username = window.page_username.trim()
            this.targetpage = window.targetpage

            if (this.username != this.page_username) {

                this.show_flag = false
            } else {
                this.show_flag = true
            }
            if (this.username != '') {
                this.PatientSet = true

            } else {
                this.PatientSet = false
            }
        },
        loaduserssearch() {
            if (this.searchtext.length > 1) {
                axios.post('/ajax', {
                    axios: true,
                    function: 'get_admins_meta_info',
                    AjaxType: 'WorkerSearch',
                    InputString: this.searchtext,
                }, {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                })

                    .then((response) => {
                        this.admin_meta_info = response.data;
                        if (response.data == 'nok') {
                            this.user_arr = []
                            alert('فیلدی در دیتابیس یافته نشد!')
                        } else {
                            this.user_arr = response.data;
                            console.log(response.data);

                        }
                    })

            } else {
                alert('تعداد کارکتر وارد شده برای جستجو مناسب نیست!')
            }
        }

    },
};

</script>