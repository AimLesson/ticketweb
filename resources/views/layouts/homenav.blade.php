<nav x-data="{ open: false }" class="bg-slate-950/50 rounded-lg shadow-md mt-10 mx-auto max-w-2xl mt-5">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-6">
        <div class="flex flex-wrap items-center justify-center p-2">
            <div class="flex">
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:flex">
                    <x-nav-link :href="url('/')" :active="request()->is('/')">
                        {{ __('HOME') }}
                    </x-nav-link>
                    <x-nav-link :href="url('/lineup')" :active="request()->is('lineup')">
                        {{ __('LINE UP') }}
                    </x-nav-link>
                    <x-nav-link :href="url('/merch')" :active="request()->is('merch')">
                        {{ __('MERCHANDISE') }}
                    </x-nav-link>
                    <x-nav-link :href="url('/about')" :active="request()->is('about')">
                        {{ __('ABOUT US') }}
                    </x-nav-link>
                    <x-nav-link :href="url('/faq')" :active="request()->is('faq')">
                        {{ __('FAQ') }}
                    </x-nav-link>
                    <x-nav-link :href="url('/pay')" :active="request()->is('pay')">
                        {{ __('PAYMENT') }}
                    </x-nav-link>
                </div>
            </div>
            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="url('/')" :active="request()->is('/')">
                {{ __('HOME') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/lineup')" :active="request()->is('lineup')">
                {{ __('LINE UP') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/merch')" :active="request()->is('merch')">
                {{ __('MERCHANDISE') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/about')" :active="request()->is('about')">
                {{ __('ABOUT US') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/faq')" :active="request()->is('faq')">
                {{ __('FAQ') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="url('/pay')" :active="request()->is('pay')">
                {{ __('PAYMENT') }}
            </x-responsive-nav-link>
        </div>
    </div>
</nav>
