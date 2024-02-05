<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}} Follows">
    @include('profile-following-only')
</x-profile>