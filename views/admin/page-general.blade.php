<div class="box">
    <div class="box-header"><h4 class="box-title">Cấu hình chung</h4></div>
    <div class="box-content">
        <div class="row">
            {!! $form->html(); !!}
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
