<x-layouts.general-faqs>
    <x-slot name="header">
        <x-header title="Faqs" />
    </x-slot>
    <x-slot>
        <x-faqs-card :faqs="$faqs" />
    </x-slot>

</x-layouts.general-faqs>