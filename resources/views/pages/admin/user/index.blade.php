@extends('layouts.admin')


<!-- content -->
@section('content')
<div class="container">
    <div class="my-3">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.user.create') }}" class="btn btn-success my-3">
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

        <table class="table">
            <thead>
                <tr class="table-primary">
                    <th class="">
                        <input class="form-check-input" type="checkbox" id="checked-all">
                    </th>
                    <th class="">Name</th>
                    <th class="">Email</th>
                    <th class="">Phone Number</th>
                    <th class="">Address</th>
                    <th class="">Image</th>
                    <th class="">Role</th>
                    <th class="">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                <tr>
                    <td class="position-relative">
                        <label for="check-item-{{$index}}" class="position-absolute top-0 start-0 w-100 h-100 z-3"></label>
                        <input class="form-check-input" type="checkbox" value="{{$user->id}}" name="check-item" id="check-item-{{$index}}">
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        {{ $user->phone_number }}
                    </td>
                    <td>
                        {{ $user->address }}
                    </td>
                    <td>
                        <img src="{{ $user->image }}" alt="" style="width: 100px">
                    </td>
                    <td>
                        {{ $user->role }}
                    </td>

                    <td>

                        <a href="{{ route('admin.user.edit', $user) }}" class="btn btn-outline-info">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <form action="{{ route('admin.user.destroy', $user) }}" method="POST" style="display:inline" onsubmit="confirmDelete(event)">
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
    const routeUpdate = "{{ route('api.user.updateStatus') }}";
    const routeDelete = "{{ route('api.user.deleteMany') }}";
    const httpReferer = "{{isset($httpReferer)? $httpReferer : asset('admin.user.index')}}"
</script>
<script src="{{asset('js/admin/selectIndex.js')}}"></script>
@endsection