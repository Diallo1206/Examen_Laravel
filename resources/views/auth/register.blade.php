<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center px-4 py-8" style="background-image: url('{{ asset('storage/images/1740016812712.jpg') }}');">
        <div class="w-full max-w-3xl bg-black bg-opacity-25 backdrop-blur-lg shadow-2xl rounded-2xl border border-white/30 p-10 text-gray-800">

            <!-- Titre et intro -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white drop-shadow">Créer un compte <span class="text-green-300">Sama Librairie</span></h1>
                <p class="text-sm text-white/90 mt-2 italic">Accédez à un monde de lecture, gratuitement 📖</p>
                <p class="text-sm text-white/80">Remplissez le formulaire pour rejoindre notre communauté</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <!-- Nom -->
                <div>
                    <label for="name" class="block mb-1 text-white text-sm font-medium">Nom</label>
                    <x-text-input id="name" type="text" name="name" class="w-full p-3 bg-white/80 rounded-md shadow-sm text-gray-800" :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-500" />
                </div>

                <!-- Prénom -->
                <div>
                    <label for="prenom" class="block mb-1 text-white text-sm font-medium">Prénom</label>
                    <x-text-input id="prenom" type="text" name="prenom" class="w-full p-3 bg-white/80 rounded-md shadow-sm text-gray-800" :value="old('prenom')" required />
                    <x-input-error :messages="$errors->get('prenom')" class="mt-1 text-red-500" />
                </div>

                <!-- Adresse -->
                <div>
                    <label for="adresse" class="block mb-1 text-white text-sm font-medium">Adresse</label>
                    <x-text-input id="adresse" type="text" name="adresse" class="w-full p-3 bg-white/80 rounded-md shadow-sm text-gray-800" :value="old('adresse')" required />
                    <x-input-error :messages="$errors->get('adresse')" class="mt-1 text-red-500" />
                </div>

                <!-- Téléphone -->
                <div>
                    <label for="telephone" class="block mb-1 text-white text-sm font-medium">Téléphone</label>
                    <x-text-input id="telephone" type="text" name="telephone" class="w-full p-3 bg-white/80 rounded-md shadow-sm text-gray-800" :value="old('telephone')" required />
                    <x-input-error :messages="$errors->get('telephone')" class="mt-1 text-red-500" />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block mb-1 text-white text-sm font-medium">Adresse e-mail</label>
                    <x-text-input id="email" type="email" name="email" class="w-full p-3 bg-white/80 rounded-md shadow-sm text-gray-800" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-500" />
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block mb-1 text-white text-sm font-medium">Mot de passe</label>
                    <x-text-input id="password" type="password" name="password" class="w-full p-3 bg-white/80 rounded-md shadow-sm text-gray-800" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-red-500" />
                </div>

                <!-- Confirmation mot de passe -->
                <div>
                    <label for="password_confirmation" class="block mb-1 text-white text-sm font-medium">Confirmez le mot de passe</label>
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" class="w-full p-3 bg-white/80 rounded-md shadow-sm text-gray-800" required />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-red-500" />
                </div>

                <!-- Bouton -->
                <div>
                    <x-primary-button class="w-full bg-green-400 hover:bg-green-500 text-gray-900 font-semibold py-3 rounded-md transition-all">
                        S'inscrire
                    </x-primary-button>
                </div>

                <!-- Lien connexion -->
                <div class="text-center mt-4 text-sm text-white">
                    Vous avez déjà un compte ?
                    <a href="{{ route('login') }}" class="text-green-200 underline hover:text-green-300">Se connecter</a>
                </div>
            </form>

        </div>
    </div>
</x-guest-layout>
