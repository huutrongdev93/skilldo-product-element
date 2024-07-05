<div class="box mb-3">
    <div class="box-header"><h4 class="box-title">DEMO</h4></div>
    <div class="box-content">
        <div class="row">
            <img src="{!! PR_EL_PATH.'/assets/images/form-contact.png' !!}" alt="" style="height: 100px;width: auto">
        </div>
    </div>
</div>

<div class="box mb-3">
    <div class="box-header"><h4 class="box-title">TEXT</h4></div>
    <div class="box-content">
        <div class="row">
            {!! $formText->html() !!}
        </div>
    </div>
</div>

<div class="box mb-3">
    <div class="box-header"><h4 class="box-title">STYLE</h4></div>
    <div class="box-content">
        <div class="row">
            {!! $formStyle->html() !!}
        </div>
    </div>
</div>

<style>
    .select-img .checkbox img { width:50px; border:1px solid #ccc; }
    .select-img .checkbox input:checked + label img {
        border:1px solid #000;
    }
    .select-img .checkbox label span { display: none;}
</style>
