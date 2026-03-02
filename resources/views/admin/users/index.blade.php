<x-layouts.admin>
    <x-slot name="header">
        <x-header title="Users" />
    </x-slot>
    <x-crud>
      <x-slot name="table">
        <x-tables.users :records="$records"></x-tables.users>
      </x-slot>
      <x-slot name="form">
        <x-forms.users :record="$record"></x-forms.users>
      </x-slot>
    </x-crud>
</x-layouts.admin>
