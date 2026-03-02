<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white">Invitation à rejoindre une colocation</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 shadow-xl sm:rounded-2xl p-8">
                
                <div class="text-center mb-8">
                    <div class="text-5xl mb-4">🏠</div>
                    <h3 class="text-2xl font-semibold text-white mb-2">Vous êtes invité !</h3>
                    <p class="text-white/70">Colocation : <strong class="text-white">{{ $inv->colocation->name }}</strong></p>
                </div>

                <div class="flex gap-4 justify-center">
                    <form method="POST" action="{{ route('invitation.accept', $inv->token) }}">
                        @csrf
                        <button class="px-8 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 shadow-lg shadow-green-500/30 transition-all">
                            Accepter
                        </button>
                    </form>

                    <form method="POST" action="{{ route('invitation.refuse', $inv->token) }}">
                        @csrf
                        <button class="px-8 py-3 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 shadow-lg shadow-red-500/30 transition-all">
                            Refuser
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
