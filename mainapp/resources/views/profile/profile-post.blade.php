<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s Profile">
  @include('profile.profile-posts-only')
</x-profile>