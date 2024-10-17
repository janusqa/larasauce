<x-layout>
    <x-slot:heading>Sign In</x-slot-heading>

        <!--
  This example requires some changes to your config:
  
  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
        <form method="POST" action="/login">
            @csrf
            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">

                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                        <x-form-field>
                            <x-form-label for="email">Email</x-form-label>
                            <div class="mt-2">
                                <x-form-input name="email" id="email" placeholder="john.doe@email.com" required />
                            </div>
                            <x-form-error name='email' />
                        </x-form-field>
                        <x-form-field>
                            <x-form-label for="password">Password</x-form-label>
                            <div class="mt-2">
                                <x-form-input type="password" name="password" id="password" placeholder="Password" required />
                            </div>
                            <x-form-error name='password' />
                        </x-form-field>
                    </div>
                    <!-- <div class="mt-10">
                        @if($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li class="italic text-red-500">{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                    </div> -->
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
                <a href="/" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                <x-form-button>Sign In</x-form-button>
            </div>
        </form>

</x-layout>