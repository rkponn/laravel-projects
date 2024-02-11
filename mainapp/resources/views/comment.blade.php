<div class="comments mt-3">
    @foreach($post->comments as $comment)
      <div class="comment" id="comment-{{ $comment->id }}">
        <div class="d-flex">
          <div>
            <a href="/profile/{{$comment->user->username}}">
              <img class="avatar-tiny" src="{{$comment->user->avatar}}" />
            </a>
          </div>
          <div class="ml-3">
            <div id="comment-text-{{ $comment->id }}">
              <p>{{$comment->body}}</p>
            </div>
            <textarea id="comment-edit-{{ $comment->id }}" class="form-control" style="display:none; width: 600px;">{{$comment->body}}</textarea>
            @if(auth()->check() && auth()->user()->id === $comment->user_id)
            <div class="mt-1">
                <a onclick="editComment({{ $comment->id }})" class="text-primary small"><i class="fas fa-edit"></i></a>
                <a onclick="deleteComment({{ $comment->id }})" class="text-danger small"><i class="fas fa-trash"></i></a>
                <button onclick="saveComment({{ $comment->id }})" class="btn btn-primary btn-sm ml-auto" style="display:none;">Save</button>
            </div>
            @endif
            <p class="text-muted small">Posted by {{$comment->user->username}} on {{$comment->created_at->format('n/j/Y')}}</p>
          </div>
        </div>
      </div>
    @endforeach
  </div>