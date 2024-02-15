<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}} Follows">
    @include('profile.profile-following-only')
</x-profile>