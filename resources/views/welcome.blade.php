<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyColoc</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen bg-black text-white">

    {{-- NAV --}}
    <header class="mx-auto max-w-7xl px-6 py-6">
        <div class="flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <span class="text-2xl">✋</span>
                <span class="text-xl font-semibold tracking-wide">Coloco</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                   class="rounded-full px-4 py-2 text-sm font-medium text-white/80 hover:text-white hover:bg-white/10">
                    Se connecter
                </a>

                <a href="{{ route('register') }}"
                   class="rounded-full border border-white/20 px-4 py-2 text-sm font-semibold text-white hover:bg-white/10">
                    S’inscrire
                </a>
            </div>
        </div>
    </header>

    {{-- HERO --}}
    <main class="relative mx-auto max-w-7xl px-6 py-10">
        {{-- “Rubans” gauche / droite (sans image) --}}
        <div class="pointer-events-none absolute inset-0 overflow-hidden">
            <div class="absolute -left-40 top-24 h-[520px] w-[520px] rounded-full border-[32px] border-white/90 opacity-90"></div>
            <div class="absolute -right-40 top-24 h-[520px] w-[520px] rounded-full border-[32px] border-white/90 opacity-90"></div>
        </div>

        <div class="relative z-10 flex flex-col items-center">

            {{-- “Cards” en haut (placeholders) --}}
            <div class="mt-10 flex items-center justify-center gap-6">
                <div class="h-28 w-40 rotate-[-10deg] rounded-2xl border border-white/20 bg-white/10 shadow-lg backdrop-blur">
                    <div class="flex h-full items-center justify-center text-white/50 text-sm">
                        Carte 1
                    </div>
                </div>

                <div class="h-28 w-44 rounded-2xl border border-white/20 bg-white/10 shadow-lg backdrop-blur">
                    <div class="flex h-full items-center justify-center text-white/50 text-sm">
                        Carte 2
                    </div>
                </div>

                <div class="h-28 w-40 rotate-[10deg] rounded-2xl border border-white/20 bg-white/10 shadow-lg backdrop-blur">
                    <div class="flex h-full items-center justify-center text-white/50 text-sm">
                        Carte 3
                    </div>
                </div>
            </div>

            {{-- Titre --}}
            <h1 class="mt-14 text-center text-4xl md:text-5xl font-light">
                <span class="inline-flex items-center gap-3">
                    <span class="text-red-500">🏠</span>
                    Trouve ta colocation idéale
                    <span class="text-red-500">🔑</span>
                </span>
            </h1>

            <p class="mt-4 text-center text-white/60 text-lg">
                Sans prise de tête
            </p>

            {{-- Search (just UI) --}}
            <div class="mt-10 flex w-full max-w-2xl items-center gap-3 rounded-full bg-white/10 px-5 py-3 border border-white/10 backdrop-blur">
                <input
                    type="text"
                    placeholder="Faites une recherche"
                    class="w-full bg-transparent outline-none placeholder:text-white/40 text-white"
                />

                <button
                    type="button"
                    class="h-10 w-10 rounded-full bg-white/10 hover:bg-white/15 border border-white/10 flex items-center justify-center"
                    aria-label="Search"
                >
                    🔎
                </button>
            </div>

        </div>
    </main>

</body>
</html>