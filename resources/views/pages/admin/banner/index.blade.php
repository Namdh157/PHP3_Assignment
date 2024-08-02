@extends ('layouts.admin')

<!-- content -->
@section('content')
<div class="container">
    <div class="my-3">
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.banner.create') }}" class="btn btn-success my-3">
                Add new <i class="fa-solid fa-plus"></i>
            </a>
            <div class="d-flex gap-2" style="height: max-content">
                <select class="form-select" id="select-action">
                    <option value="" selected>Action</option>
                    <option value="delete">Delete</option>
                </select>
                <button class="btn btn-outline-success" id="select-submit">Submit</button>
            </div>
        </div>

        <!-- Table -->
        <table class="table table-hover align-middle">
            <thead>
                <tr class="table-primary" style="vertical-align: middle;">
                    <th class="">
                        <input class="form-check-input" type="checkbox" id="checked-all">
                    </th>
                    <th>Name</th>
                    <th>Active</th>
                    <th>Updated at</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banners as $index => $banner)
                <tr role="button">
                    <td class="position-relative" style="width: 10px">
                        <label for="check-item-{{$index}}" class="position-absolute top-0 start-0 w-100 h-100 z-3"></label>
                        <input class="form-check-input" type="checkbox" value="{{$banner->id}}" name="check-item" id="check-item-{{$index}}">
                    </td>
                    <td>
                        <img src="{{asset($banner->thumbnail)}}" alt="" class="object-fit-contain me-2" style="width: 100px">
                        {{$banner->name}}
                    </td>
                    <td class="">
                        <input class="form-check-input" type="checkbox" onclick="((e)=>{e.preventDefault()})(event)" {{$banner->is_active ? 'checked':''}} name="active-item">
                    </td>
                    <td>
                        <span class="text-muted text-nowrap">{{ $banner->updated_at->diffForHumans() }}</span>
                    </td>
                    <td>
                        <span class="text-muted text-nowrap">{{ $banner->created_at->diffForHumans() }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.banner.edit', $banner) }}" class="btn btn-outline-info">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <form action="{{ route('admin.banner.destroy', $banner) }}" method="POST" style="display:inline" onsubmit="confirmDelete(event)">
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

@endsection
<!-- file Javascript -->
@section('script')

<!-- Config Script -->
<script>
    const routePost = "{{route('admin.banner.store')}}";
    const routeUpdate = null;
    const routeDelete = "{{ route('api.banner.deleteMany') }}";
    const httpReferer = "{{isset($httpReferer)? $httpReferer : asset('admin.banner.index')}}"
</script>

<!-- Handle Script -->
<script src="{{asset('js/admin/selectIndex.js')}}"></script>
@endsection