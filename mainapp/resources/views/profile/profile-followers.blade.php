<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s Followers">
@include('profile.profile-followers-only')
</x-profile>