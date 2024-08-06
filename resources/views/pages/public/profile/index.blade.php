@extends('layouts.public')

@section('content')

<main class="main">
    <div class="page-content mt-5">
        <div class="container w-75 light-style flex-grow-1">
            <div class="card overflow-hidden p-4">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-3 pt-0">
                        <!-- Avatar -->
                        <form class="card-body media align-items-center" accept="">
                            <label type="btn btn-add-avatar" class="" for="avatar" role="button">
                                <img src="{{$user->image}}" class="d-block ui-w-120 rounded-circle object-fit-cover" id="img-avatar" style="width: 200px; height: 200px">
                            </label>
                            <input type="file" class="account-settings-fileinput" id="avatar" hidden onchange="updateAvatar(event)">
                        </form>
                        <hr class="border-dark">
                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-order">Your order</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <!-- Infor -->
                            <div class="tab-pane fade active show" id="account-general">
                                <form class="card-body w-100" onsubmit="changeInfor(event)">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Name</label>
                                        <input type="text" class="form-control" id="name" value="{{$user->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="email">E-mail</label>
                                        <input type="text" class="form-control mb-1" id="email" value="{{$user->email}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="address">Address</label>
                                        <input type="text" class="form-control mb-1" id="address" value="{{$user->address ?? 'none'}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="phone_number">Phone number</label>
                                        <input type="text" class="form-control mb-1" id="phone_number" value="{{$user->phone_number ?? ''}}">
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Save changes</button>&nbsp;
                                        <button type="reset" class="btn btn-default">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            <!-- Change Password -->
                            <div class="tab-pane fade" id="account-change-password">
                                <form class="card-body pb-2 w-100" onsubmit="changePassword(event)">
                                    <div class="form-group">
                                        <label class="form-label" for="current_password">Current password</label>
                                        <input type="password" class="form-control" id="current_password">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="new_password">New password</label>
                                        <input type="password" class="form-control" id="new_password">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="confirm_password">Repeat new password</label>
                                        <input type="password" class="form-control" id="confirm_password">
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Save changes</button>&nbsp;
                                        <button type="reset" class="btn btn-default">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            <!-- Order -->
                            <div class="tab-pane fade" id="account-order">

                                <hr class="border-light m-0">
                                <div class="card-body pb-2">
                                    <h6 class="">Order list</h6>
                                    <hr class="border-dark">
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="row w-100 px-4">
                                            <div class="col-1">#</div>
                                            <div class="col-3 fs-5">Payment method</div>
                                            <div class="col fs-5">Paid</div>
                                            <div class="col fs-5">Discount</div>
                                            <div class="col fs-5">Total price</div>
                                            <div class="col fs-5">Status</div>
                                            <div class="col fs-5">Order at</div>
                                        </div>
                                        <hr class="border-dark my-2">
                                        @foreach ($bills as $key => $bill)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button fs-5 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$key}}" aria-expanded="false" aria-controls="collapse-{{$key}}">
                                                    <div class="row w-100">
                                                        <div class="col-1">{{$key + 1}}</div>
                                                        <div class="col-3">{{ucwords($bill->payment_method)}}</div>
                                                        <div class="col">{{$bill->is_paid ? 'Yes' : 'No'}}</div>
                                                        <div class="col">{{$bill->total_discount}}$</div>
                                                        <div class="col">{{$bill->total_price}}$</div>
                                                        <div class="col">{{$bill->status}}</div>
                                                        <div class="col">{{$bill->created_at->diffForHumans()}}</div>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapse-{{$key}}" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                                <div class="fs-5">
                                                    <!-- Information -->
                                                    <div class="mb-2">
                                                        <div>Name: <span class="fw-medium">{{$bill->customer_name}}</span></div>
                                                        <div>Phone: <span class="fw-medium">{{$bill->customer_phone}}</span></div>
                                                        <div>Address: <span class="fw-medium">{{$bill->customer_address}}</span></div>
                                                    </div>
                                                    <!-- Detail -->
                                                    <table class="table fs-5">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" class="fs-5">Product</th>
                                                                <th scope="col" class="fs-5">Size</th>
                                                                <th scope="col" class="fs-5">Color</th>
                                                                <th scope="col" class="fs-5">Quantity (pcs)</th>
                                                                <th scope="col" class="fs-5">Unit Price</th>
                                                                <th scope="col" class="fs-5">Total Amount</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($bill->billDetails as $detail)
                                                            <tr>
                                                                <td class="py-2">{{ $detail->product_name }}</td>
                                                                <td class="py-2">{{ $detail->product_size }}</td>
                                                                <td class="py-2">{{ $detail->product_color }}</td>
                                                                <td class="py-2">{{ $detail->quantity }}</td>
                                                                <td class="py-2">{{ $detail->unit_price }}$</td>
                                                                <td class="py-2">{{ $detail->quantity * $detail->unit_price }}$</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<form action="" id="form-image">
    @csrf
</form>
@endsection

@section('script')
<!-- Config Script -->
<script>
    const routeUpdateInfor = "{{route('api.user.update')}}";
    const routeUpdatePassword = "{{route('api.user.changePassword')}}";
    const routeUpdateAvatar = "{{route('api.user.updateAvatar')}}";
</script>
<!-- Handle Script -->
<script>
    function updateAvatar(e) {
        loading().on();
        const formData = new FormData(document.getElementById('form-image'));
        const file = e.target.files[0];
        formData.set('avatar', file);

        fetch(routeUpdateAvatar, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            }).then(response => response.json())
            .then(res => {
                if (res.success) {
                    ToastCustom('Update avatar success', 'success');
                    const url = res.data.image;
                    document.querySelector('img#img-avatar').src = "{{asset('')}}" + url;
                } else if (res.error) {
                    ToastCustom(res.error, 'error');
                }
                loading().off();
            })
    }

    function changeInfor(e) {
        e.preventDefault();
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const address = document.getElementById('address').value;
        const phone_number = document.getElementById('phone_number').value;
        const payload = {
            name,
            email,
            address,
            phone_number
        }
        sendRequest(routeUpdateInfor, payload, 'PUT', (data) => {
            ToastCustom('Update user success', 'success');
        })
    }

    function changePassword(e) {
        e.preventDefault();
        const current_password = document.getElementById('current_password').value;
        const new_password = document.getElementById('new_password').value;
        const confirm_password = document.getElementById('confirm_password').value;
        if (new_password !== confirm_password) {
            ToastCustom('New password and confirm password not match', 'error');
            return;
        }
        const payload = {
            current_password,
            new_password,
            confirm_password
        }
        sendRequest(routeUpdatePassword, payload, 'PUT', (data) => {
            ToastCustom('Change password success', 'success');
        })
    }
</script>
@endsection