@extends('layouts.admin')

@section('content')
<style>
    .card-hover {
        transition: 0.2s;
    }

    .card-hover:hover {
        transform: scale(1.04);
    }
</style>

<div class="d-flex flex-wrap gap-5 px-5">
    <a href="{{route('admin.banner.create')}}" class="card card-hover border-4 mt-4 text-decoration-none" style="width: 330px; height: 200px">
        <div class="card-body d-flex align-items-center justify-content-center">
            <i class="fa-solid fa-plus" style="font-size: 50px;"></i>
        </div>
    </a>
    @foreach ($banners as $banner)
    <div class="card border-0 mt-4" style="width: 330px; ">
        <a href="{{route('admin.banner.edit', $banner->id)}}" class="card-body p-0 card-hover border-4" style="height: 200px">
            <img src="{{asset($banner->image)}}" class="w-100 h-100 object-fit-cover rounded" alt="">
        </a>
        <div class="fw-bold fs-6 px-3 row gap-2 align-items-center mt-3">
            <!-- Name -->
            <input type="text" value="{{$banner->name}}" class="col form-control" readonly>

            <!-- Active -->
            <form action="{{route('api.banner.setActiveOn', $banner->id)}}" method="post" class="col-3 p-0" onsubmit="toggleActive(event)" data-active-id="{{$banner->id}}">
                @csrf
                @method('put')
                <button class="btn w-100 {{$banner->is_active?'btn-success':'btn-outline-success'}}" type="{{$banner->is_active?'button':'submit'}}">
                    Active
                </button>
            </form>
            <!-- Delete -->
            <form action="{{route('admin.banner.destroy', $banner->id)}}" method="post" class="col-2 p-1" onsubmit="confirmDelete(event)">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-outline-danger w-100">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('script')
<script>
    function toggleActive(e) {
        e.preventDefault();
        if (confirm('Do you want to change active banner?')) {
            const routeUpdateActive = e.target.action;
            const formData = new FormData(e.target);

            const callbackSuccess = (id) => {
                const prevActive = document.querySelector(`form[data-active-id] button[type="button"]`);
                const newActive = document.querySelector(`form[data-active-id="${id}"] button`);

                prevActive.classList.toggle('btn-success');
                prevActive.classList.toggle('btn-outline-success');
                prevActive.type = 'submit';

                newActive.classList.toggle('btn-success');
                newActive.classList.toggle('btn-outline-success');
                newActive.type = 'button';
            }
            
            postFormData(routeUpdateActive, formData, callbackSuccess)
        }
    }
</script>
@endsection