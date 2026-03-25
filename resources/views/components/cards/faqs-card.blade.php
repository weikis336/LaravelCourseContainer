@props(['faqs'])

<style>

</style>

<div class="faqs-grid">
    @forelse ($faqs as $faq)
        <div class="faq-card">
            <h3>{{ $faq->title }}</h3>
            <p>{{ $faq->description }}</p>
        </div>
    @empty
        <div class="faq-empty">
            No hay preguntas frecuentes publicadas por el momento.
        </div>
    @endforelse
</div>