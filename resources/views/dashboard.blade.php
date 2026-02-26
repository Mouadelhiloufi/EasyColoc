<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <!-- Bouton ouvrir modal -->
            <button type="button"
                    onclick="openInviteModal()"
                    class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                Entrer un lien d’invitation
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="inviteModal" class="fixed inset-0 hidden items-center justify-center bg-black/50 z-50">
        <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Coller le lien d’invitation</h3>
                <button type="button"
                        onclick="closeInviteModal()"
                        class="text-gray-500 hover:text-gray-700">
                    ✕
                </button>
            </div>

            <form onsubmit="openInviteLink(event)" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lien</label>
                    <input type="text"
                           id="invitation_link"
                           class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                           placeholder="https://easycoloc.test/invitation/XXXX"
                           required>
                </div>

                <div class="flex justify-end gap-2">
                    <button type="button"
                            onclick="closeInviteModal()"
                            class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200">
                        Annuler
                    </button>

                    <button type="submit"
                            class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">
                        Ouvrir
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openInviteModal() {
            const modal = document.getElementById('inviteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => document.getElementById('invitation_link').focus(), 50);
        }

        function closeInviteModal() {
            const modal = document.getElementById('inviteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openInviteLink(event) {
            event.preventDefault();
            const link = document.getElementById('invitation_link').value.trim();
            if (!link) return;
            window.location.href = link;
        }

        // Fermer si on clique en dehors
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('inviteModal');
            if (modal.classList.contains('hidden')) return;
            if (e.target === modal) closeInviteModal();
        });

        // Fermer avec ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeInviteModal();
        });
    </script>

</x-app-layout>