<form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
    @csrf
    <input type="hidden" name="payment_method" value="piprapay">
    <div class="form-group row">
        <input type="hidden" name="types[]" value="PIPRAPAY_BASE_URL">
        <div class="col-md-4">
            <label class="col-from-label">{{ translate('PipraPay Base API URL') }}</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="PIPRAPAY_BASE_URL"
                value="{{ env('PIPRAPAY_BASE_URL', 'https://pay.nur-lab.com/api') }}"
                placeholder="https://pay.nur-lab.com/api" required>
        </div>
    </div>
    <div class="form-group row">
        <input type="hidden" name="types[]" value="PIPRAPAY_SECRET_KEY">
        <div class="col-md-4">
            <label class="col-from-label">{{ translate('PipraPay Secret Key') }}</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="PIPRAPAY_SECRET_KEY"
                value="{{ env('PIPRAPAY_SECRET_KEY') }}"
                placeholder="{{ translate('PipraPay Secret Key') }}" required>
        </div>
    </div>
    <div class="form-group mb-0 text-right">
        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
    </div>
</form>
