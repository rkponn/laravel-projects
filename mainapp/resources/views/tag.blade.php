<div class="form-group">
    <label for="tags">Tags</label>
    @if($isEditMode)
        <input type="text" 
        id="tags" 
        name="tags" 
        class="form-control" 
        placeholder="Enter tags, separated by commas, no spaces"
        value="{{ old('tags', $post->tags->pluck('name')->implode(',')) }}">
    @else
        <p>{{ $post->tags->pluck('name')->implode(', ') }}</p>
    @endif
</div>