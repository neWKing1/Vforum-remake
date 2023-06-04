<div class="mb-3 form-group">
    <label for="validationServer01" class="form-label">Tilte</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" id="validationServer01" name="name" value="{{ old('name', optional($tag ?? null)->name) }}">
    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
<div class="mb-3">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>