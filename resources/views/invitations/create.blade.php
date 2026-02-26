<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Inviter un membre — {{ $colocation->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                @if(session('success'))
                    <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST"
                      action="{{ route('invitations.store', $colocation) }}"
                      class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Email du membre
                        </label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                            Envoyer invitation
                        </button>

                        <a href="{{ route('colocations.show', $colocation) }}"
                           class="text-gray-700 hover:underline">
                            Annuler
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>