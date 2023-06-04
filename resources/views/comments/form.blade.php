<div class="mb-3">
    <input type="number" value="{{ $post->id  }}" hidden name="post_id">
    <textarea id="validationServer01" cols="30" rows="5" class="form-control" name="content">{{ old('content') }}</textarea>
</div>