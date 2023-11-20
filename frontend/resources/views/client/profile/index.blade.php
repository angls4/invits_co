@extends('client.layouts.app')

@section('content')
    <main class="grow">
        <div class="flex flex-col items-center justify-center py-8 text-center bg-brand-purple-100">
            <img class="w-36 h-36 mb-3 rounded-full border-[5px] border-white" src="{{ asset($user->profile->avatar) }}" alt="{{ $user->name }}">
            <div>
                <h2 class="mb-0 text-2xl font-medium">{{ $user->name }}</h2>
                <span class="font-light">{{ $user->email }}</span>
            </div>
        </div>
        <form action="{{ route('client.profile.update', encode_id($user->id)) }}" method="post" x-data="form()" enctype="multipart/form-data">
            @csrf
            <section class="bg-white">
                <div class="container py-8">
                    <div class="text-center sm:text-start">
                        <h3 class="mb-0 text-xl font-medium">Profile</h3>
                        <p>This information will be displayed publicly so be careful what you share.</p>
                    </div>
                    <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                        <div class="sm:w-1/3">
                            <span class="font-bold">Name</span>
                            @error('first_name')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                            @error('last_name')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-1.5 sm:gap-4 sm:flex-row sm:w-2/3">
                            <input type="text" name="first_name" value="" x-model="form.profile.first_name"
                                class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                placeholder="Nama Belakang" :disabled="isEdit() ? false : true" :class="isEdit() == false && 'bg-neutral-100 '"/>
                            <input type="text" name="last_name" value="" x-model="form.profile.last_name"
                                class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                placeholder="Nama Belakang" :disabled="isEdit() ? false : true" :class="isEdit() == false && 'bg-neutral-100 '"/>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                        <div class="sm:w-1/3">
                            <span class="font-bold">
                                Your Photo
                            </span>
                            @error('avatar')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
                        <div class="sm:w-2/3">
                            <input name="avatar" class="block w-full text-sm text-gray-900 focus:outline-none file:bg-brand-purple-500 file:text-white file:rounded-md file:px-5 file:py-2 file:mr-5 file:disabled:bg-gray-100 file:disabled:text-gray-400 " id="file_input" type="file" :disabled="isEdit() ? false : true">
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                        <div class="sm:w-1/3">
                            <span class="font-bold">Bio</span>
                            @error('bio')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
                        <div class="sm:w-2/3">
                            <textarea :disabled="isEdit() ? false : true" :class="isEdit() == false && 'bg-neutral-100 '" 
                                id="message" name="bio" rows="4" value="" x-model="form.profile.bio"
                                class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Write your thoughts here..."></textarea>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                        <div class="sm:w-1/3">
                            <span class="font-bold">Alamat</span>
                            @error('address')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
                        <div class="sm:w-2/3">
                            <textarea :disabled="isEdit() ? false : true" :class="isEdit() == false && 'bg-neutral-100 '" 
                                id="message" name="address" rows="4" value="" x-model="form.profile.address"
                                class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan alamat lengkap"></textarea>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                        <div class="sm:w-1/3">
                            <span class="font-bold">URL Website</span>
                            @error('url_website')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
                        <div class="sm:w-2/3">
                            <input type="text" name="url_website" value="" x-model="form.profile.url_website"
                                class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                placeholder="Masukkan Link Personal Website" :disabled="isEdit() ? false : true" :class="isEdit() == false && 'bg-neutral-100 '"/>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                        <div class="sm:w-1/3">
                            <span class="font-bold">URL Media Sosial</span>
                            @error('url_facebook')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                            @error('url_linkedin')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                            @error('url_twitter')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                            @error('url_instagram')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
                        <div class="flex flex-col gap-1.5 sm:w-2/3 sm:gap-4">
                            <div class="flex flex-col sm:flex-row gap-1.5 sm:gap-4">
                                <input type="text" name="url_facebook" value="" x-model="form.profile.url_facebook"
                                    class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                    placeholder="URL Facebook" :disabled="isEdit() ? false : true" :class="isEdit() == false && 'bg-neutral-100 '"/>
                                <input type="text" name="url_linkedin" value="" x-model="form.profile.url_linkedin"
                                    class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                    placeholder="URL Linkedin" :disabled="isEdit() ? false : true" :class="isEdit() == false && 'bg-neutral-100 '"/>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-1.5 sm:gap-4">
                                <input type="text" name="url_twitter" value="" x-model="form.profile.url_twitter"
                                    class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                    placeholder="URL Twitter" :disabled="isEdit() ? false : true" :class="isEdit() == false && 'bg-neutral-100 '"/>
                                <input type="text" name="url_instagram" value="" x-model="form.profile.url_instagram"
                                    class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                    placeholder="URL Instagram" :disabled="isEdit() ? false : true" :class="isEdit() == false && 'bg-neutral-100 '"/>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="bg-white">
                <div class="container py-8">
                    <div class="text-center sm:text-start">
                        <h3 class="mb-0 text-xl font-medium">Personal Info</h3>
                        <p>Information of this block will not be displayed publicly.</p>
                    </div><div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                        <div class="sm:w-1/3">
                            <span class="font-bold">Email</span>
                            @error('email')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
                        <div class="sm:w-2/3">
                            <input type="text" name="email" value="" x-model="form.profile.email"
                                class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                placeholder="Masukkan Alamat Email Valid" :disabled="isEdit() ? false : true" :class="isEdit() == false && 'bg-neutral-100 '"/>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                        <div class="sm:w-1/3">
                            <span class="font-bold">No. Telepon</span>
                            @error('mobile')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
                        <div class="sm:w-2/3">
                            <input type="text" name="mobile" value="" x-model="form.profile.mobile"
                                class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                placeholder="08XXXXXXXXXX" :disabled="isEdit() ? false : true" :class="isEdit() == false && 'bg-neutral-100 '"/>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                        <div class="sm:w-1/3">
                            <span class="font-bold">Date of Birth</span>
                            @error('date_of_birth')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
                        <div class="sm:w-2/3">
                            <input type="date" name="date_of_birth" value="" x-model="form.profile.date_of_birth"
                                class="block min-h-[auto] rounded border border-gray-300 py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-200 ease-linear motion-reduce:transition-none w-full"
                                placeholder="" :disabled="isEdit() ? false : true" :class="isEdit() == false && 'bg-neutral-100 '"/>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1.5 py-4 border-t border-gray-200 sm:flex-row">
                        <div class="sm:w-1/3">
                            <span class="font-bold">Gender</span>
                            @error('gender')
                            <p class="mt-2 text-sm text-red-600"><span class="font-medium">{{ $message }}</span></p>
                            @enderror
                        </div>
                        <div class="sm:w-2/3">
                            <select name="gender" class=" border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                :disabled="isEdit() ? false : true" :class="isEdit() == false && 'bg-neutral-100 '"
                            >
                                <option :selected="!form.profile.gender" disabled>Pilih Gender</option>
                                <option value="Male" :selected="form.profile.gender == 'Male'">Pria</option>
                                <option value="Female" :selected="form.profile.gender == 'Female'">Wanita</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2 py-4 border-t border-gray-200" x-show="!isEdit()">
                        <x-button type="button" @click="editMode()" class="w-full py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                            <span class="mx-1">Ubah</span>
                        </x-button>
                    </div>
                    <div class="flex justify-end gap-2 py-4 border-t border-gray-200" x-show="isEdit()">
                        <x-button type="button" @click="reset()" class="w-full py-3 tracking-wide capitalize transition-colors duration-200 transform bg-white sm:w-40 ring-1 ring-brand-purple-500 hover:ring-0 hover:text-black hover:bg-brand-yellow-500">
                            <span class="mx-1">Batalkan</span>
                        </x-button>
                        <x-button type="submit" class="w-full py-3 tracking-wide text-white capitalize transition-colors duration-200 transform sm:w-40 bg-brand-purple-500 hover:bg-brand-yellow-500 hover:text-black">
                            <span class="mx-1">Simpan Perubahan</span>
                        </x-button>
                    </div>
                </div>
            </section>
        </form>
        <section class="bg-white">
            <div class="container py-8">
                <div class="flex flex-col gap-2.5 py-4 border-t border-gray-200 sm:flex-row">
                    <div class="text-center sm:w-1/3 sm:text-start">
                        <h3 class="mb-0 text-xl font-medium">Account Settings</h3>
                        <p class="m-0">Update account information.</p>
                    </div>
                    <div class="flex items-center sm:w-2/3">
                        <x-button-a href="{{ route('client.profile.password.edit', encode_id($user->id)) }}" class="w-full py-3 tracking-wide capitalize transition-colors duration-200 transform bg-white ring-1 ring-brand-purple-500 hover:ring-0 hover:text-black hover:bg-brand-yellow-500">
                            <span class="mx-1">Ubah Kata Sandi</span>
                        </x-button-a>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @push('before-scripts')
    
    @if(session()->has('success'))
    <script>alert(session('success'))</script>
    @endif
    
    <script>
        function form() {
            const user = @json($user);
            console.log(user);
            let date_of_birth = "";

            if (user.date_of_birth) { date_of_birth = ((user.date_of_birth).split("T"))[0] };

            return {
                edit: false,
                form: {
                    ...user,
                    date_of_birth
                },
                isEdit() {
                    return this.edit
                },
                editMode() {
                    this.edit = true
                },
                readonlyMode(){
                    this.edit = false
                },
                reset(){
                    this.form = {
                        ...user,
                        date_of_birth
                    };
                    this.edit = false;
                }
            }
        }
    </script>
    @endpush
@endsection