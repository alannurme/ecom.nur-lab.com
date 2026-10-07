<form class="form-horizontal" action="{{ route('payment_method.update') }}" method="POST">
    @csrf
    <input type="hidden" name="payment_method" value="piprapay">
    <div class="form-group row">
        <input type="hidden" name="types[]" value="PIPRAPAY_API_KEY">
        <div class="col-md-4">
            <label class="col-from-label">{{ translate('PIPRAPAY API KEY') }}</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="PIPRAPAY_API_KEY"
                value="{{ env('PIPRAPAY_API_KEY') }}"
                placeholder="{{ translate('PIPRAPAY API KEY') }}" required>
        </div>
    </div>
    <div class="form-group row">
        <input type="hidden" name="types[]" value="PIPRAPAY_SECRET_KEY">
        <div class="col-md-4">
            <label class="col-from-label">{{ translate('PIPRAPAY SECRET KEY') }}</label>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="PIPRAPAY_SECRET_KEY"
                value="{{ env('PIPRAPAY_SECRET_KEY') }}"
                placeholder="{{ translate('PIPRAPAY SECRET KEY') }}" required>
        </div>
    </div>
    <div class="form-group mb-0 text-right">
        <button type="submit" class="btn btn-sm btn-primary">{{ translate('Save') }}</button>
    </div>
</form>
