<div class="form-group">
    <label for="tags">Tags</label>
    @if($isEditMode)
        <input type="text" 
        id="tags" 
        name="tags" 
        class="form-control" 
        placeholder="Enter tags, separated by commas, no spaces"
        value="{{ old('tags', $post->tags->pluck('name')->unique()->implode(',')) }}">
    @else
        @foreach($post->tags->unique('name') as $tag)
            <span class="badge badge-primary">{{ $tag->name }}</span>
        @endforeach
    @endif
</div>