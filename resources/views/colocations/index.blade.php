<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes colocations
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex items-center justify-between mb-6">
                    <div class="text-lg font-bold">Liste</div>
                    <a href="{{ route('colocations.create') }}"
                       class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                        + Nouvelle colocation
                    </a>
                </div>

                @if ($colocations->isEmpty())
                    <div class="text-gray-700">Aucune colocation.</div>
                @else
                    <ul class="divide-y">
                        @foreach($colocations as $colocation)
                            <li class="py-3 flex justify-between">
                                <div>
                                    <div class="font-semibold">{{ $colocation->name }}</div>
                                    <div class="text-sm text-gray-600">
                                        Status: {{ $colocation->status }}
                                        @if($colocation->pivot?->role)
                                            • Rôle: {{ $colocation->pivot->role }}
                                        @endif
                                    </div>
                                </div>
                                <a class="text-indigo-600 hover:underline"
                                   href="{{ route('colocations.show', $colocation) }}">
                                    Voir
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>