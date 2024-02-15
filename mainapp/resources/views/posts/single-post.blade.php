<x-layout :doctitle="$post->title">
    <div class="container py-md-5 container--narrow">
      @include('category.category-form')
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

      <div class="mt-5">
        @include('tag.tag')
      </div>
      <div class="container mt-5">
      <h4>Comments</h4>
      <div>
        @include('comment.comment-form')
      </div>
      @include('comment.comment')
      <script>
        function toggleDisplay(elements, displayState) {
          elements.forEach(element => {
            if (typeof element === 'string') {
              document.querySelector(element).style.display = displayState;
            } else if (element instanceof Element) {
              element.style.display = displayState;
            }
          });
        }
      
        function editComment(commentId) {
          toggleDisplay([
            '#comment-text-' + commentId,
            `#comment-${commentId} .fa-edit`
          ], 'none');
          toggleDisplay([
            '#comment-edit-' + commentId,
            `#comment-${commentId} .btn-primary`
          ], 'block');
          toggleDisplay([
            `#comment-${commentId} .fa-trash`
          ], 'none');
        }
      
        async function saveComment(commentId) {
          try {
            const updatedContent = document.getElementById('comment-edit-' + commentId).value;
      
            // Prepare request body
            const data = { body: updatedContent };
      
            // Axios POST request
            const response = await axios.put('/comment/' + commentId, data, {
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token
              }
            });
      
            document.getElementById('comment-text-' + commentId).innerHTML = '<p>' + updatedContent + '</p>';
            toggleDisplay([
              '#comment-text-' + commentId,
              `#comment-${commentId} .fa-edit`
            ], 'inline-block');
            toggleDisplay([
              '#comment-edit-' + commentId,
              `#comment-${commentId} .btn-primary`
            ], 'none');
            toggleDisplay([
              `#comment-${commentId} .fa-trash`
            ], 'inline-block');
          } catch (error) {
            console.error('There was a problem with the Axios operation:', error);
            throw error;
          }
        }
      
        // Delete comment
        async function deleteComment(commentId) {
          try {
            // Axios DELETE request
            const response = await axios.delete('/comment/' + commentId, {
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token
              }
            });
      
            // Remove comment from the DOM
            document.getElementById('comment-' + commentId).remove();
          } catch (error) {
            console.error('There was a problem with the Axios operation:', error);
            throw error;
          }
        }
      </script>
  </div>
</div>
</x-layout>
