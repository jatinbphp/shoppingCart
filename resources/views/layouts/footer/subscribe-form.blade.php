<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
    <div class="footer_widget">
        <h4 class="widget_title">Subscribe</h4>
        <p>Receive updates, hot deals, discounts sent straignt in your inbox daily</p>
        <div class="foot-news-last">
        <div class="input-group">              
            <div class="form-group">
                <div class="input-group">
                    {!! Form::text('subscriber_email', old('subscriber_email'), ['id' => 'subscriber_email', 'class' => 'form-control' . ($errors->has('subscriber_email') ? ' is-invalid' : ''), 'placeholder' => 'Email Address']) !!}
                    <div class="input-group-append">
                        {!! Form::button('<i class="lni lni-arrow-right"></i>', [
                            'type' => 'button',
                            'id' => 'submit-subscriber-form',
                            'class' => 'input-group-text bg-dark b-0 text-light',
                            'data-url' => route('subscriber.form.submit')
                        ]) !!}
                    </div>
                </div>
                <div id="subscribe_message"></div>
            </div>
        </div>
        <div class="address mt-3">
            <h5 class="fs-sm">Secure Payments</h5>
            <div class="scr_payment">
                <img src="{{url('assets/website/images/card.png')}}" class="img-fluid" alt="" />
            </div>
        </div>
    </div>
</div>