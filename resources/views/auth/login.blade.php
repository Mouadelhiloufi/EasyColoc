<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Connexion</title>
</head>
<body class="min-h-screen bg-[#0b0b0b] text-white">

    <header class="border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-6 flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-3xl font-semibold tracking-widest text-red-500">COLOC</a>

            <nav class="flex items-center gap-6 text-sm text-white/80">
                <a href="{{ route('login') }}" class="hover:text-white">Se connecter</a>
                <a href="{{ route('register') }}"
                   class="px-5 py-2 rounded-full border border-red-600 text-red-400 hover:bg-red-600 hover:text-white">
                    S'inscrire
                </a>
            </nav>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-14 grid lg:grid-cols-2 gap-10 items-start">
        <section class="hidden lg:block">
            <h1 class="text-5xl font-light leading-tight text-white/90">
                Qui aurait cru que faire de la <span class="text-red-500">co-location</span>
                pouvait être aussi <span class="text-red-500">simple</span> ?
            </h1>

            <div class="mt-10 grid grid-cols-3 gap-8">
                <div>
                    <div class="text-red-500 text-2xl font-semibold mb-3">Partage</div>
                    <p class="text-white/70 text-sm leading-relaxed">
                        Une nouvelle vision de la co-location : simplifiée, accompagnée, sécurisée.
                    </p>
                </div>
                <div>
                    <div class="text-red-500 text-2xl font-semibold mb-3">Multi-générationnel</div>
                    <p class="text-white/70 text-sm leading-relaxed">
                        Une expérience enrichissante où jeunes et moins jeunes partagent plus qu’un toit.
                    </p>
                </div>
                <div>
                    <div class="text-red-500 text-2xl font-semibold mb-3">Étape de vie</div>
                    <p class="text-white/70 text-sm leading-relaxed">
                        Transformez une contrainte en opportunité.
                    </p>
                </div>
            </div>
        </section>

        <section>
            <div class="max-w-md mx-auto bg-white/5 border border-white/10 rounded-2xl p-8 shadow">
                <h2 class="text-2xl font-semibold text-white mb-1">Se connecter</h2>
                <p class="text-sm text-white/60 mb-6">Accédez à votre espace EasyColoc.</p>

                {{-- status --}}
                @if (session('status'))
                    <div class="mb-4 p-3 rounded bg-green-500/10 text-green-200 border border-green-500/20">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm text-white/70 mb-1">Email</label>
                        <input name="email" type="email" value="{{ old('email') }}" required autofocus
                               class="w-full rounded-lg bg-black/30 border border-white/10 text-white
                                      focus:outline-none focus:ring-2 focus:ring-red-600/60">
                        @error('email')
                            <div class="mt-2 text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm text-white/70 mb-1">Mot de passe</label>
                        <input name="password" type="password" required
                               class="w-full rounded-lg bg-black/30 border border-white/10 text-white
                                      focus:outline-none focus:ring-2 focus:ring-red-600/60">
                        @error('password')
                            <div class="mt-2 text-sm text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="inline-flex items-center gap-2 text-sm text-white/70">
                            <input name="remember" type="checkbox"
                                   class="rounded bg-black/30 border-white/20 text-red-600 focus:ring-red-600/60">
                            Se souvenir de moi
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-sm text-white/70 hover:text-white underline underline-offset-4">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                            class="w-full px-4 py-2 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700">
                        Se connecter
                    </button>

                    <div class="text-center text-sm text-white/60">
                        Pas de compte ?
                        <a href="{{ route('register') }}" class="text-red-400 hover:text-red-300 underline underline-offset-4">
                            S'inscrire
                        </a>
                    </div>
                </form>
            </div>
        </section>
    </main>

</body>
</html>