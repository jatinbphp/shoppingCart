<h5 class="mb-2 ft-medium">Delivery Method</h5>
<div class="row mb-4">
    <div class="col-12 col-lg-12 col-xl-12 col-md-12">
        <div class="panel-group" id="payaccordion">
            <div class="accordion">
                <article class="panel panel-default border">
                    <input id="delivey_method_f" type="radio" name="delivery_method" value="3-5 WORKING DAYS" checked>
                    <label class="article-lable" for="delivey_method_f">
                        <h5>3-5 WORKING DAYS</h5>
                    </label>
                    <!-- <div id="delivey_method_f" class="panel-collapse collapse show" aria-labelledby="pay" data-parent="#payaccordion">
                        <div class="panel-body">
                            3-5 WORKING DAYS
                        </div>
                    </div> -->
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