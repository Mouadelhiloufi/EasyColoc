<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyColoc</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#0b0b0b] text-white">

    <header class="border-b border-white/10">
        <div class="max-w-7xl mx-auto px-6 py-8 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <span class="text-2xl">✋</span>
                <span class="text-xl font-semibold tracking-wide">Coloco</span>
            </a>

            <nav class="flex items-center gap-4">
                <a href="{{ route('login') }}"
                   class="rounded-full px-5 py-2.5 text-sm font-medium text-white/80 hover:text-white hover:bg-white/10 transition-all">
                    Se connecter
                </a>

                <a href="{{ route('register') }}"
                   class="rounded-full border border-white/20 px-5 py-2.5 text-sm font-semibold text-white hover:bg-white/10 transition-all">
                    S'inscrire
                </a>
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6">
        <!-- Hero Section -->
        <section class="text-center pt-20 pb-20 md:pt-24 md:pb-24">
            <h1 class="text-5xl md:text-7xl font-light leading-tight text-white mb-10">
                Trouve ta <span class="text-red-500">colocation</span> idéale
            </h1>

            <p class="text-xl md:text-2xl text-white/60 mb-14">
                Sans prise de tête
            </p>

            {{-- Buttons (same line + bigger) --}}
            <div class="flex items-center justify-center gap-6">
                <a href="{{ route('register') }}"
                   class="px-14 md:px-16 py-5 rounded-full bg-red-600 text-white font-semibold
                          hover:bg-red-700 shadow-lg shadow-red-500/30 transition-all text-lg md:text-xl">
                    Commencer
                </a>

                <a href="{{ route('login') }}"
                   class="px-14 md:px-16 py-5 rounded-full border border-white/20 text-white font-semibold
                          hover:bg-white/10 transition-all text-lg md:text-xl">
                    Se connecter
                </a>
            </div>
        </section>

        <!-- Features Section -->
        <section class="pt-16 pb-20 md:pt-20 md:pb-24 border-t border-white/10">
            <div class="max-w-5xl mx-auto">
                <div class="grid md:grid-cols-3 gap-12 md:gap-16">
                    <div class="text-center px-2">
                        <div class="text-5xl mb-8">🏠</div>
                        <h3 class="text-xl font-semibold text-white mb-5">Gestion simplifiée</h3>
                        <p class="text-white/60 text-base md:text-lg leading-relaxed">
                            Gérez vos dépenses et colocataires facilement
                        </p>
                    </div>

                    <div class="text-center px-2">
                        <div class="text-5xl mb-8">💰</div>
                        <h3 class="text-xl font-semibold text-white mb-5">Suivi des dépenses</h3>
                        <p class="text-white/60 text-base md:text-lg leading-relaxed">
                            Équilibrez les comptes en quelques clics
                        </p>
                    </div>

                    <div class="text-center px-2">
                        <div class="text-5xl mb-8">👥</div>
                        <h3 class="text-xl font-semibold text-white mb-5">Collaboration</h3>
                        <p class="text-white/60 text-base md:text-lg leading-relaxed">
                            Gérez tout ensemble en temps réel
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-white/10 mt-8">
        <div class="max-w-7xl mx-auto px-6 py-8">
            <div class="text-center text-white/40 text-sm">
                © 2024 EasyColoc. Tous droits réservés.
            </div>
        </div>
    </footer>

</body>
</html>