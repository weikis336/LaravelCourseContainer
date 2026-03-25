<x-layouts.admin-panels>
  <x-slot name="header">
    <x-header-admin title="Faqs" />
  </x-slot>
  <x-crud>
    <x-slot name="table">
      <x-tables.faqs :records="$records"></x-tables.faqs>
    </x-slot>
    <x-slot name="form">
      <x-forms.faqs :record="$record"></x-forms.faqs>
    </x-slot>
  </x-crud>
</x-layouts.admin-panels>