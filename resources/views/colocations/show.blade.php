<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $colocation->name }}
            </h2>

            



            <div class="flex items-center gap-2">
    <a href="{{ route('invitations.create', $colocation) }}"
       class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
        Ajouter membre
    </a>

    <button type="button"
        onclick="openCategoryModal()"
        class="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700">
    Ajouter catégorie
</button>

    <button type="button"
        onclick="openExpenseModal()"
        class="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700">
    Ajouter dépense
    </button>

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
    <h3 class="font-semibold mb-4">Qui doit à qui</h3>

    @php
        $list = isset($debts) ? $debts : $colocation->debts->where('status','unpaid');
    @endphp

    @if($list->isEmpty())
        <div class="text-gray-600 text-sm">Tout est équilibré ✅</div>
    @else
        <ul class="divide-y">
            @foreach($list as $d)
                <li class="py-3 flex items-center justify-between">
                    <div class="text-gray-800">
                        <strong>{{ $d->debiteurUser?->name ?? 'User' }}</strong>
                        doit à
                        <strong>{{ $d->crediteurUser?->name ?? 'User' }}</strong>
                    </div>
                    

                    <span class="px-3 py-1 rounded bg-indigo-100 text-indigo-800 text-sm">
                        {{ number_format($d->amount, 2) }}
                    </span>
                    <form method="POST" action="{{ route('debts.pay', $d) }}">
                        @csrf
                    <button class="px-3 py-1 rounded bg-green-600 text-white">
                     Marquer payé
                  </button>
            </form>
                </li>
                
            @endforeach
        </ul>
    @endif
</div>



                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Dépenses</h3>

                    @if($expenses->isEmpty())
                        <div class="text-gray-600 text-sm">Aucune dépense.</div>
                    @else
                        <ul class="divide-y">
                            @foreach($expenses as $expense)
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

            <form method="GET" class="flex gap-2 mb-4">
    <input type="number" name="month" min="1" max="12"
           placeholder="Mois"
           value="{{ request('month') }}"
           class="border rounded px-2 py-1">

    <input type="number" name="year"
           placeholder="Année"
           value="{{ request('year') }}"
           class="border rounded px-2 py-1">

    <button class="px-3 py-1 bg-indigo-600 text-white rounded">
        Filtrer
    </button>
</form>

            <div>
                <a href="{{ route('colocations.index') }}"
                   class="text-indigo-600 hover:underline">
                    ← Retour à la liste
                </a>
            </div>

        </div>
    </div>

    <!-- Modal Dépense -->
<div id="expenseModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Nouvelle dépense</h3>
            <button onclick="closeExpenseModal()" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>

        <form method="POST" action="{{ route('expenses.store', $colocation) }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium">Titre</label>
                <input type="text" name="title"
                       class="w-full rounded border-gray-300 focus:border-green-500 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium">Montant</label>
                <input type="number" step="0.01" name="amount"
                       class="w-full rounded border-gray-300 focus:border-green-500 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium">Date</label>
                <input type="date" name="date"
                       class="w-full rounded border-gray-300 focus:border-green-500 focus:ring-green-500"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium">Catégorie</label>
                <select name="category_id"
                        class="w-full rounded border-gray-300 focus:border-green-500 focus:ring-green-500">
                    <option value="">Selectionner categories</option>
                    @foreach($colocation->categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeExpenseModal()"
                        class="px-4 py-2 rounded bg-gray-200">
                    Annuler
                </button>

                <button type="submit"
                        class="px-4 py-2 rounded bg-green-600 text-white">
                    Ajouter
                </button>
            </div>

        </form>
    </div>
</div>




<script>
function openExpenseModal() {
    const modal = document.getElementById('expenseModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeExpenseModal() {
    const modal = document.getElementById('expenseModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeExpenseModal();
});
</script>



<div id="categoryModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
    <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">

        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Nouvelle catégorie</h3>
            <button onclick="closeCategoryModal()" class="text-gray-500 hover:text-gray-700">✕</button>
        </div>

        <form method="POST" action="{{ route('categories.store', $colocation) }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium">Nom</label>
                <input type="text" name="name"
                       class="w-full rounded border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                       required>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeCategoryModal()"
                        class="px-4 py-2 rounded bg-gray-200">
                    Annuler
                </button>

                <button type="submit"
                        class="px-4 py-2 rounded bg-blue-600 text-white">
                    Ajouter
                </button>
            </div>

        </form>
    </div>
</div>

<script>
function openCategoryModal() {
    const modal = document.getElementById('categoryModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}
function closeCategoryModal() {
    const modal = document.getElementById('categoryModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeCategoryModal();
});
</script>



</x-app-layout>