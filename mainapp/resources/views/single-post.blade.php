<x-layout :doctitle="$post->title">
    <div class="container py-md-5 container--narrow">
      <div class="d-flex justify-content-between">
        <h2>{{$post->title}}</h2>
        @can('update', $post)
        <span class="pt-2">
          <a href="/post/{{$post->id}}/edit" class="text-primary mr-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fas fa-edit"></i></a>
          <form class="delete-post-form d-inline" action="/post/{{$post->id}}" method="POST">
            @csrf
            @method('DELETE')
            <button class="delete-post-button text-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fas fa-trash"></i></button>
          </form>
        </span>
        @endcan
      </div>

      <p class="text-muted small mb-4">
        <a href="/profile/{{$post->user->username}}"><img class="avatar-tiny" src="{{$post->user->avatar}}" /></a>
        Posted by <a href="/profile/{{$post->user->username}}">{{$post->user->username}}</a> on {{$post->created_at->format('n/j/Y')}}
      </p>

      <div class="body-content">
        {!! $post->body !!}
      </div>

      <div class="container mt-5">
      <h4>Comments</h4>
      <div>
        @include('comment-form')
      </div>
      <div class="comments mt-3">
          @foreach($post->comments as $comment)
            <div class="comment">
              <div class="d-flex">
                <div>
                  <a href="/profile/{{$comment->user->username}}"><img class="avatar-tiny" src="{{$comment->user->avatar}}" /></a>
                </div>
                <div class="ml-3">
                  <p>{{$comment->body}}</p>
                  <p class="text-muted small">Posted by {{$comment->user->username}} on {{$comment->created_at->format('n/j/Y')}}</p>
                </div>
              </div>
            </div>
          @endforeach
      </div>
      </div>
    </div>
</x-layout>
