@extends('layouts.app')
@section('title','Bang Khach Hang')
@section('content')

<h2 class="text-center">Danh sách khách hàng</h2>

<!-- Modal trigger button -->
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#newcus" style="margin: 0px 0px 5px 5px;">Thêm khách hàng mới</button>
<!-- Modal Body -->
<div class="modal fade" id="newcus" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">Thêm khách hàng mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="newCustomerForm" action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="newCustomerId">
                    
                    <div class="mb-3">
                        <label for="newName" class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control" name="name" id="newName" required>
                    </div>

                    <div class="mb-3">
                        <label for="newEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="newEmail" required>
                    </div>

                    <div class="mb-3">
                        <label for="newPhone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" id="newPhone">
                    </div>

                    <div class="mb-3">
                        <label for="newPrice" class="form-label">Giá</label>
                        <input type="number" class="form-control" name="price" id="newPrice" step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for="newServices" class="form-label">Dịch vụ đã sử dụng</label>
                        <select name="services_used[]" multiple class="form-control" id="newServices">
                            <option value="Haircut">Cắt tóc</option>
                            <option value="Shampoo">Gội đầu</option>
                            <option value="Massage">Massage</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Thêm</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- bảng -->
<div class="card">
    <div class="container">
        <div class="table-responsive">
            
            <table class="table table-striped">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Giá</th>
                        <th>Dịch vụ đã sử dụng</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>         
                    @foreach ($customers as $customer)
                        <tr class="text-center">
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ number_format($customer->price, 2) }}</td>
                            <td>{{ implode(', ', json_decode($customer->services_used, true)) }}</td>
                            <td>
                                <a class="btn btn-warning btn-sm editCustomerBtn" 
                                    data-id="{{ $customer->id }}" 
                                    data-name="{{ $customer->name }}"
                                    data-email="{{ $customer->email }}"
                                    data-phone="{{ $customer->phone }}"
                                    data-price="{{ $customer->price }}"
                                    data-services='@json($customer->services_used)'>
                                    <i class="fas fa-edit"></i> Sửa                                
                                </a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <nav>
            <ul class="pagination justify-content-center">
                {{-- Nút "Đầu", chỉ bấm được nếu không ở trang đầu --}}
                <li class="page-item {{ $page == 1 ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $page > 1 ? route('customers.index', ['page' => 1, 'size' => $size]) : '#' }}">«</a>
                </li>

                {{-- Nút "Trang trước", chỉ bấm được nếu có trang trước --}}
                <li class="page-item {{ $page == 1 ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $page > 1 ? route('customers.index', ['page' => $page - 1, 'size' => $size]) : '#' }}">❮</a>
                </li>

                {{-- Hiển thị các số trang gần vị trí hiện tại --}}
                @for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++)
                    <li class="page-item {{ $i == $page ? 'active' : '' }}">
                        <a class="page-link" href="{{ route('customers.index', ['page' => $i, 'size' => $size]) }}">{{ $i }}</a>
                    </li>
                @endfor

                {{-- Nút "Trang sau", chỉ bấm được nếu chưa đến trang cuối --}}
                <li class="page-item {{ $page >= $totalPages ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $page < $totalPages ? route('customers.index', ['page' => $page + 1, 'size' => $size]) : '#' }}">❯</a>
                </li>

                {{-- Nút "Cuối", chỉ bấm được nếu chưa ở trang cuối --}}
                <li class="page-item {{ $page >= $totalPages ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $page < $totalPages ? route('customers.index', ['page' => $totalPages, 'size' => $size]) : '#' }}">»</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div id="alert-box" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <script>
        setTimeout(function() {
            var alertBox = document.getElementById('alert-box');
            if (alertBox) {
                alertBox.style.display = 'none';
            }
        }, 2000); // Tự động đóng sau 5 giây
    </script>
@endif
<!-- Modal Body -->
<!-- <div
    class="modal fade"
    id="modalId"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    
    role="dialog"
    aria-labelledby="modalTitleId"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    Modal title
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Giá</label>
                        <input type="number" class="form-control" name="price" step="0.01">
                    </div>
                    <div class="card">
                    <div class="mb-3">
                        <label class="form-label">Dịch vụ đã sử dụng</label>
                        
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="services_used[]" value="Haircut" id="haircut">
                            <label class="form-check-label" for="haircut">Cắt tóc</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="services_used[]" value="Shampoo" id="shampoo">
                            <label class="form-check-label" for="shampoo">Gội đầu</label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="services_used[]" value="Massage" id="massage">
                            <label class="form-check-label" for="massage">Massage</label>
                        </div>
                    </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>
</div> -->

<!-- modal2 -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCustomerLabel">Sửa Khách Hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCustomerForm" action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="editCustomerId">
                    
                    <div class="mb-3">
                        <label for="editName" class="form-label">Tên khách hàng</label>
                        <input type="text" class="form-control" name="name" id="editName" required>
                    </div>

                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="editEmail" required>
                    </div>

                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" name="phone" id="editPhone">
                    </div>

                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Giá</label>
                        <input type="number" class="form-control" name="price" id="editPrice" step="0.01">
                    </div>

                    <div class="mb-3">
                        <label for="editServices" class="form-label">Dịch vụ đã sử dụng</label>
                        <select name="services_used[]" multiple class="form-control" id="editServices">
                            <option value="Haircut">Cắt tóc</option>
                            <option value="Shampoo">Gội đầu</option>
                            <option value="Massage">Massage</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Optional: Place to the bottom of scripts -->
<script>
    const myModal = new bootstrap.Modal(
        document.getElementById("modalId"),
        options,
    );
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let editButtons = document.querySelectorAll(".editCustomerBtn");
    
    editButtons.forEach(button => {
        button.addEventListener("click", function() {
            // Lấy dữ liệu từ nút
            let id = this.getAttribute("data-id");
            let name = this.getAttribute("data-name");
            let email = this.getAttribute("data-email");
            let phone = this.getAttribute("data-phone");
            let price = this.getAttribute("data-price");
            let services = JSON.parse(this.getAttribute("data-services"));

            // Đổ dữ liệu vào modal
            document.getElementById("editCustomerId").value = id;
            document.getElementById("editName").value = name;
            document.getElementById("editEmail").value = email;
            document.getElementById("editPhone").value = phone;
            document.getElementById("editPrice").value = price;
            
            // Đổ dữ liệu vào select multiple
            let selectBox = document.getElementById("editServices");
            for (let option of selectBox.options) {
                option.selected = services.includes(option.value);
            }

            // Hiển thị modal
            let editModal = new bootstrap.Modal(document.getElementById("editCustomerModal"));
            editModal.show();
        });
    });
});
</script>

@endsection
