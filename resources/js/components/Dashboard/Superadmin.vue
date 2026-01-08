<template>
    <div class="col-lg-12 col-md-12">
        <!-- CARD ICON -->
        <div class="row">

            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-primary card-icon mb-4 ">
                    <div class="card-body text-center">
                        <i class="i-Add-User"></i>
                        <p class=" mt-2 mb-2">کل کاربران</p>
                        <p v-if="admin_meta_info.AllUsers != null" class="text-primary text-24 line-height-1 m-0">{{
                            admin_meta_info.AllUsers }}</p>
                        <p v-if="admin_meta_info.AllUsers == null"
                            class="text-primary text-24 line-height-1 m-0 loader-bubble loader-bubble-info"></p>

                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-icon mb-4 card-primary">
                    <div class="card-body text-center">
                        <i class="i-Add-User"></i>
                        <p class=" mt-2 mb-2">کاربران این هفته</p>
                        <p v-if="admin_meta_info.usersin7days != null" class="text-primary text-24 line-height-1 m-0">{{
                            admin_meta_info.usersin7days }}</p>
                        <p v-if="admin_meta_info.usersin7days == null"
                            class="text-primary text-24 line-height-1 m-0 loader-bubble loader-bubble-info"></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-primary card-icon mb-4 ">
                    <div class="card-body text-center">
                        <i class="i-Add-User"></i>
                        <p class=" mt-2 mb-2">کاربران ۲۴ ساعت گذشته</p>
                        <p v-if="admin_meta_info.usersin24h != null" class="text-primary text-24 line-height-1 m-0">{{
                            admin_meta_info.usersin24h }}</p>
                        <p v-if="admin_meta_info.usersin24h == null"
                            class="text-primary text-24 line-height-1 m-0 loader-bubble loader-bubble-info"></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-primary card-icon mb-4 ">
                    <div class="card-body text-center">
                        <i class="i-Business-Mens"></i>
                        <p class=" mt-2 mb-2">پرسنل مشغول به کار</p>
                        <p v-if="admin_meta_info.TotallActiveUsers != null" class="text-primary text-24 line-height-1 m-0">
                            {{
                                admin_meta_info.TotallActiveUsers }}</p>
                        <p v-if="admin_meta_info.TotallActiveUsers == null"
                            class="text-primary text-24 line-height-1 m-0 loader-bubble loader-bubble-info"></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-primary card-icon mb-4 ">
                    <div class="card-body text-center">
                        <i class="i-Notepad"></i>
                        <p class=" mt-2 mb-2">نظرات جدید</p>
                        <p v-if="admin_meta_info.UnreadCommtsCount == 0" class="text-primary text-24 line-height-1 m-0">
                            {{ admin_meta_info.UnreadCommtsCount }}</p>
                        <p v-if="admin_meta_info.UnreadCommtsCount > 0" class="text-danger text-24 line-height-1 m-0">
                            {{ admin_meta_info.UnreadCommtsCount }}</p>
                        <p v-if="admin_meta_info.UnreadCommtsCount == null"
                            class="text-primary text-24 line-height-1 m-0 loader-bubble loader-bubble-info"></p>

                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-primary card-icon mb-4 ">
                    <div class="card-body text-center">
                        <i class="i-Bell"></i>
                        <p class=" mt-2 mb-2">پیام های جدید</p>
                        <p class="text-primary text-24 line-height-1 m-0">44</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-primary card-icon mb-4 ">
                    <div class="card-body text-center">
                        <i class="i-Check"></i>
                        <p class=" mt-2 mb-2">درخواست‌ها </p>
                        <p class="text-primary text-24 line-height-1 m-0">0</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-primary card-icon mb-4 ">
                    <div class="card-body text-center">
                        <i class="i-Luggage-2"></i>
                        <p class=" mt-2 mb-2">کالاها</p>
                        <p class="text-primary text-18 line-height-1 m-0">
                            0 </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-primary card-icon mb-4 ">
                    <div class="card-body text-center">
                        <i class="i-Ambulance"></i>
                        <p class=" mt-2 mb-2">خدمات</p>
                        <p class="text-primary text-18 line-height-1 m-0">
                            {{ admin_meta_info.orders}} </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-primary card-icon mb-4 ">
                    <div class="card-body text-center">
                        <i class="i-Money-2"></i>
                        <p class=" mt-2 mb-2">موجودی سامانه</p>
                        <p class="text-primary text-18 line-height-1 m-0">
                            {{  new Intl.NumberFormat().format(admin_meta_info.owner_credit / 10)  }} تومان</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-primary card-icon mb-4 ">
                    <div class="card-body text-center">
                        <i class="i-Data-Upload"></i>
                        <p class=" mt-2 mb-2">حجم مصرفی</p>
                        <p v-if="admin_meta_info.storage_usage != null" class="text-primary text-24 line-height-1 m-0">{{
                            admin_meta_info.storage_usage }}</p>
                        <p v-if="admin_meta_info.storage_usage == null"
                            class="text-primary text-24 line-height-1 m-0 loader-bubble loader-bubble-info"></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-3">
                <div class="card card-primary card-icon mb-4 ">
                    <div class="card-body text-center">
                        <i class="i-Gear"></i>
                        <p class=" mt-2 mb-2">لایسنس های سامانه</p>
                        <p class="text-primary text-24 line-height-1 m-0">{{
                            admin_meta_info.lic_count }}</p>
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
            admin_meta_info: []
        };
    },
    mounted() {
        this.get_admin_info()

    },
    methods: {
        get_admin_info() {
            axios.post('/dashboard', {
                axios: true,
                function: 'get_admins_meta_info'
            }, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })

                .then((response) => {
                    this.admin_meta_info = response.data;
                })

        }
    },
};


</script>