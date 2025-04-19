<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center px-4 py-8" style="background-image: url('{{ asset('storage/images/1740016812712.jpg') }}');">
        <div class="w-full max-w-md bg-white bg-opacity-10 backdrop-blur-md shadow-xl rounded-2xl border border-white/30 p-8 text-white">

            <!-- Titre -->
            <div class="text-center mb-6">
                <h2 class="text-3xl font-bold">Bienvenue à <span class="text-yellow-300">Sama Librairie</span></h2>
                <p class="text-sm text-white/80 mt-1">Connectez-vous pour explorer 📚</p>
            </div>

            <!-- Status -->
            <x-auth-session-status class="mb-4 text-white" :status="session('status')" />

            <!-- Formulaire -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-white/70">
                        <i class="fas fa-user"></i>
                    </span>
                    <input id="email" type="email" name="email"
                           class="w-full pl-10 pr-4 py-3 rounded-md bg-white/20 placeholder-white/70 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           placeholder="Email" required autofocus>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-400" />
                </div>

                <!-- Mot de passe -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-white/70">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input id="password" type="password" name="password"
                           class="w-full pl-10 pr-4 py-3 rounded-md bg-white/20 placeholder-white/70 text-white focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           placeholder="Mot de passe" required>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-400" />
                </div>

                <!-- Options -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center text-white/80">
                        <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 text-yellow-400 focus:ring-yellow-400">
                        Se souvenir de moi
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-yellow-200 hover:underline" href="{{ route('password.request') }}">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <!-- Connexion -->
                <div>
                    <button type="submit"
                            class="w-full bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold py-3 rounded-md transition-all">
                        Se connecter
                    </button>
                </div>
            </form>

            <!-- Inscription -->
            <div class="text-center mt-6 text-sm">
                Vous n'avez pas de compte ?
                <a href="{{ route('register') }}" class="text-yellow-200 underline hover:text-yellow-300">Créer un compte</a>
            </div>
        </div>
    </div>
</x-guest-layout>
