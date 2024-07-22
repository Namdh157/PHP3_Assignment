@extends('layouts.admin')

<!-- content -->
@section('content')
<div class="container">
    <div class="my-3">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.product.create') }}" class="btn btn-success my-3">
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
                    <th class="">SKU</th>
                    <th class="">Product</th>
                    <th class="">Catalogue</th>
                    <th class="">Brand</th>
                    <th class="">Variant</th>
                    <th class="">Active</th>
                    <th class="">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                <tr>
                    <td class="position-relative">
                        <label for="check-item-{{$index}}" class="position-absolute top-0 start-0 w-100 h-100 z-3"></label>
                        <input class="form-check-input" type="checkbox" value="{{$product->id}}" name="check-item" id="check-item-{{$index}}">
                    </td>
                    <td>{{ $product->sku }}</td>
                    <td>
                        <img src="{{asset($product->image_thumbnail)}}" alt="" class="object-fit-contain rounded-3" style="width: 50px; height: 50px">
                        <a href="{{ route('admin.product.show', $product) }}" class="link-offset-2 text-decoration-none" style="--bs-link-hover-color-rgb: 25, 135, 84;">
                            <span class="fw-bold">{{ $product->name }}</span>
                        </a>
                    </td>
                    <td>{{ $product->catalogue->name }}</td>
                    <td>{{ $product->brand->name }}</td>
                    <td>{{ $product->product_variants_count }}</td>
                    <td>
                        <!-- <div class="form-check form-switch">
                            <input class="form-check-input" onclick="((e)=>{e.preventDefault()})(event)" type="checkbox" {{$product->is_active ? 'checked':''}} name="active-item" />
                        </div> -->
                        <input class="form-check-input" type="checkbox" onclick="((e)=>{e.preventDefault()})(event)" {{$product->is_active ? 'checked':''}} name="active-item">
                    </td>
                    <td>
                        <a href="{{ route('admin.product.edit', $product) }}" class="btn btn-outline-info">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <form action="{{ route('admin.product.destroy', $product) }}" method="POST" style="display:inline" onsubmit="confirmDelete(event)">
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

<form action="" id="form-data">
    @csrf
</form>

<script>
    const checkAll = document.getElementById('checked-all');
    const checkItems = document.querySelectorAll('tbody input[name="check-item"]');
    const selectAction = document.getElementById('select-action');
    const selectSubmit = document.getElementById('select-submit');
    const formData = new FormData(document.getElementById('form-data'));

    // CheckBox event
    (() => {
        checkAll.onchange = function() {
            checkItems.forEach(checkbox => {
                checkbox.checked = checkAll.checked;
            })
        }
        checkItems.forEach(checkbox => {
            checkbox.onchange = function() {
                checkAll.checked = checkItems.length === document.querySelectorAll('tbody input[name="check-item"]:checked').length;
            }
        })
    })();

    // Select action
    (() => {
        selectSubmit.onclick = function() {
            const action = selectAction.value;
            const checkedIds = [];
            checkItems.forEach(checkbox => {
                if (checkbox.checked) {
                    checkedIds.push(checkbox.value);
                }
            })
            if (checkedIds.length === 0) {
                ToastCustom('Please select an item', 'error');
                return;
            }

            formData.set('checkedIds', JSON.stringify(checkedIds));
            let route = "{{ route('api.product.updateStatus') }}";
            let method = 'PATCH';
            let callBackSuccess = (res) => {
                document.querySelectorAll('input[name="check-item"]:checked').forEach(checkbox => {
                    const tr = checkbox.closest('tr');
                    const active = action === 'published' ? true : false;
                    console.log(active);
                    if (active) {
                        tr.querySelector('input[name="active-item"]')?.setAttribute('checked', '');
                    } else tr.querySelector('input[name="active-item"]')?.removeAttribute('checked');
                    checkbox.checked = false;
                    checkAll.checked = false;
                });
            };

            switch (action) {
                case 'published':
                    formData.set('is_active', 1);
                    break;
                case 'draft':
                    formData.set('is_active', 0);
                    break;
                case 'delete':
                    if (!confirm(`Are you sure you want to DELETE ${checkedIds.length} items?`)) return;
                    method = "DELETE";
                    route = "{{ route('api.product.deleteMany') }}";
                    callBackSuccess = (res) => {
                        window.location.reload();
                    }
                    break;
                default:
                    ToastCustom('Please select an action', 'error');
                    return;
            }
            postFormData(route, formData, callBackSuccess, null, method);
        }
    })();

    // Hover table
    (() => {
        document.querySelectorAll('tbody tr')?.forEach(tr => {
            tr.onmouseover = function() {
                tr.classList.add('table-success');
            }
            tr.onmouseleave = function() {
                tr.classList.contains('table-success') && tr.classList.remove('table-success');
            }
        })
    })();
</script>

@endsection
<!-- file Javascript -->
@section('script')
@endsection