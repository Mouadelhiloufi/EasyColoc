<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-white leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <div class="flex items-center gap-3">
                <a href="{{ route('colocations.index') }}"
                   class="px-6 py-2.5 rounded-full bg-red-600 text-white font-semibold hover:bg-red-700 shadow-lg shadow-red-500/30 transition-all duration-200">
                    Mes Colocations
                </a>
                
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="px-6 py-2.5 rounded-full bg-white/5 border border-white/20 text-white font-semibold hover:bg-white/10 transition-all duration-200">
                        Admin Dashboard
                    </a>
                @endif
                
                <button type="button"
                        onclick="openInviteModal()"
                        class="px-6 py-2.5 rounded-full bg-white/5 border border-white/20 text-white font-semibold hover:bg-white/10 transition-all duration-200">
                    Entrer un lien d'invitation
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 overflow-hidden shadow-xl sm:rounded-2xl">
                <div class="p-8 text-white">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-3xl">🎉</span>
                        <h3 class="text-xl font-semibold">Bienvenue sur EasyColoc !</h3>
                    </div>
                    <p class="text-white/70">{{ __("You're logged in!") }}</p>
                </div>
            </div>
        </div>
    </div>

    <div id="inviteModal" class="fixed inset-0 hidden items-center justify-center bg-black/70 backdrop-blur-sm z-50">
        <div class="bg-gradient-to-br from-gray-900 to-black border border-white/10 w-full max-w-lg rounded-2xl shadow-2xl p-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-white">Coller le lien d'invitation</h3>
                <button type="button"
                        onclick="closeInviteModal()"
                        class="text-white/60 hover:text-white text-2xl leading-none transition-colors">
                    ✕
                </button>
            </div>

            <form onsubmit="openInviteLink(event)" class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-white/90 mb-2">Lien</label>
                    <input type="text"
                           id="invitation_link"
                           class="w-full rounded-lg bg-black/30 border border-white/20 text-white placeholder:text-white/40 focus:outline-none focus:ring-2 focus:ring-red-600 focus:border-transparent"
                           placeholder="https://easycoloc.test/invitation/XXXX"
                           required>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button"
                            onclick="closeInviteModal()"
                            class="px-6 py-2.5 rounded-lg bg-white/5 border border-white/10 text-white hover:bg-white/10 transition-all duration-200">
                        Annuler
                    </button>

                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 shadow-lg shadow-red-500/30 transition-all duration-200">
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

        document.addEventListener('click', function(e) {
            const modal = document.getElementById('inviteModal');
            if (modal.classList.contains('hidden')) return;
            if (e.target === modal) closeInviteModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeInviteModal();
        });
    </script>

</x-app-layout>
