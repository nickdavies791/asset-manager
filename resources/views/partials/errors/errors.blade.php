@if ($errors->any())
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
            <div>
                <span class="alert-inner--icon pr-2"><i class="fas fa-exclamation-triangle"></i></span>
                <span class="alert-inner--text">{{ $error }}</span>
            </div>
        @endforeach
    </div>
@endif