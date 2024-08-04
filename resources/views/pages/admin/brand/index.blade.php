@extends('layouts.admin')

<!-- content -->
@section('content')
<div class="container">
    <div class="my-3">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.brand.create') }}" class="btn btn-success my-3">
                Add new <i class="fa-solid fa-plus"></i>
            </a>
            <div class="d-flex gap-2" style="height: max-content">
                <select class="form-select" id="select-action">
                    <option value="" selected>Action</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                    <option value="delete">Delete</option>
                </select>
                <button class="btn btn-outline-success" id="select-submit">Submit</button>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr class="table-primary">
                    <th class="">
                        <input class="form-check-input" type="checkbox" id="checked-all">
                    </th>
                    <th class="">Name</th>
                    <th class="">Active</th>
                    <th class="">Updated</th>
                    <th class="">Created</th>
                    <th class="">Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($brands as $index => $brand)
                <tr>
                    <td class="position-relative">
                        <label for="check-item-{{$index}}" class="position-absolute top-0 start-0 w-100 h-100 z-3"></label>
                        <input class="form-check-input" type="checkbox" value="{{$brand->id}}" name="check-item" id="check-item-{{$index}}">
                    </td>
                    <td>{{ $brand->name }}</td>
                    <td>
                        <input class="form-check-input" type="checkbox" onclick="((e)=>{e.preventDefault()})(event)" {{$brand->is_active ? 'checked':''}} name="active-item">
                    </td>
                    <td>
                        {{ $brand->updated_at->diffForHumans() }}
                    </td>
                    <td>
                        {{ $brand->created_at->diffForHumans() }}
                    </td>
                    <td>
                        <a href="{{ route('admin.brand.edit', $brand) }}" class="btn btn-outline-info">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <form action="{{ route('admin.brand.destroy', $brand) }}" method="POST" style="display:inline" onsubmit="confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

        <!-- Paginate -->
        @include('common.pagination')
    </div>
</div>

<form action="" id="checkbox-form">
    @csrf
</form>
<script>
    const routeUpdate = "{{ route('api.brand.updateStatus') }}";
    const routeDelete = "{{ route('api.brand.deleteMany') }}";
    const httpReferer = "{{isset($httpReferer)? $httpReferer : asset('admin.brand.index')}}"
</script>
<script src="{{asset('js/admin/selectIndex.js')}}"></script>
@endsection