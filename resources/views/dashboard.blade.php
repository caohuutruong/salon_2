@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
    <div class="col-md-4 mb-4">
        <a href="{{ route('customers.index') }}" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Khách hàng</h5>
                    <p class="card-text">Chi tiết </p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 mb-4">
        <a href="#" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Card Title 2</h5>
                    <p class="card-text">Sản phẩm</p>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-4 mb-4">
        <a href="#" class="text-decoration-none text-dark">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Card Title 3</h5>
                    <p class="card-text">Nhân viên</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection