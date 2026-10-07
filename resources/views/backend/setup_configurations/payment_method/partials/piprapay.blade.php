<form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST" id="piprapay-form">
    @csrf
    <input type="hidden" name="payment_method" value="piprapay">
    <div class="form-group row">
        <input type="hidden" name="types[]" value="PIPRAPAY_BASE_URL">
        <div class="col-md-4">
            <label class="col-from-label">{{ translate('PipraPay Base URL') }}</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="PIPRAPAY_BASE_URL" id="piprapay_base_url"
                value="{{ env('PIPRAPAY_BASE_URL', 'https://pay.nur-lab.com') }}"
                placeholder="https://pay.nur-lab.com" required>
        </div>
    </div>
    <div class="form-group row">
        <input type="hidden" name="types[]" value="PIPRAPAY_API_KEY">
        <div class="col-md-4">
            <label class="col-from-label">{{ translate('PipraPay API Key') }}</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="PIPRAPAY_API_KEY" id="piprapay_api_key"
                value="{{ env('PIPRAPAY_API_KEY') }}"
                placeholder="{{ translate('Enter PipraPay API Key') }}" required>
        </div>
    </div>
    <div class="form-group mb-0 text-right">
        <button type="button" class="btn btn-sm btn-info" onclick="testPiprapayConnection(this)">
            <i class="las la-vial"></i> {{ translate('Test Connection') }}
        </button>
        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
    </div>
</form>

<script>
function testPiprapayConnection(btn) {
    var baseUrl = $('#piprapay_base_url').val();
    var apiKey = $('#piprapay_api_key').val();

    if (!baseUrl || !apiKey) {
        AIZ.plugins.notify('warning', '{{ translate("Please fill in both Base URL and API Key first.") }}');
        return;
    }

    var originalText = $(btn).html();
    $(btn).prop('disabled', true).html('<i class="las la-spinner la-spin"></i> {{ translate("Testing...") }}');

    $.post('{{ route("piprapay.test") }}', {
        _token: '{{ csrf_token() }}',
        base_url: baseUrl,
        api_key: apiKey
    }, function(data) {
        $(btn).prop('disabled', false).html(originalText);
        if (data.status) {
            AIZ.plugins.notify('success', data.message);
            if (data.redirect_url) {
                window.open(data.redirect_url, '_blank');
            }
        } else {
            AIZ.plugins.notify('danger', data.message);
        }
    }).fail(function() {
        $(btn).prop('disabled', false).html(originalText);
        AIZ.plugins.notify('danger', '{{ translate("Connection test request failed.") }}');
    });
}
</script>
