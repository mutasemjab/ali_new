@extends('public.layouts.app')
@section('title', 'اترك ملاحظة — ' . $store->name)

@section('content')

<h1 class="h4 fw-bold mb-3">اترك لنا ملاحظتك</h1>
<p class="text-muted small mb-4">{{ $store->name }}</p>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<form action="{{ route('public.stores.feedback.store', $store->id) }}" method="POST" class="bg-white rounded-3 p-3 shadow-sm">
    @csrf
    <div class="mb-3">
        <label class="form-label">الاسم</label>
        <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">رقم الهاتف</label>
        <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label class="form-label">ملاحظتك</label>
        <textarea name="message" rows="4" class="form-control" required>{{ old('message') }}</textarea>
    </div>
    <button type="submit" class="btn btn-primary w-100">إرسال</button>
</form>

@endsection
