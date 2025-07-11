<x-filament::page>
    <div class="space-y-6">
        <div
            class="bg-gradient-to-br from-white to-gray-50 shadow-lg rounded-xl p-8 transform transition hover:-translate-y-1 hover:shadow-2xl duration-300">

            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Name</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 animate-fade-in">
                        {{ $record->name }}
                        @if ($record->user && $record->user->email_verified_at)
                            <span
                                class="inline-flex items-center px-1 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 animate-fade-in align-top ml-2 -mt-2 relative"
                                style="top: -0.5rem;"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="currentColor">
                                    <circle cx="12" cy="12" r="10" fill="#3897f0"/>
                                    <path d="M17.5 8.5l-6.25 6.25-2.75-2.75" stroke="#fff" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span class="text-xs">Verified</span>
                            </span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 animate-fade-in">{{ $record->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Phone</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 animate-fade-in">{{ $record->phone }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 animate-fade-in">{{ $record->address }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Nationality</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 animate-fade-in">{{ $record->nationality }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Gender</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 animate-fade-in">{{ $record->gender }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 animate-fade-in">{{ $record->date_of_birth }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</x-filament::page>
