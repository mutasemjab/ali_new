@php $socialCount = $store->socials->count(); @endphp

<div class="social-stack">
    @foreach($store->socials as $social)
    <a href="{{ $social->link }}" target="_blank" rel="noopener" class="social-row reveal" style="transition-delay:{{ min($loop->index * 70, 300) }}ms;">
        <div class="social-row-icon">
            <img src="{{ asset($social->photo) }}" alt="{{ $social->name }}">
        </div>
        <div class="social-row-title">Follow Us : {{ $social->name }}</div>
        <i class="bi bi-chevron-left social-row-chevron"></i>
    </a>
    @endforeach

    <a href="{{ route('public.stores.feedback.create', $store->id) }}" class="social-row reveal" style="transition-delay:{{ min($socialCount * 70, 300) }}ms;">
        <div class="social-row-icon d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg, var(--primary-1), var(--primary-2));">
            <i class="bi bi-chat-heart-fill" style="color:#fff;font-size:1.3rem;"></i>
        </div>
        <div class="social-row-title">Keep Comment</div>
        <i class="bi bi-chevron-left social-row-chevron"></i>
    </a>
</div>
