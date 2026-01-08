<template >
    <div v-if="show_flag">
        <div v-if="PatientSet">
            <div class="col-lg-12 col-md-12">
                <div class="row">
                    <div v-if="targetpage != 'Profile'" class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="gotopage('/UserProfile/')">
                            <div class="navcard navcard-main card  card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i class="i-Love-User"></i>
                                    <p class=" mt-2 mb-2"> مشخصات بیمار </p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div v-if="targetpage == 'Profile'" class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="gotopage('/UserProfile/')">
                            <div class="navcard active-navcard card  card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i style="color: white;" class="i-Love-User"></i>
                                    <p class="text-white mt-2 mb-2"> مشخصات بیمار </p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <div class="navcard navcard-main card card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i class="i-Mail"></i>
                                <p class=" mt-2 mb-2"> پیامک </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="BothSideCall()">
                            <div class="navcard navcard-main card card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i class="i-Telephone"></i>
                                    <p class=" mt-2 mb-2"> تماس دو طرفه </p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div v-if="targetpage == 'MakeSmartInvoice'" class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="gotopage('/MakeSmartInvoice/')">
                            <div class="navcard active-navcard card card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i style="color: white;" class="i-Diploma"></i>
                                    <p class="text-white mt-2 mb-2"> صورت حساب هوشمند</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div v-if="targetpage != 'MakeSmartInvoice'" class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="gotopage('/MakeSmartInvoice/')">
                            <div class="navcard navcard-main card card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i class="i-Diploma"></i>
                                    <p class=" mt-2 mb-2"> صورت حساب هوشمند</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div v-if="targetpage != 'PatShiftManage'" class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="gotopage('/PatShiftManage/')">
                            <div class="navcard navcard-main card card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i class="i-Bar-Chart-4"></i>
                                    <p class=" mt-2 mb-2">شیفت ها</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div v-if="targetpage == 'PatShiftManage'" class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="gotopage('/PatShiftManage/')">
                            <div class="navcard active-navcard card card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i style="color: white;" class="i-Bar-Chart-4"></i>
                                    <p class="text-white mt-2 mb-2">شیفت ها</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div v-if="targetpage != 'RentDevice'" class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="gotopage('/RentDevice/')">
                            <div class="navcard navcard-main card card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i class="i-Fluorescent"></i>
                                    <p class=" mt-2 mb-2">اجاره تجهیزات</p>

                                </div>
                            </div>
                        </a>
                    </div>
                    <div v-if="targetpage == 'RentDevice'" class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="gotopage('/RentDevice/')">
                            <div class="navcard active-navcard card card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i style="color: white;" class="i-Fluorescent"></i>
                                    <p class="text-white mt-2 mb-2">اجاره تجهیزات</p>

                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <div class="navcard navcard-main card card-icon mb-4 ">
                            <div class="card-body text-center">
                                <i class="i-Full-Basket"></i>
                                <p class=" mt-2 mb-2">فروش کالا</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="newpage('/filemanager?type=file&amp;usertraget=')">
                            <div class="navcard navcard-main card card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i class="i-Folder"></i>
                                    <p class=" mt-2 mb-2"> فولدر بیمار</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div v-if="targetpage != 'PatDoc'" class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="gotopage('/PatDoc/')">
                            <div class="navcard navcard-main card card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i class="i-File-Love"></i>
                                    <p class=" mt-2 mb-2">پرونده الکترونیک</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div v-if="targetpage == 'PatDoc'" class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="gotopage('/PatDoc/')">
                            <div class="navcard active-navcard card card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i style="color: white;" class="i-File-Love"></i>
                                    <p class="text-white mt-2 mb-2">پرونده الکترونیک</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div v-if="targetpage != 'Workflow'" class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="gotopage('/Workflow/')">
                            <div class="navcard navcard-main card card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i class="i-Over-Time"></i>
                                    <p class=" mt-2 mb-2">گردش کار</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div v-if="targetpage == 'Workflow'" class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="gotopage('/Workflow/')">
                            <div class="navcard active-navcard card card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i style="color: white;" class="i-Over-Time"></i>
                                    <p class="text-white mt-2 mb-2">گردش کار</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div v-if="targetpage != 'UserReport'" class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="gotopage('/UserReport/')">
                            <div class="navcard navcard-main card card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i class="i-Dollar"></i>
                                    <p class=" mt-2 mb-2">امور مالی</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div v-if="targetpage == 'UserReport'" class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="gotopage('/UserReport/')">
                            <div class="navcard active-navcard card card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i style="color: white;" class="i-Dollar"></i>
                                    <p class="text-white mt-2 mb-2">امور مالی</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-md-3 col-sm-3">
                        <a v-on:click="removeuser()">
                            <div class="navcard card navcard-main  card-danger card-icon mb-4 ">
                                <div class="card-body text-center">
                                    <i class="i-Close text-danger"></i>
                                    <p class=" mt-2 mb-2">فراموشی بیمار</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!PatientSet && PatientRegister">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                            <div class="pt-4">
                                <div class="row">
                                    <h4 class="col-md-4 text-white">جستجوی بیمار</h4>
                                    <input v-on:keyup.enter="loaduserssearch()" type="text" v-model="searchtext"
                                        class="form-control form-control-rounded col-md-4 ml-3 mr-3"
                                        placeholder="جستجوی بیمار">
                                    <button type="button" v-on:click="loaduserssearch()"
                                        class="btn btn-warning btn-small m-1">جستجو</button>

                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" v-on:click="set_to_register()" class="btn btn-success">پذیرش
                                            بیمار</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="ul-contact-list-body">
                                <div class="ul-contact-main-content">
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        New Contact</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="form-group">

                                                            <input type="text" class="form-control" placeholder="Name....">
                                                        </div>
                                                        <div class="form-group">

                                                            <input type="email" class="form-control" id="exampleInputEmail1"
                                                                aria-describedby="emailHelp" placeholder="Enter email....">

                                                        </div>

                                                        <div class="form-group">

                                                            <input type="text" class="form-control"
                                                                id="exampleInputPassword1" placeholder="phone....">
                                                        </div>
                                                        <div class="form-group">

                                                            <textarea class="form-control" id="exampleFormControlTextarea1"
                                                                rows="3" placeholder="notes...."></textarea>
                                                        </div>


                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save
                                                        changes</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ul-contact-content">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="tab-content ul-contact-list-table--label" id="nav-tabContent">

                                                    <div class="tab-pane fade show active" id="list-home" role="tabpanel"
                                                        aria-labelledby="list-home-list">

                                                        <div class=" text-left ">
                                                            <div class="table-responsive">
                                                                <div id="contact_list_table_wrapper"
                                                                    class="dataTables_wrapper container-fluid dt-bootstrap4 no-footer">

                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <table id="contact_list_table"
                                                                                class="display table table-borderless ul-contact-list-table dataTable no-footer"
                                                                                style="width: 100%;" role="grid"
                                                                                aria-describedby="contact_list_table_info">
                                                                                <thead>
                                                                                    <tr class="border-bottom" role="row">
                                                                                        <th class="sorting_asc" tabindex="0"
                                                                                            aria-controls="contact_list_table"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-sort="ascending"
                                                                                            aria-label="Name: activate to sort column descending"
                                                                                            style="width: 290px;">نام</th>
                                                                                        <th class="sorting" tabindex="0"
                                                                                            aria-controls="contact_list_table"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="Email: activate to sort column ascending"
                                                                                            style="width: 347px;">ایمیل</th>
                                                                                        <th class="sorting" tabindex="0"
                                                                                            aria-controls="contact_list_table"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="Phone: activate to sort column ascending"
                                                                                            style="width: 326px;">شماره
                                                                                            همراه
                                                                                        </th>
                                                                                        <th class="sorting" tabindex="0"
                                                                                            aria-controls="contact_list_table"
                                                                                            rowspan="1" colspan="1"
                                                                                            aria-label="Action: activate to sort column ascending"
                                                                                            style="width: 170px;">عملیات
                                                                                        </th>
                                                                                    </tr>
                                                                                </thead>

                                                                                <tbody>

                                                                                    <h6 style="text-align: center;margin-top: 30px;"
                                                                                        v-if="!user_arr.length">نتیجه ای
                                                                                        برای
                                                                                        نمایش وجود ندارد!</h6>
                                                                                    <tr v-for="(useritem) in user_arr"
                                                                                        role="row" class="odd">
                                                                                        <td class="sorting_1">
                                                                                            <img v-if="useritem.avatar != null"
                                                                                                class="rounded-circle m-0 avatar-sm-table "
                                                                                                v-bind:src="useritem.avatar">
                                                                                            <img v-if="useritem.avatar == null"
                                                                                                class="rounded-circle m-0 avatar-sm-table "
                                                                                                src="/assets/images/avtar/useravatar.png">
                                                                                            {{ useritem.Name }} {{
                                                                                                useritem.Family }}
                                                                                        </td>
                                                                                        <td>{{ useritem.Email }}</td>
                                                                                        <td>{{ useritem.MobileNo }}</td>
                                                                                        <td>
                                                                                            <button
                                                                                                v-on:click="selectuser(useritem.UserName)"
                                                                                                class="btn btn-success">انتخاب</button>

                                                                                        </td>

                                                                                    </tr>


                                                                                </tbody>

                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!PatientSet && !PatientRegister">
            <div class="row">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card tab2-card">
                                    <div class="card-header gradient-purple-indigo 0-hidden pb-80">
                                        <h5 class="text-white"> <i class="header-icon i-Add-User"></i> پذیرش بیمار</h5>
                                        <div class="col-sm-10">
                                            <button type="submit" v-on:click="set_to_search()"
                                                class="btn btn-success">جستجوی
                                                بیمار</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" class="needs-validation user-add" novalidate="">
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade active show" id="account" role="tabpanel"
                                                    aria-labelledby="account-tab">
                                                    <div class="form-group row">
                                                        <label for="validationCustom0"
                                                            class="col-xl-3 col-md-4"><span>*</span>
                                                            جنسیت</label>
                                                        <div class="col-xl-9 col-sm-8">
                                                            <div
                                                                class="form-group m-checkbox-inline mb-0 custom-radio-ml d-flex radio-animated">
                                                                <label style="margin-left: 10px" class="d-block"
                                                                    for="edo-ani1">
                                                                    <input v-model="sex" v-bind:value="'m'"
                                                                        class="radio_animated" type="radio"><i
                                                                        style="font-size: 20px" class="i-Business-Man"></i>
                                                                    مرد
                                                                </label>
                                                                <label class="d-block" for="edo-ani2">
                                                                    <input v-model="sex" v-bind:value="'f'"
                                                                        class="radio_animated" type="radio"> <i
                                                                        style="font-size: 20px"
                                                                        class="i-Business-Woman"></i>
                                                                    زن
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="validationCustom0"
                                                            class="col-xl-3 col-md-4"><span>*</span>
                                                            نام</label>
                                                        <input class="form-control col-xl-8 col-md-7" v-model="ADDName"
                                                            required="" type="text">
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="validationCustom1"
                                                            class="col-xl-3 col-md-4"><span>*</span>نام خانوادگی</label>
                                                        <input class="form-control col-xl-8 col-md-7" v-model="ADDFamily"
                                                            type="text" required="">
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="validationCustom2"
                                                            class="col-xl-3 col-md-4"><span>*</span>
                                                            شماره موبایل</label>
                                                        <input class="form-control col-xl-8 col-md-7"
                                                            v-model="ADDMobileNumber" type="text" required="">
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="validationCustom2"
                                                            class="col-xl-3 col-md-4"><span>*</span>
                                                            کدملی</label>
                                                        <input class="form-control col-xl-8 col-md-7" v-model="ADDMelliID"
                                                            type="text" required="">

                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="validationCustom2"
                                                            class="col-xl-3 col-md-4"><span></span>
                                                            ایمیل</label>
                                                        <input class="form-control col-xl-8 col-md-7"
                                                            v-model="ADDMailAddress" type="text" required="">


                                                    </div>
                                                </div>

                                            </div>
                                            <div class="pull-right">
                                                <button v-if="submitdisable" type="button" disabled
                                                    class="btn btn-primary">ذخیره</button>
                                                <button v-if="!submitdisable" type="button" v-on:click="register()"
                                                    class="btn btn-primary">ذخیره</button>
                                            </div>
                                        </form>
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
        BothSideCall() {
            axios.post('/ajax', {
                axios: true,
                function: 'BothSideCall',
                AjaxType: 'BothSideCall',
                target_user: this.username,
            }, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })

                .then((response) => {

                    alert(response.data)

                })
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
            window.open(direction + this.username, 'newwindow', 'width=1000,height=600');
        },
        gotopage(direction) {

            window.location.href = direction + this.username
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