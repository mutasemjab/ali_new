@extends('public.layouts.app')
@section('title', 'اترك ملاحظة — ' . $store->name)

@section('content')

<div class="surface-card reveal">
    <div class="section-title"><i class="bi bi-chat-heart me-1"></i> شاركنا رأيك</div>
    <div class="section-sub">ملاحظتك تساعدنا نتحسن أكثر</div>

    @if(session('success'))
        <div class="alert-modern alert-success">
            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert-modern alert-danger">
            <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('public.stores.feedback.store', $store->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label-modern">الاسم</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-modern" required>
        </div>
        <div class="mb-3">
            <label class="form-label-modern">رقم الهاتف</label>
            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control form-control-modern" required>
        </div>
        <div class="mb-4">
            <label class="form-label-modern">ملاحظتك</label>
            <textarea name="message" rows="4" class="form-control form-control-modern" required>{{ old('message') }}</textarea>
        </div>
        <button type="submit" class="btn btn-gradient w-100">
            <i class="bi bi-send-fill me-1"></i> إرسال
        </button>
    </form>
</div>

@endsection
