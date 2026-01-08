@php
    $Persian = new App\Functions\persian();
@endphp
@extends('Layouts.Theme6.Layout.mian_layout')
@section('MainTitle')
@endsection
@section('OG')
    <meta property="og:locale" content="fa_IR" />
    <meta property="og:type" content="Product" />
    <meta property="og:title" content="" />
    <meta property="og:url" content="{{ \App\myappenv::SiteAddress }}/{{ Request::path() }}" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="600" />
    <meta name="twitter:card" content="summary_large_image" />
@endsection
@section('content')



        <!-- Start Contact -->
        <div style="margin-top: 37px;" class="contact-section pt-100">
            <div class="container">
                <div class="section-title text-center">
                    <h2>تماس با ما</h2>
                    <p>برای ثبت آگهی و خرید و فروش خودروی سنگین با ما در تماس باشید</p>
                    <span>تماس با ما</span>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="single-contact">
                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                            <h3>آدرس</h3>
                            <p>ایران ، استان تهران ،  اسلامشهر</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="single-contact">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                            <h3>ایمیل</h3>
                            <a href="mailto:info@rayandiesel.co"><p>info@rayandiesel.co</p></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 offset-md-3 offset-lg-0">
                        <div class="single-contact">
                            <i class="fa fa-phone" aria-hidden="true"></i>
                            <h3>تلفن</h3>
                            <a href="tel:02141484"><p>021-41484</p></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Contact -->

        <!-- Start Contact Form -->
        <div class="contact-form-section ptb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-map">
                            <div class="map">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12981.068995509331!2d51.2627094!3d35.571795!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3f9207007801b5ed%3A0xd10632b2f8b5a60c!2z2LHYp9uM2KfZhiDYr9uM2LLZhA!5e0!3m2!1sen!2s!4v1719227777885!5m2!1sen!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-form">
                            <form id="contactForm">
								<div class="row">
									<div class="col-lg-12 col-sm-6">
										<div class="form-group">
											<input type="text" name="name" id="name" class="form-control" required data-error="نام خود را وارد کنید" placeholder="نام شما">
											<div class="help-block with-errors"></div>
										</div>
									</div>
		
									<div class="col-lg-12 col-sm-6">
										<div class="form-group">
											<input type="email" name="email" id="email" class="form-control" required data-error="ایمیل خود را وارد کنید" placeholder="ایمیل شما">
											<div class="help-block with-errors"></div>
										</div>
									</div>
		
									<div class="col-lg-12 col-sm-6">
										<div class="form-group">
											<input type="text" name="phone_number" id="phone_number" required data-error="تلفن خود را وارد کنید" class="form-control" placeholder="تلفن">
											<div class="help-block with-errors"></div>
										</div>
									</div>
		
									<div class="col-lg-12 col-sm-6">
										<div class="form-group">
											<input type="text" name="msg_subject" id="msg_subject" class="form-control" required data-error="موضوع خود را وارد کنید" placeholder="موضوع">
											<div class="help-block with-errors"></div>
										</div>
									</div>
		
									<div class="col-lg-12 col-md-12">
										<div class="form-group">
											<textarea name="message" class="form-control" id="message" cols="30" rows="5" required data-error="پیام خود را بنویسید" placeholder="پیام شما"></textarea>
											<div class="help-block with-errors"></div>
										</div>
									</div>
		
									<div class="col-lg-12 col-md-12">
										<button type="submit" class="custom-btn2 page-btn">
											ارسال
										</button>
										<div id="msgSubmit" class="h3 text-center hidden"></div>
										<div class="clearfix"></div>
									</div>
								</div>
							</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Contact Form -->

@endsection
