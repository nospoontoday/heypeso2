<x-layouts.app :title="__('Time Manipulation')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">{{ __('Time Manipulation') }}</h1>
        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                <h3 class="text-lg font-semibold">{{ __('Current Time') }}</h3>
                <p class="text-gray-600 dark:text-gray-400 mt-2">{{ now()->format('Y-m-d H:i:s') }}</p>
                @if(session('manipulated_time'))
                    <p class="text-green-600 dark:text-green-400 mt-2">{{ __('Manipulated Time: ') . \Carbon\Carbon::parse(session('manipulated_time'))->format('Y-m-d H:i:s') }}</p>
                @endif
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-4">
                <h3 class="text-lg font-semibold">{{ __('Manipulate Time') }}</h3>
                <form method="POST" action="{{ route('time.manipulate') }}" class="mt-4 space-y-4">
                    @csrf
                    <div>
                        <label for="add_days" class="block text-sm font-medium">{{ __('Add Days') }}</label>
                        <input type="number" id="add_days" name="add_days" min="0" max="365" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 shadow-sm">
                    </div>
                    <div>
                        <label for="add_hours" class="block text-sm font-medium">{{ __('Add Hours') }}</label>
                        <input type="number" id="add_hours" name="add_hours" min="0" max="1000" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-800 shadow-sm">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">{{ __('Apply') }}</button>
                        <a href="{{ route('time.reset') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">{{ __('Reset') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>