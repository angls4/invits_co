<div
	x-show="isOpen()"
	class="fixed inset-0 z-40 flex min-h-screen bg-white bg-opacity-75 xl:static xl:self-stretch"
>
	<div
		@click.away="handleAway()"
		class="flex flex-col text-white shadow bg-brand-purple-500 w-80 xl:h-full"
	>
		<div class="flex content-between">
			<div class="w-full px-3 py-6">
                <img src="{{ asset('img/logo/logo-light.svg') }}" class="inline-block mr-2" alt="" width="40">
                <strong>Client Area</strong>
            </div>
			<a
				@click.prevent="handleClose()"
				class="flex items-center flex-1 p-3 cursor-default"
				href="#"
			>
				<svg
					class="w-6 h-6 hover:stroke-brand-yellow-500"
					xmlns="http://www.w3.org/2000/svg"
					fill="none"
					viewBox="0 0 24 24"
					stroke="currentColor"
				>
					<path
						stroke-linecap="round"
						stroke-linejoin="round"
						stroke-width="2"
						d="M6 18L18 6M6 6l12 12"
					/>
				</svg>
			</a>
		</div>
		<div class="grow">
			<a
				class="flex items-center w-full p-3 hover:bg-brand-yellow-500 hover:text-black"
				href="{{ route('home') }}"
			>
				<i class="ph-fill ph-house mr-3 text-[26px]"></i>Back to Home
			</a>
			@if(session('user.role') == 'user')
				<a
					class="flex items-center w-full p-3 hover:bg-brand-yellow-500 hover:text-black {{ request()->routeIs('client.index') ? 'sidebar-active' : '' }}"
					href="{{ route('client.profile.index', encode_id(session("user.id"))) }}"
				>
					<i class="ph-fill ph-user mr-3 text-[26px]"></i></i>Profile
				</a>
				<a
					class="flex items-center w-full p-3 hover:bg-brand-yellow-500 hover:text-black {{ request()->routeIs('client.orders') ? 'sidebar-active' : '' }}"
					href="{{ route('client.orders') }}"
				>
					<i class="ph-fill ph-shopping-cart-simple mr-3 text-[26px]"></i>Orders
				</a>
				@if ( request()->is('client/invitations/*') )
				<a
					class="flex items-center w-full p-3 pl-6 hover:bg-brand-yellow-500 hover:text-black {{ request()->routeIs('client.invitation.guest.index') ? 'sidebar-active' : 'bg-brand-purple-600' }}"
					href="{{ route('client.invitation.guest.index', encode_id($data)) }}">
					<i class="ph-fill ph-user-list mr-3 text-[26px]"></i>
					Tamu
				</a>
				<a
					class="flex items-center w-full p-3 pl-6 hover:bg-brand-yellow-500 hover:text-black {{ request()->routeIs('client.invitation.rsvp') ? 'sidebar-active' : 'bg-brand-purple-600' }}"
					href="{{ route('client.invitation.rsvp', encode_id($data)) }}">
					<i class="ph-fill ph-list-checks mr-3 text-[26px]"></i>
					RSVP
				</a>
				@endif
			@endif
			
			@if(session('user.role') == 'admin')
				<a
					class="flex items-center w-full p-3 hover:bg-brand-yellow-500 hover:text-black {{ request()->routeIs('client.index') ? 'sidebar-active' : '' }}"
					href="{{ route('client.profile.index', encode_id(session("user.id"))) }}"
				>
					<i class="ph-fill ph-user mr-3 text-[26px]"></i></i>Users
				</a>
				<a
					class="flex items-center w-full p-3 hover:bg-brand-yellow-500 hover:text-black {{ request()->routeIs('client.orders') ? 'sidebar-active' : '' }}"
					href="{{ route('admin.orders') }}"
				>
					<i class="ph-fill ph-shopping-cart-simple mr-3 text-[26px]"></i>Orders
				</a>
				<a
					class="flex items-center w-full p-3 hover:bg-brand-yellow-500 hover:text-black {{ request()->routeIs('client.orders') ? 'sidebar-active' : '' }}"
					href="{{ route('admin.packages') }}"
				>
					<i class="ph-fill ph-package mr-3 text-[26px]"></i>Packages
				</a>
				<a
					class="flex items-center w-full p-3 hover:bg-brand-yellow-500 hover:text-black {{ request()->routeIs('client.orders') ? 'sidebar-active' : '' }}"
					href="{{ route('client.orders') }}"
				>
					<i class="ph-fill ph-palette mr-3 text-[26px]"></i>Themes
				</a>
			@endif
		</div>
		<div class="px-5">
			<div class="border-t-[1px] border-white flex py-5 items-center">
				<div class="flex grow">
					<img class="w-10 h-10 mr-2 rounded-full" src="{{asset(session('user.avatar') ?? 'img/default-avatar.jpg')}}" alt="{{asset(session('user.name'))}}">
					<div>
						<strong class="block capitalize">{{ session('user.name') }}</strong>
						<span>{{ session('user.email') }}</span>
					</div>
				</div>
				<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
					<i class="text-2xl ph ph-sign-out"></i>
				</a>

				 <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                </form>
			</div>
		</div>
	</div>
</div>
