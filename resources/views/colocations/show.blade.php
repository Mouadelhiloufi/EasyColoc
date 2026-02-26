<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $colocation->name }}
            </h2>

            



            <div class="flex items-center gap-2">
    <a href="{{ route('invitations.create', $colocation) }}"
       class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
        Ajouter
    </a>

    <a href="{{ route('colocations.edit', $colocation) }}"
       class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">
        Modifier
    </a>

    <form method="POST" action="{{ route('colocations.destroy', $colocation) }}"
          onsubmit="return confirm('Annuler cette colocation ?');">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">
            Annuler
        </button>
    </form>

    <form method="POST" action="{{ route('leave', $colocation) }}">
        @csrf
        <button class="px-4 py-2 rounded bg-gray-800 text-white hover:bg-gray-900">
            Quitter
        </button>
    </form>
</div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <div class="text-sm text-gray-600">
                    Status : <span class="font-medium">{{ $colocation->status }}</span>
                    @if($colocation->cancelled_at)
                        • Annulée le : {{ \Carbon\Carbon::parse($colocation->cancelled_at)->format('Y-m-d') }}
                    @endif
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Membres</h3>

                    @if($colocation->users->isEmpty())
                        <div class="text-gray-600 text-sm">Aucun membre.</div>
                    @else
                        <ul class="divide-y">
                            @foreach($colocation->users->whereNull('pivot.left_at') as $user)
                                <li class="py-3 flex items-center justify-between">
                                    <div>
                                        <div class="font-medium">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-600">{{ $user->email }}</div>
                                        <div class="text-sm text-gray-600">
                                            Rôle: {{ $user->pivot->role }} • Score: {{ $user->pivot->score ?? 0 }}
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <span class="text-sm px-2 py-1 rounded bg-gray-100">
                                            {{ $user->pivot->role }}
                                        </span>

                                        {{-- Retirer (toujours affiché pour tous) --}}
                                        <form method="POST" action="{{ route('remove', [$colocation, $user]) }}"
                                              onsubmit="return confirm('Retirer ce membre ?');">
                                            @csrf
                                            <button type="submit"
                                                    class="px-3 py-1 rounded bg-red-600 text-white">
                                                Retirer
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Dépenses</h3>

                    @if($colocation->expenses->isEmpty())
                        <div class="text-gray-600 text-sm">Aucune dépense.</div>
                    @else
                        <ul class="divide-y">
                            @foreach($colocation->expenses as $expense)
                                <li class="py-3">
                                    <div class="font-medium">
                                        {{ $expense->title }} — {{ $expense->amount }}
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        {{ $expense->date }}
                                        • {{ $expense->category?->name ?? 'Sans catégorie' }}
                                        • Payeur: {{ $expense->payer?->email ?? '-' }}
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>

            <div>
                <a href="{{ route('colocations.index') }}"
                   class="text-indigo-600 hover:underline">
                    ← Retour à la liste
                </a>
            </div>

        </div>
    </div>
</x-app-layout>