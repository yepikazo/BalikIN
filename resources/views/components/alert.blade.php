@if (session('success'))
    <div class="bk-alert bk-alert--success" style="margin-bottom:1.25rem">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="bk-alert bk-alert--error" style="margin-bottom:1.25rem">{{ session('error') }}</div>
@endif
@if ($errors->any())
    <div class="bk-alert bk-alert--error" style="margin-bottom:1.25rem">
        @foreach ($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif
