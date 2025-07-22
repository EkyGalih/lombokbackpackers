<x-guest-layout>
    @section('title', '404')

    <div class="flex items-center justify-center min-h-screen bg-gray-50 dark:bg-gray-900 px-4">
        <div class="text-center max-w-md">
            <h1 class="text-5xl font-extrabold text-teal-600 dark:text-teal-400">404</h1>
            <h2 class="mt-4 text-2xl font-semibold text-gray-900 dark:text-white">
                {{ __('message.404.title') }}
            </h2>
            <p class="mt-2 text-gray-600 dark:text-gray-300">
                {{ __('message.404.subtitle') }}
            </p>
            <button onclick="return history.back(-1)"
                class="inline-flex mt-6 items-center px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-sm font-medium rounded-md shadow-sm">
                ⬅️ {{ __('message.404.button') }}
            </button>
        </div>
    </div>
</x-guest-layout>
