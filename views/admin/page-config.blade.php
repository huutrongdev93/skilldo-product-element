<form id="js_product_element_form" method="post">
    {!! Admin::loading() !!}
    <input type="hidden" name="module" id="module" class="form-control" value="{!! $section !!}" required>
    <div class="ui-title-bar__group">
        <h1 class="ui-title-bar__title">Product Element - {!! $tabsData[$section]['label'] !!}</h1>
    </div>

    {!! $tabs !!}

    <div role="tabpanel">
        <!-- Tab panes -->
        <div class="tab-content mb-3">
            @if(isset($tabsData[$section]['callback']) && Str::isStatic($tabsData[$section]['callback']))
                @php
                    call_user_func($tabsData[$section]['callback'], $tabsData[$section], $section);
                @endphp
            @endif

            @if(isset($tabsData[$section]['class']))
                @php $tabsData[$section]['class']::pageConfig(); @endphp
            @endif
        </div>
    </div>

    {!! Admin::button('blue', ['icon' => Admin::icon('save'), 'text' => trans('button.save'), 'type' => 'submit']) !!}
</form>
<script type="text/javascript">
    $(function() {
        $('#js_product_element_form').submit(function() {

            let loading = $('.loading');

            let data = $(this).serializeJSON();

            data.action     =  'Product_Element_Ajax::saveGeneral';

            loading.show();

            request.post(ajax, data)
                .then(function(response) {

                    loading.hide();

                    SkilldoMessage.response(response);

                    if (response.status === 'success') {

                        if(data.module === 'general') {
                            window.location.reload();
                        }
                    }
                })
                .catch(function (error) {

                    loading.hide();

                    SkilldoMessage.response(error.message);
                })

            return false;
        });
    });
</script>