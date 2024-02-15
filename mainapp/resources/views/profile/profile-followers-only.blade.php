<div class="list-group">
    @foreach ($followers as $follow)
    <a href="/profile/{{$follow->usersFollowers->username}}" class="list-group-item list-group-item-action">
        <img class="avatar-tiny" src="{{$follow->usersFollowers->avatar}}" />
        {{$follow->usersFollowers->username}}
    </a> 
  @endforeach
</div>