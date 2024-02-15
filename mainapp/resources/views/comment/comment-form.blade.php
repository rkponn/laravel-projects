<form action="/post/{{ $post->id }}/comment" method="POST">
    @csrf
    <div>
        <input class="comment-input" type="text" id="comment" name="body" placeholder="leave a comment..."></input>
    </div>
    <button class="btn btn-primary btn-block" type="submit">Submit</button>
</form>


