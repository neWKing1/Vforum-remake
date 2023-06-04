<div class="mb-3 form-group">
    <label for="validationServer01" class="form-label">Tilte</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="validationServer01" name="title" value="{{ old('title', optional($post ?? null)->title) }}">
    @error('title')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
<div class="mb-3 form-group">
    <label for="validationServer03" class="form-label">Content</label>
    <textarea id="" cols="30" rows="10" class="form-control @error('content') is-invalid @enderror" name="content">{{ old('content', optional($post ?? null)->content) }}</textarea>
    @error('content')
    <div id="validationServer03Feedback" class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>
<div class="mb-3 form-group">
    <label for="validationServer03" class="form-label">Tags</label>
    <div class="row">
        @foreach($tags as $key => $tag)
        <div class="col-6 col-md-4 col-lg-3">
            <input type="checkbox" name="tags[]" value="{{ $tag->id }}" id="" class="btn" style="width: 16px; height: 16px;">
            <label for="">{{ $tag->name }}</label>
        </div>
        @endforeach
        @isset($post->tags)
        <div class="mt-3 row">
            <p class="text-capitalize text-danger mb-0">old tag before: </p>
            @foreach($post->tags as $postTag)
            <label for="" class="d-inline-block col-6 col-md-4 col-lg-3">{{ $postTag->name }}</label>
            @endforeach
        </div>
        @endisset
    </div>
</div>
<div class="mb-3 form-group">
    <label for="imgInp" class="form-label">Thumbnail</label>
    <input type="file" class="form-control-file @error('thumbnail') is-invalid @enderror" id="imgTmp" name="thumbnail" accept="image/*" value="">
    @error('thumbnail')
    <div id="validationServer03Feedback" class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
    @isset($post)
    <img id="blah" src="{{ optional($post->image)->url() ?? Storage::url('default/No-Image.png') }}" alt="your image" style="width: 200px; height: 200px" class="d-block" />
    @endisset
    @empty($post)
    <img id="blah" src="{{ Storage::url('default/No-Image.png') }}" alt="your image" style="width: 200px; height: 200px" class="d-block" />
    @endempty
</div>
<div class="mb-3">
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
@push('scripts')
<script type="text/javascript">
    $(document).ready(() => {
        $('#imgTmp').change(function() {
            const file = this.files[0];
            console.log(file);
            if (file) {
                let reader = new FileReader();
                reader.onload = function(event) {
                    console.log(event.target.result);
                    $('#blah').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
        console.log(3121);
    });
</script>
@endpush