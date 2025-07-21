<div x-data="{ open: false }" class="relative">
    <!-- Tombol -->
    <button @click="open = true"
        class="bg-lime-300 text-slate-900 px-5 py-2 rounded-lg shadow hover:bg-lime-200 transition">
        {{ __('button.book_now') }}
    </button>

    <!-- Overlay -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black bg-opacity-50 z-40">
    </div>

    <!-- Modal -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div @click.away="open = false" class="bg-white rounded-xl shadow-2xl p-8 w-full max-w-lg relative">

            <!-- Close button -->
            <button @click="open = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                ✖
            </button>

            <h2 class="text-2xl font-bold mb-6 text-teal-600">
                {{ __('message.form.title') }}
            </h2>

            <form method="POST" action="{{ route('book') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('message.form.name') }}</label>
                    <input type="text" name="nama" required
                        class="mt-1 block w-full rounded-lg text-slate-900 border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('message.form.pax') }}</label>
                    <input type="number" name="pax" required
                        class="mt-1 block w-full rounded-lg text-slate-900 border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('message.form.national') }}</label>
                    <input type="text" name="nationality" required
                        class="mt-1 block w-full rounded-lg text-slate-900 border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div x-data="{
                    selectedProgram: '{{ $selectedProgramId ?? '' }}',
                    selectedPacket: '',
                    programs: @js($programs),
                    getPackets() {
                        const prog = this.programs.find(p => p.id == this.selectedProgram);
                        if (!prog) return [];
                        const str = prog.packet ?? '';
                        return str.split(',').map(s => s.trim());
                    }
                }">
                    <!-- Program -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Program</label>
                        <select name="program" x-model="selectedProgram"
                            class="mt-1 block w-full rounded-lg text-slate-900 border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500">
                            <option value="">Pilih Program</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program['id'] }}">{{ $program['title'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Packet -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700">Packet</label>
                        <select name="packet"
                            class="mt-1 block w-full rounded-lg text-slate-900 border-gray-300 shadow-sm bg-gray-100">
                            <option value="">Pilih Paket</option>
                            <template x-for="pkt in getPackets()" :key="pkt">
                                <option x-text="pkt" :value="pkt"></option>
                            </template>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('message.form.dep_date') }}</label>
                    <input type="date" name="dep_date" required
                        class="mt-1 block w-full rounded-lg text-slate-900 border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">{{ __('message.form.message') }}</label>
                    <textarea name="pesan" rows="3"
                        class="mt-1 block w-full rounded-lg text-slate-900 border-gray-300 shadow-sm focus:ring-teal-500 focus:border-teal-500"></textarea>
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" @click="open = false"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                        {{ __('message.form.cancel') }}
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-teal-600 to-lime-600 text-white rounded-lg shadow hover:from-teal-700 hover:to-lime-700 transition">
                        {{ __('message.form.send') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
