<h5 class="mb-2 ft-medium">Delivery Method</h5>
<div class="row mb-4">
    <div class="col-12 col-lg-12 col-xl-12 col-md-12">
        <div class="panel-group" id="payaccordion">
            <div class="accordion">
                <article class="panel panel-default border">
                    <input id="delivey_method_f" type="radio" name="delivery_method" value="Next Day Delivery (order before 12pm)" checked>
                    <label class="article-lable" for="delivey_method_f">
                        <h5>Next Day Delivery (order before 12pm)</h5>
                    </label>
                </article>
            </div>
        </div>
    </div>
</div>
<h5 class="mb-2 ft-medium">Leave a message</h5>
<div class="row mb-4">
    <div class="col-12 col-lg-12 col-xl-12 col-md-12">
        <div class="form-group">
            <small>If you would like to add a comment about your order, please write it in the field below.</small>
            {!! Form::textarea('notes', null, ['class' => 'form-control']) !!}
        </div>
    </div>
</div>