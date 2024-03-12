<div class="form-group">
    @if(count($categories) > 0)
     <label for="category">Category: </label>
    @endif
    @if($isEditMode)
        <div style="height: 50px; overflow-y: scroll;">
            @foreach ($categories as $category)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category_id[]" value="{{ $category->id }}" id="category{{ $category->id }}" {{ in_array($category->id, $post->categories->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label class="form-check-label" for="category{{ $category->id }}">
                        {{ $category->name }}
                    </label>
                </div>
            @endforeach
        </div>
    @else
        @foreach($post->categories as $category)
            <span class="badge badge-primary">{{ $category->name }}</span>
        @endforeach
    @endif
</div>