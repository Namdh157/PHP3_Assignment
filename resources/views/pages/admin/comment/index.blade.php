@extends('layouts.admin')

@section('content')

<div class="container">
    <div class="my-3">
        <div class="d-flex justify-content-between align-items-center">
            <form action="">
                <select class="form-select" id="sort-action" name="sort" onchange="onChangeSort(this)">
                    <option value="">-- Sort by --</option>
                    <option value="user" {{$sort === 'user' ? 'selected':''}}>User</option>
                    <option value="product" {{$sort === 'product' ? 'selected':''}}>Product</option>
                    <option value="created_up" {{$sort === 'created_up' ? 'selected':''}}>Created ↑</option>
                    <option value="created_down" {{$sort === 'created_down' ? 'selected':''}}>Created ↓</option>
                </select>
            </form>

            <div class="d-flex gap-2 my-3" style="height: max-content">
                <select class="form-select" id="select-action">
                    <option value="" selected>-- Action --</option>
                    <option value="delete">Delete</option>
                </select>
                <button class="btn btn-outline-success" id="select-submit">Submit</button>
            </div>
        </div>

        <!-- Table -->
        <table class="table table-hover table-bordered align-middle">
            <thead>
                <tr class="table-primary">
                    <th class="">
                        <input class="form-check-input" type="checkbox" id="checked-all">
                    </th>
                    <th class="">#</th>
                    <th class="">User</th>
                    <th class="">Product</th>
                    <th class="">Comment</th>
                    <th class="">Updated</th>
                    <th class="">Created</th>
                    <th class="">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($comments as $index => $comment)
                <tr>
                    <td class="position-relative">
                        <label for="check-item-{{$index}}" class="position-absolute top-0 start-0 w-100 h-100 z-3"></label>
                        <input class="form-check-input" type="checkbox" value="{{$comment->id}}" name="check-item" id="check-item-{{$index}}">
                    </td>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $comment->user_name }}</td>
                    <td>
                        <a href="{{route('public.product.detail', $comment->product_id)}}" class="link-offset-2 text-decoration-none" style="--bs-link-hover-color-rgb: 25, 135, 84;">
                            <span class="fw-bold">{{ $comment->product_name }}</span>
                        </a>
                    </td>
                    <td>{{ $comment->content }}</td>
                    <td>
                        <span class="text-muted text-nowrap">{{ $comment->updated_at->diffForHumans() }}</span>
                    </td>
                    <td>
                        <span class="text-muted text-nowrap">{{ $comment->created_at->diffForHumans() }}</span>
                    </td>
                    <td>
                        <form action="{{ route('admin.comment.destroy', $comment) }}" method="POST" style="display:inline" onsubmit="confirmDelete(event)">
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

@section('script')
<!-- Config Script -->
<script>
    const routeUpdate = null;
    const routeDelete = "{{ route('api.comment.deleteMany') }}";
    const httpReferer = "{{isset($httpReferer)? $httpReferer : asset('admin.comment.index')}}"
</script>
<!-- Handler -->
<script src="{{asset('js/admin/selectIndex.js')}}"></script>
@endsection