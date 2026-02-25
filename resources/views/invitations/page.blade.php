<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invitation</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow space-y-4">
                <div>Colocation: <strong>{{ $inv->colocation->name }}</strong></div>

                <div class="flex gap-3">
                    <form method="POST" action="{{ route('invitation.accept', $inv->token) }}">
                        @csrf
                        <button class="px-4 py-2 bg-green-600 text-white rounded">Accepter</button>
                    </form>

                    <form method="POST" action="{{ route('invitation.refuse', $inv->token) }}">
                        @csrf
                        <button class="px-4 py-2 bg-red-600 text-white rounded">Refuser</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>