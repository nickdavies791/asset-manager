<div class="form-group mb-0">
    <label>Asset Type:</label>
    <span>{{ $asset->type->name }}</span>
</div>
<div class="form-group mb-0">
    <label>Serial Number:</label>
    <span>{{ $asset->serial_number }}</span>
</div>
<div class="form-group mb-0">
    <label>Make/Model:</label>
    <span>{{ $asset->make }} {{ $asset->model }}</span>
</div>
<div class="form-group mb-0">
    <label>Processor:</label>
    <span>{{ $asset->processor }}</span>
</div>
<div class="form-group mb-0">
    <label>Memory/RAM:</label>
    <span>{{ $asset->memory }}</span>
</div>
<div class="form-group mb-0">
    <label>Storage (HDD/SSD):</label>
    <span>{{ $asset->storage }}</span>
</div>
<div class="form-group mb-0">
    <label>Operating System:</label>
    <span>{{ $asset->operating_system }}</span>
</div>