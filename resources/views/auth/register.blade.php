@extends('layouts.auth')

@section('content')
    <div class="page-content page-auth" id="register">
        <div class="section-store-auth" data-aos="fade-up">
            <div class="container">
                <div class="row align-items-center justify-content-center row-login">
                    <div class="col-lg-4">
                        <h2>
                            Memulai untuk jual beli <br />
                            dengan cara terbaru
                        </h2>
                        <form method="POST" action="{{ route('register') }}" class="mt-3">
                            @csrf
                            <div class="form-group">
                                <label>Full Name</label>
                                {{-- ! dari Galih BWA --}}
                                <input 
                                  v-model="name" 
                                  id="name" 
                                  type="text" 
                                  class="form-control @error('name') is-invalid @enderror"
                                  name="name" 
                                  value="{{ old('name') }}"
                                  required 
                                  autocomplete="name" 
                                  autofocus />
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input 
                                  id="email" 
                                  v-model="email"
                                  @change="checkEmail()"
                                  type="email" 
                                  class="form-control @error('email') is-invalid @enderror" 
                                  :class="{ 'is-invalid' : this.email_unavailable }"
                                  name="email" 
                                  value="{{ old('email') }}" 
                                  required 
                                  autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input 
                                  id="password" 
                                  type="password" 
                                  class="form-control @error('password') is-invalid @enderror" 
                                  name="password" 
                                  required 
                                  autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password</label>
                                <input 
                                  id="password-confirm" 
                                  type="password" 
                                  class="form-control @error('password_confirmation') is-invalid @enderror" 
                                  name="password_confirmation" 
                                  required 
                                  autocomplete="new-password">

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Store</label>
                                <p class="text-muted">Apakah anda juga ingin membuka toko?</p>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="is_store_open"
                                        id="openStoreTrue" v-model="is_store_open" :value="true" />
                                    <label for="openStoreTrue" class="custom-control-label">Iya, boleh</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" class="custom-control-input" name="is_store_open"
                                        id="openStoreFalse" v-model="is_store_open" :value="false" />
                                    <label for="openStoreFalse" class="custom-control-label">Enggak, makasih</label>
                                </div>
                            </div>
                            <div class="form-group" v-if="is_store_open">
                                <label>Nama Toko</label>
                                <input type="text"
                                  v-model="store_name"
                                  id="store_name"
                                  class="form-control @error('store_name') is-invalid @enderror"
                                  name="store_name"
                                  required
                                  autocomplete
                                  autofocus />
                                @error('store_name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                                @enderror
                            </div>
                            <div class="form-group" v-if="is_store_open">
                                <label>Kategori</label>
                                <select name="categories_id" class="form-control">
                                    <option value="" disabled>Select Category</option>
                                    @foreach ($categories as $category)
                                      <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button 
                              type="submit"
                              class="btn btn-success btn-block mt-4"
                              :disabled="this.email_unavailable">
                              Sign Up Now
                            </button>
                            <a href="{{ route('login') }}" class="btn btn-signup btn-block mt-2">Back to Sign In</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('addon-script')
    <script src="/vendor/vue/vue.js"></script>
    <script src="https://unpkg.com/vue-toasted"></script>
    <script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
    <script>
        Vue.use(Toasted);

        const register = new Vue({
            el: "#register",
            mounted() {
                AOS.init();
            },
            methods: {
              checkEmail: function(){
                let self = this;
                axios.get('{{ route('api-register-check') }}', {
                  params: {
                    email: this.email
                  }
                })
                  .then(function (response) {

                    if(response.data == 'Available'){
                      self.$toasted.show(
                          "Email Tersedia.! Silahkan lanjut ke langkah selanjutnya", {
                              position: "top-center",
                              className: "rounded",
                              duration: 1500,
                          }
                        );
                        self.email_unavailable = false
                    } else{
                        self.$toasted.error(
                          "Maaf, tampaknya email sudah terdaftar pada sistem kami.", {
                              position: "top-center",
                              className: "rounded",
                              duration: 1500,
                          }
                        );
                        self.email_unavailable = true
                    }

                  })
              }
            },
            data() {
                return{
                  name: "Angga Hazza Sett",
                  email: "kamujagoan@bwa.id",
                  is_store_open: true,
                  store_name: "",
                  email_unavailable: false,
                }
            },
        });
    </script>
@endpush

{{-- <x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}
