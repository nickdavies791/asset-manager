@if (session('alert.primary'))
    <div class="alert alert-growl alert-primary alert-dismissible fade show" role="alert">
        <span class="alert-inner--icon pr-2"><i class="fas fa-bell"></i></span>
        <span class="alert-inner--text">{{ session('alert.primary') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('alert.info'))
    <div class="alert alert-growl alert-info alert-dismissible fade show" role="alert">
        <span class="alert-inner--icon pr-2"><i class="fas fa-info-circle"></i></span>
        <span class="alert-inner--text">{{ session('alert.info') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('alert.success'))
    <div class="alert alert-growl alert-success alert-dismissible fade show" role="alert">
        <span class="alert-inner--icon pr-2"><i class="fas fa-check-circle"></i></span>
        <span class="alert-inner--text">{{ session('alert.success') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('alert.danger'))
    <div class="alert alert-growl alert-danger alert-dismissible fade show" role="alert">
        <span class="alert-inner--icon pr-2"><i class="fas fa-exclamation-triangle"></i></span>
        <span class="alert-inner--text">{{ session('alert.danger') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('alert.warning'))
    <div class="alert alert-growl alert-warning alert-dismissible fade show" role="alert">
        <span class="alert-inner--icon pr-2"><i class="fas fa-exclamation-triangle"></i></span>
        <span class="alert-inner--text">{{ session('alert.warning') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<asset-created-notification></asset-created-notification>