<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white">
            Inviter un membre — {{ $colocation->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 shadow-xl sm:rounded-2xl p-8">

                @if(session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-green-600/20 border border-green-500/30 text-green-400">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-lg bg-red-600/20 border border-red-500/30 text-red-400">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('invitations.store', $colocation) }}"
                      class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-white/90 mb-2">
                            Email du membre
                        </label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               placeholder="exemple@email.com"
                               class="w-full rounded-lg bg-black/30 border border-white/20 text-white placeholder:text-white/40 focus:ring-2 focus:ring-red-600 focus:border-transparent">
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button type="submit"
                                class="px-8 py-3 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 shadow-lg shadow-red-500/30 transition-all">
                            Envoyer invitation
                        </button>

                        <a href="{{ route('colocations.show', $colocation) }}"
                           class="px-8 py-3 rounded-lg bg-white/5 border border-white/20 text-white font-semibold hover:bg-white/10 transition-all inline-flex items-center">
                            Annuler
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
