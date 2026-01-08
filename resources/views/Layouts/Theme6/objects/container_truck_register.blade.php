<div class="contact-form">
    <form id="contactForm" novalidate="true">
        <div class="row">
            <div class="col-lg-12 col-sm-6">
                <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control" required=""
                        data-error="نام خود را وارد کنید" placeholder="نام شما">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-6">
                <div class="form-group">
                    <input type="text" name="phone_number" id="phone_number" required=""
                        data-error="تلفن خود را وارد کنید" class="form-control" placeholder="تلفن">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-lg-12 col-sm-6">
                <div class="form-group">
                    <input type="text" name="msg_subject" id="msg_subject" class="form-control" required=""
                        data-error="موضوع خود را وارد کنید" placeholder="موضوع">
                    <div class="help-block with-errors"></div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12">
                <div class="form-group">
                    <textarea name="message" class="form-control" id="message" cols="30" rows="5" required=""
                        data-error="پیام خود را بنویسید" placeholder="پیام شما"></textarea>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12">
                <button type="submit" class="custom-btn2 page-btn disabled"
                    style="pointer-events: all; cursor: pointer;">
                    ارسال
                </button>
                <div id="msgSubmit" class="h3 text-center hidden"></div>
                <div class="clearfix"></div>
            </div>
        </div>
    </form>
</div>
