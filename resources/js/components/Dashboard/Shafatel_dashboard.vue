<template>
    <div class="row">
        <div class="col-lg-8 col-sm-12">
            <div id="carouselExamplePause" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExamplePause" data-slide-to="0" class=""></li>
                    <li data-target="#carouselExamplePause" data-slide-to="1" class=""></li>
                    <li data-target="#carouselExamplePause" data-slide-to="2" class=""></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <a href="https://shafatel.com/news/21">
                        <img class="d-block " style="border-radius: 5px;"
                            src="https://shafatel.com/storage/photos/theme/slider/slider10.jpg" alt="First slide">
                        </a>
                    </div>
                    <div class="carousel-item">

                        <img class="d-block" style="border-radius: 5px;"
                            src="https://panel.shafatel.com/storage/photos/theme/slider/slider11.jpg" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block" style="border-radius: 5px;"
                            src="https://panel.shafatel.com/storage/photos/theme/slider/slider12.jpg" alt="Third slide">

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-sm-12">
            <section class="mobile_space">
            </section>
            <div class="card  card-primary o-hidden mb-4 d-flex flex-column">
                <div style="font-size: 1.2rem" class="card-header-primary font-weight-bold text-white">خدمات شفاتل</div>
                <div class="card-body">
                    <div style="font-size: medium;font-weight: 600;" class="list-group">
                        <a style="border-style: none;color:#6F1E51;" href="#main_order_div"
                            v-on:click="get_service_list('1')" class="list-group-item list-group-item-action">
                            <span class="custom-font font-weight-bold"><i class="i-Doctor font-weight-bold">
                                </i></span>خدمات پزشکی در منزل <i class="i-Arrow-Back-3"
                                style="position: absolute;left: 12px;font-size: 19px;font-weight: bold;"></i>
                        </a>
                        <a style="border-style: none;color:#1B1464;" href="#main_order_div"
                            v-on:click="get_service_list('2')" class="list-group-item list-group-item-action"><i
                                class="i-Chemical-4 font-weight-bold"> </i>
                            خدمات پرستاری در منزل
                            <i class="i-Arrow-Back-3"
                                style="position: absolute;left: 12px;font-size: 19px;font-weight: bold;"></i>
                        </a>
                        <a v-on:click="get_service_list('5')" style="border-style: none;color:#5758BB;"
                            href="#main_order_div" class="list-group-item list-group-item-action"><i
                                class="i-Nurse font-weight-bold"> </i> خدمات
                            نگهداری و مراقبت درمنزل
                            <i class="i-Arrow-Back-3"
                                style="position: absolute;left: 12px;font-size: 19px;font-weight: bold;"></i>
                        </a>
                        <a v-on:click="get_service_list('3')" style="border-style: none;color:#833471;"
                            href="#main_order_div" class="list-group-item list-group-item-action"><i
                                class="i-Full-Basket font-weight-bold"> </i>
                            خدمات توانبخشی
                            <i class="i-Arrow-Back-3"
                                style="position: absolute;left: 12px;font-size: 19px;font-weight: bold;"></i>
                        </a>
                        <a v-on:click="get_service_list('4')" style="border-style: none;color: #ED4C67;"
                            href="#main_order_div" class="list-group-item list-group-item-action"><i
                                class="i-Address-Book font-weight-bold"> </i>
                            مراقبت های ویژه در منزل
                            <i class="i-Arrow-Back-3"
                                style="position: absolute;left: 12px;font-size: 19px;font-weight: bold;"></i>
                        </a>
                        <a v-on:click="get_service_list('6')" style="border-style: none;color:#1289A7;"
                            href="#main_order_div" class="list-group-item list-group-item-action"><i
                                class="i-Telephone-2 font-weight-bold"> </i>
                            خدمات
                            مشاوره
                            <i class="i-Arrow-Back-3"
                                style="position: absolute;left: 12px;font-size: 19px;font-weight: bold;"></i>
                        </a>
                        <a v-on:click="get_service_list('7')" style="border-style: none;color:#0652DD;"
                            href="#main_order_div" class="list-group-item list-group-item-action"><i
                                class="i-Hospital1 font-weight-bold"> </i>
                            خدمات
                            در بیمارستان و مراکز درمانی مراقبتی
                            <i class="i-Arrow-Back-3"
                                style="position: absolute;left: 12px;font-size: 19px;font-weight: bold;"></i>
                        </a>
                        <a style="border-style: none;color: #EE5A24;" href="https://shafatel.com/news/21"
                            class="list-group-item list-group-item-action"><i class="i-Money-2 font-weight-bold"> </i>
                            خدمات
                            اقساط
                            سلامت
                            <i class="i-Arrow-Back-3"
                                style="position: absolute;left: 12px;font-size: 19px;font-weight: bold;"></i>
                        </a>
                        <a style="border-style: none;color:#B53471;" href="#"
                            class="list-group-item list-group-item-action disabled"><i class="i-Scale font-weight-bold">
                            </i>
                            استعلام سلامت یاران
                            <i class="i-Arrow-Back-3"
                                style="position: absolute;left: 12px;font-size: 19px;font-weight: bold;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="st-seperator">

    </div>

    <div id="main_order_div" style="margin-top: 40px;" class="row">
        <div v-if="order_title" class="title-link-wrapper mb-3">
            <h2 class="title-heading"> خدمات سلامت </h2>
        </div>
        <div v-if="order_loader" style="display: flex;">
            <div style="height: 710px;border-radius: 10px;margin: 4px;" class="animated-background col-lg-4 col-xl-4">

            </div>
            <div style="height: 710px;border-radius: 10px;margin: 4px;" class="animated-background col-lg-4 col-xl-4">

            </div>
        </div>



        <div v-for="(order_item) in order_src" class="col-lg-4 col-xl-4">
            <div class="card">
                <img class="d-block w-100" v-bind:src="order_item.Pic" v-bind:alt="order_item.Cat">
                <div class="card-body">
                    <div class="ul-contact-detail__info">
                        <div class="row">
                            <div class="col-6 text-center">
                                <div class="ul-contact-detail__info-1">
                                    <span>نام خدمت</span>
                                    <h5>{{ order_item.Cat }}</h5>
                                </div>
                                <div class="ul-contact-detail__info-1">
                                    <span>محل انجام</span>
                                    <h5>منزل</h5>
                                </div>
                            </div>
                            <div class="col-6 text-center">
                                <div class="ul-contact-detail__info-1">
                                    <span>مراکز ارائه دهنده</span>
                                    <h5>۳ مرکز </h5>
                                </div>
                                <div class="ul-contact-detail__info-1">
                                    <span>مجوز مرکز ارائه دهنده </span>
                                    <h5>وزارت بهداشت </h5>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <div class="ul-contact-detail__info-1">
                                    <span> ارائه دهنده خدمت</span>
                                    <h5>{{ order_item.TitleDescription }}</h5>
                                </div>
                            </div>
                            <div class="col-12 text-center">

                                <div class="ul-contact-detail__social">
                                    <a type="button" v-bind:href="'/CustomerOrder/' + order_item.Cat"
                                        class="btn btn-success btn-block m-1 mb-3">ثبت درخواست در مرکز ارائه دهنده</a>
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
            admin_meta_info: [],
            order_loader: false,
            order_title: false,
            order_src: []

        };
    },
    mounted() {
        this.get_admin_info()
    },
    methods: {
        get_admin_info() {
            axios.post('/', {
                axios: true,
                type: 'customer',
                function: 'get_first_page_init'
            }, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
                .then((response) => {

                })
        },
        get_service_list($service_index) {
            this.order_loader = true;
            this.order_title = true;
            axios.post('/', {
                axios: true,
                type: 'customer',
                function: 'get_service_list',
                service_index: $service_index,
            }, {
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
                .then((response) => {
                    this.order_src = response.data
                    this.order_loader = false
                })
        }
    },


};


</script>