<nav x-data="{ open: false }" class="bg-gradient-to-r from-teal-400 to-blue-500 text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo et Nom -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                    <x-application-logo class="h-8 w-auto text-white" />
                    <span class="text-xl font-bold">Sunu Bibliothèque</span>
                </a>
            </div>

            <!-- Liens de navigation -->
            <div class="hidden sm:flex space-x-6">
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white hover:text-yellow-200">
                    {{ __('Dashboard') }}
                </x-nav-link>

                <x-nav-link :href="route('livres.index')" :active="request()->routeIs('livres.index')" class="text-white hover:text-yellow-200">
                    {{ __('Livres') }}
                </x-nav-link>

                <x-nav-link :href="route('commandes.index')" :active="request()->routeIs('commandes.index')" class="text-white hover:text-yellow-200">
                    {{ __('Commandes') }}
                </x-nav-link>

                @if(Auth::user()->role == 'gestionnaire')
                    <x-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.index')" class="text-white hover:text-yellow-200">
                        {{ __('Clients') }}
                    </x-nav-link>

                    <x-nav-link :href="route('paiements.index')" :active="request()->routeIs('paiements.index')" class="text-white hover:text-yellow-200">
                        {{ __('Factures') }}
                    </x-nav-link>

                    <x-nav-link :href="route('statistiques.index')" :active="request()->routeIs('statistiques.index')" class="text-white hover:text-yellow-200">
                        {{ __('Statistiques') }}
                    </x-nav-link>
                @endif
            </div>

            <!-- Menu utilisateur -->
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center px-3 py-2 bg-white/20 hover:bg-white/30 text-white font-medium rounded-md shadow-md transition">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-2 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.afficher')">
                            {{ __('Profil') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Bouton menu mobile -->
            <div class="sm:hidden flex items-center">
                <button @click="open = ! open" class="p-2 rounded-md hover:bg-white/10 transition">
                    <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{ 'hidden': open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Menu responsive mobile -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden bg-teal-600">
        <div class="px-4 pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('livres.index')" :active="request()->routeIs('livres.index')">
                {{ __('Livres') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('commandes.index')" :active="request()->routeIs('commandes.index')">
                {{ __('Commandes') }}
            </x-responsive-nav-link>

            @if(Auth::user()->role == 'gestionnaire')
                <x-responsive-nav-link :href="route('clients.index')" :active="request()->routeIs('clients.index')">
                    {{ __('Clients') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('paiements.index')" :active="request()->routeIs('paiements.index')">
                    {{ __('Factures') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('statistiques.index')" :active="request()->routeIs('statistiques.index')">
                    {{ __('Statistiques') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Infos utilisateur -->
        <div class="border-t border-teal-300 px-4 py-3">
            <div class="text-white font-semibold">{{ Auth::user()->name }}</div>
            <div class="text-white text-sm">{{ Auth::user()->email }}</div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.afficher')">
                    {{ __('Profil') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
