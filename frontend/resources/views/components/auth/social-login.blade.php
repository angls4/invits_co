@if(env('FACEBOOK_ACTIVE') || env('GITHUB_ACTIVE') || env('GOOGLE_ACTIVE'))

<div class="mb-4">
    <div class="flex items-center my-6 text-center">
        <hr class="w-1/2 border-black"> 
        <p class="w-full"> Masuk dengan cara lain </p>
        <hr class="w-1/2 border-black">
    </div>

    <div class="pb-4 text-center">
        <x-button-a href="{{route('social.login', 'facebook')}}" class="block w-full mb-3 text-white bg-blue-600 hover:bg-blue-700">
            <span class="">Masuk Melalui Facebook</span>
        </x-button-a>

        <x-button-a href="{{route('social.login', 'google')}}" class="block w-full text-white bg-red-600 hover:bg-red-700">
            <span class="">Masuk Melalui Google</span>
        </x-button-a>
    </div>
</div>

@endif