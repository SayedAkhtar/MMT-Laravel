<div class="row mb-2">
    <div class="col-sm-6">
        <h1>{{ $module?? 'Dashboard' }}</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active text-capitalize">{{ Route::current()->uri }}</li>
        </ol>
    </div>
</div>