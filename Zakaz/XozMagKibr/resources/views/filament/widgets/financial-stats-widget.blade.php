<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between w-full">
                <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">
                    {{ $this->heading }}
                </h3>

                <div class="w-48">
                    <form wire:submit.prevent="$refresh">
                        {{ $form }}
                    </form>
                </div>
            </div>
        </x-slot>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            @foreach ($stats as $stat)
                <div class="p-4 rounded-xl shadow bg-white dark:bg-gray-900">
                    <div class="text-sm font-medium text-sky-500 dark:text-sky-400">
                        {{ $stat->getLabel() }}
                    </div>

                    <div class="text-2xl font-bold text-gray-900 dark:text-white">
                        {{ $stat->getValue() }}
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>