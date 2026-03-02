<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-white">
                {{ $colocation->name }}
            </h2>

            <div class="flex items-center gap-2">
                @php
                    $userRole = $colocation->users->where('id', auth()->id())->first()?->pivot->role;
                @endphp

                @if($userRole === 'owner')
                    <a href="{{ route('colocations.edit', $colocation) }}"
                       class="px-4 py-2 rounded-lg bg-white/5 border border-white/20 text-white hover:bg-white/10 transition-all">
                        Modifier
                    </a>
                @endif

                <form method="POST" action="{{ route('leave', $colocation) }}">
                    @csrf
                    <button class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-all">
                        Quitter
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Actions rapides -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <button type="button"
                    onclick="openCategoryModal()"
                    class="p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl hover:bg-white/10 transition-all group">
                    <div class="text-3xl mb-2">📁</div>
                    <div class="text-white font-semibold">Ajouter catégorie</div>
                </button>

                <button type="button"
                    onclick="openExpenseModal()"
                    class="p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl hover:bg-white/10 transition-all group">
                    <div class="text-3xl mb-2">💰</div>
                    <div class="text-white font-semibold">Ajouter dépense</div>
                </button>

                <a href="{{ route('invitations.create', $colocation) }}"
                   class="p-6 bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl hover:bg-white/10 transition-all group">
                    <div class="text-3xl mb-2">👥</div>
                    <div class="text-white font-semibold">Ajouter membre</div>
                </a>
            </div>

            <!-- Status -->
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-6">
                <div class="text-sm text-white/70">
                    Status : <span class="font-medium text-white">{{ $colocation->status }}</span>
                    @if($colocation->cancelled_at)
                        • Annulée le : {{ \Carbon\Carbon::parse($colocation->cancelled_at)->format('Y-m-d') }}
                    @endif
                </div>
            </div>

            <!-- Membres et Dettes -->
            <div class="grid md:grid-cols-2 gap-6">

                <!-- Membres -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-6">
                    <h3 class="font-semibold text-white text-lg mb-4">Membres</h3>

                    @if($colocation->users->isEmpty())
                        <div class="text-white/60 text-sm">Aucun membre.</div>
                    @else
                        <ul class="space-y-3">
                            @foreach($colocation->users->whereNull('pivot.left_at') as $user)
                                <li class="p-4 bg-white/5 rounded-lg border border-white/10">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="font-medium text-white">{{ $user->name }}</div>
                                            <div class="text-sm text-white/60">{{ $user->email }}</div>
                                            <div class="text-sm text-white/60 mt-1">
                                                Rôle: {{ $user->pivot->role }} • Score: {{ $user->pivot->score ?? 0 }}
                                            </div>
                                        </div>

                                        @if($userRole === 'owner')
                                            <form method="POST" action="{{ route('remove', [$colocation, $user]) }}"
                                                  onsubmit="return confirm('Retirer ce membre ?');">
                                                @csrf
                                                <button type="submit"
                                                        class="px-3 py-1.5 rounded-lg bg-red-600 text-white text-sm hover:bg-red-700 transition-all">
                                                    Retirer
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <!-- Dettes -->
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-6">
                    <h3 class="font-semibold text-white text-lg mb-4">Qui doit à qui</h3>

                    @php
                        $list = isset($debts) ? $debts : $colocation->debts->where('status','unpaid');
                    @endphp

                    @if($list->isEmpty())
                        <div class="text-white/60 text-sm">Tout est équilibré ✅</div>
                    @else
                        <ul class="space-y-3">
                            @foreach($list as $d)
                                <li class="p-4 bg-white/5 rounded-lg border border-white/10">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="text-white text-sm">
                                            <strong>{{ $d->debiteurUser?->name ?? 'User' }}</strong>
                                            doit à
                                            <strong>{{ $d->crediteurUser?->name ?? 'User' }}</strong>
                                        </div>
                                        <span class="px-3 py-1 rounded-lg bg-red-600/20 text-red-400 text-sm font-semibold">
                                            {{ number_format($d->amount, 2) }} €
                                        </span>
                                    </div>
                                    <form method="POST" action="{{ route('debts.pay', $d) }}">
                                        @csrf
                                        <button class="w-full px-3 py-1.5 rounded-lg bg-green-600 text-white text-sm hover:bg-green-700 transition-all">
                                            Marquer payé
                                        </button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

            </div>

            <!-- Dépenses -->
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-white text-lg">Dépenses</h3>
                    
                    <form method="GET" class="flex gap-2">
                        <input type="number" name="month" min="1" max="12"
                               placeholder="Mois"
                               value="{{ request('month') }}"
                               class="border-white/20 bg-black/30 text-white placeholder:text-white/40 rounded-lg px-3 py-1.5 text-sm">

                        <input type="number" name="year"
                               placeholder="Année"
                               value="{{ request('year') }}"
                               class="border-white/20 bg-black/30 text-white placeholder:text-white/40 rounded-lg px-3 py-1.5 text-sm">

                        <button class="px-4 py-1.5 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 transition-all">
                            Filtrer
                        </button>
                    </form>
                </div>

                @if($expenses->isEmpty())
                    <div class="text-white/60 text-sm">Aucune dépense.</div>
                @else
                    <ul class="space-y-3">
                        @foreach($expenses as $expense)
                            <li class="p-4 bg-white/5 rounded-lg border border-white/10">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-medium text-white">{{ $expense->title }}</div>
                                        <div class="text-sm text-white/60 mt-1">
                                            {{ $expense->date }}
                                            • {{ $expense->category?->name ?? 'Sans catégorie' }}
                                            • Payeur: {{ $expense->payer?->name ?? '-' }}
                                        </div>
                                    </div>
                                    <span class="text-white font-semibold">{{ $expense->amount }} €</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div>
                <a href="{{ route('colocations.index') }}"
                   class="text-red-400 hover:text-red-300 transition-colors">
                    ← Retour à la liste
                </a>
            </div>

        </div>
    </div>

    <!-- Modal Dépense -->
    <div id="expenseModal" class="fixed inset-0 hidden items-center justify-center bg-black/70 backdrop-blur-sm z-50">
        <div class="bg-gradient-to-br from-gray-900 to-black border border-white/10 w-full max-w-lg rounded-2xl shadow-2xl p-8">

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Nouvelle dépense</h3>
                <button onclick="closeExpenseModal()" class="text-white/60 hover:text-white text-2xl">✕</button>
            </div>

            <form method="POST" action="{{ route('expenses.store', $colocation) }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-white/90 mb-2">Titre</label>
                    <input type="text" name="title"
                           class="w-full rounded-lg bg-black/30 border border-white/20 text-white placeholder:text-white/40 focus:ring-2 focus:ring-red-600"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-white/90 mb-2">Montant</label>
                    <input type="number" step="0.01" name="amount"
                           class="w-full rounded-lg bg-black/30 border border-white/20 text-white placeholder:text-white/40 focus:ring-2 focus:ring-red-600"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-white/90 mb-2">Date</label>
                    <input type="date" name="date"
                           class="w-full rounded-lg bg-black/30 border border-white/20 text-white placeholder:text-white/40 focus:ring-2 focus:ring-red-600"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-white/90 mb-2">Catégorie</label>
                    <select name="category_id"
                            class="w-full rounded-lg bg-black/30 border border-white/20 text-white focus:ring-2 focus:ring-red-600">
                        <option value="">Sélectionner catégorie</option>
                        @foreach($colocation->categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                            onclick="closeExpenseModal()"
                            class="px-6 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white hover:bg-white/10 transition-all">
                        Annuler
                    </button>

                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition-all">
                        Ajouter
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Modal Catégorie -->
    <div id="categoryModal" class="fixed inset-0 hidden items-center justify-center bg-black/70 backdrop-blur-sm z-50">
        <div class="bg-gradient-to-br from-gray-900 to-black border border-white/10 w-full max-w-lg rounded-2xl shadow-2xl p-8">

            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Nouvelle catégorie</h3>
                <button onclick="closeCategoryModal()" class="text-white/60 hover:text-white text-2xl">✕</button>
            </div>

            <form method="POST" action="{{ route('categories.store', $colocation) }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-white/90 mb-2">Nom</label>
                    <input type="text" name="name"
                           class="w-full rounded-lg bg-black/30 border border-white/20 text-white placeholder:text-white/40 focus:ring-2 focus:ring-red-600"
                           required>
                </div>

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button"
                            onclick="closeCategoryModal()"
                            class="px-6 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white hover:bg-white/10 transition-all">
                        Annuler
                    </button>

                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition-all">
                        Ajouter
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
    function openExpenseModal() {
        document.getElementById('expenseModal').classList.remove('hidden');
        document.getElementById('expenseModal').classList.add('flex');
    }

    function closeExpenseModal() {
        document.getElementById('expenseModal').classList.add('hidden');
        document.getElementById('expenseModal').classList.remove('flex');
    }

    function openCategoryModal() {
        document.getElementById('categoryModal').classList.remove('hidden');
        document.getElementById('categoryModal').classList.add('flex');
    }

    function closeCategoryModal() {
        document.getElementById('categoryModal').classList.add('hidden');
        document.getElementById('categoryModal').classList.remove('flex');
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeExpenseModal();
            closeCategoryModal();
        }
    });
    </script>

</x-app-layout>
