@extends('layouts.admin')

@section('content')
<style>
    .input-group-text {
        font-size: 0.9rem;
    }
</style>
<div class="container p-4">
    <div class="d-flex justify-content-end">
        <button class="btn btn-success px-4" onclick="onPostBanner()">Save</button>
    </div>
    <hr>
    <!-- Image -->
    <div class="group">
        <div id="container-image" class="d-flex gap-3 flex-wrap rounded bg-secondary p-4">
            <div>
                <label for="gallery" role="button" class="card card-hover" style="width: 120px; height: 80px">
                    <div class="card-body d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-plus" style="font-size: 40px;"></i>
                    </div>
                </label>
                <input type="file" id="gallery" name="gallery" hidden multiple accept="image/*" onchange="pushImageToContainer(this)">
            </div>
            <!-- List image -->
            @if (isset($listImage))
            @foreach ($listImage as $image)
            <img src="{{asset($image->url)}}" class="rounded" style="width:120px; height: 80px" onclick="onDeleteImage(this)" data-gallery-id="{{$image->id}}" role="button">
            @endforeach
            @endif
        </div>
        <div class="error"></div>
    </div>


    <!-- Config -->
    <div class="card shadow mt-4">
        <div class="card-header fw-bold d-flex justify-content-between " id="active-container">
            <span>Active</span>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" onchange="onChangeActive(this)" {{isset($banner) && $banner->is_active ? 'checked' : ''}}
                >
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <!-- Name -->
                <div class="col-3 group">
                    <label for="code" class="form-label fw-bold">Slide's name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{isset($banner)?$banner->name:''}}" placeholder="Name">
                    <div class="error"></div>
                </div>
                <!-- Width -->
                <div class="col-3 group">
                    <label for="width" class="form-label fw-bold">Width</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="width" name="width" placeholder="Width" value="{{isset($banner)?$banner->width:$defaultWidth}}">
                        <span class="input-group-text">px</span>
                    </div>
                    <div class="error"></div>
                </div>
                <!-- Height -->
                <div class="col-3 group">
                    <label for="height" class="form-label fw-bold">Height</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="height" name="height" placeholder="Height" value="{{isset($banner)?$banner->height:$defaultHeight}}">
                        <span class="input-group-text">px</span>
                    </div>
                    <div class="error"></div>
                </div>
                <!-- Object type -->
                <div class="col-3 group">
                    <label for="object_fit" class="form-label fw-bold">Object type</label>
                    <select class="form-select" name="object_fit" id="object_fit">
                        <option>-- Select a type --</option>
                        @foreach ($objectFit as $type)
                        <option value="{{$type}}" {{isset($banner) && $banner->object_fit == $type ? 'selected':''}}>{{ucwords($type)}}</option>
                        @endforeach
                    </select>
                    <div class="error"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="post" id="postForm">
    @csrf
</form>

@endsection
@section('script')
<!-- Script Config -->
<script>
    const routePost = "{{$routePost}}";
    const httpReferer = "{{$httpReferer}}";
    const method = "{{$method ?? 'POST'}}";
</script>
<!-- Handler Script -->
<script>
    const listGallery = [];
    const deleteGallery = [];

    function pushImageToContainer(input) {
        const container = document.getElementById('container-image');
        const files = input.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            // add to list
            listGallery.push(file);

            // render image
            const reader = new FileReader();
            reader.onload = function(e) {
                let indexOfGallery = listGallery.indexOf(file);
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'rounded';
                img.style.width = '120px';
                img.style.height = '80px';
                img.role = 'button';
                img.onclick = () => onDeleteImage(img)
                container.appendChild(img, indexOfGallery);
            }
            reader.onloadstart = function() {
                loading().on();
            }
            reader.onloadend = function() {
                loading().off();
            }
            reader.readAsDataURL(file);
        }
    }

    function onDeleteImage(img, index = null) {
        if (confirm('Do you want to remove this image?')) {
            document.getElementById('container-image').removeChild(img);
            // remove from list
            index !== null && listGallery.splice(index, 1);
            // thêm vào deleteGallery 
            let galleryId = img.getAttribute('data-gallery-id');
            if (galleryId) {
                deleteGallery.push(galleryId);
                console.log('Delete id: ', deleteGallery);
            }
        }
    }

    function onChangeActive(checkbox) {
        const activeContainer = document.getElementById('active-container');
        if (checkbox.checked) activeContainer.classList.add('bg-info');
        else activeContainer.classList.contains('bg-info') && activeContainer.classList.remove('bg-info');
    }
</script>
<script src="{{$js}}"></script>
@endsection