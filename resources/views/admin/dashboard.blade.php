<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Admin
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid md:grid-cols-3 gap-4">
                <div class="bg-white p-6 rounded shadow">
                    <div class="text-gray-500 text-sm">Total utilisateurs</div>
                    <div class="text-2xl font-bold">{{ $totalUsers }}</div>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <div class="text-gray-500 text-sm">Total colocations</div>
                    <div class="text-2xl font-bold">{{ $totalColocations }}</div>
                </div>

                <div class="bg-white p-6 rounded shadow">
                    <div class="text-gray-500 text-sm">Dépenses totales</div>
                    <div class="text-2xl font-bold">{{ number_format($totalExpenses, 2) }}</div>
                </div>
            </div>


            <div class="bg-white p-6 rounded shadow">
    <h3 class="font-semibold mb-4">Tous les utilisateurs</h3>

    @if($activeUsers->isEmpty())
        <div class="text-gray-600 text-sm">Aucun utilisateur.</div>
    @else
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-gray-500 border-b">
                    <th class="py-2">Nom</th>
                    <th>Email</th>
                    <th class="text-right">Action</th>
                </tr>
            </thead>
            <tbody>
                
                @foreach($activeUsers as $u)
                    <tr class="border-b">
                        <td class="py-2">{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td class="text-right">
                            <form method="POST" action="{{ route('admin.users.ban', $u) }}"
                                  onsubmit="return confirm('Bannir cet utilisateur ?');">
                                @csrf
                                <button class="px-3 py-1 rounded bg-red-600 text-white">
                                    Bannir
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>



            <div class="bg-white p-6 rounded shadow">
                <h3 class="font-semibold mb-4">Utilisateurs bannis</h3>

                @if($bannedUsers->isEmpty())
                    <div class="text-gray-600 text-sm">Aucun utilisateur banni.</div>
                @else
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="py-2">Nom</th>
                                <th>Email</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bannedUsers as $u)
                                <tr class="border-b">
                                    <td class="py-2">{{ $u->name }}</td>
                                    <td>{{ $u->email }}</td>
                                    <td class="text-right">
                                        <form method="POST" action="{{ route('admin.users.unban', $u) }}">
                                            @csrf
                                            <button class="px-3 py-1 rounded bg-green-600 text-white">
                                                Débannir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>