<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Repositories\CustomerRepositoryInterface;

class CustomerController extends Controller
{
    private $customerRepo;

    public function __construct(CustomerRepositoryInterface $customerRepo)
    {
        
        $this->customerRepo = $customerRepo;
        
    }
    
    public function store(Request $request)
    {
        $id = $request->input('id');

        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('customers')->ignore($id), // ← bỏ qua chính mình khi sửa
            ],
            'phone' => 'nullable|string|max:20',
            'price' => 'nullable|numeric|min:0',
            'services_used' => 'nullable|array',
        ];

        $request->validate($rules);

        try {
            // Thực hiện thêm/cập nhật khách hàng
            $this->customerRepo->upsertCustomer($request->all());

            return redirect()->route('customers.index')
                ->with('success', $id ? 'Khách hàng đã được cập nhật!' : 'Khách hàng đã được thêm!');
        } catch (\Exception $e) {
            // Nếu có lỗi, hiển thị thông báo lỗi và quay lại trang trước
            return redirect()->back()->with('error', 'Lỗi xảy ra: ' . $e->getMessage());
        }
    }

    
    public function show($id)
    {
        return response()->json($this->customerRepo->getCustomerById($id));
    }

    public function destroy($id, Request $request)
    {
        $this->customerRepo->deleteCustomer($id);
        return $this->index($request)->with(['message' => 'Khách hàng đã được xóa!']);
    }
    

    public function index(Request $request)
    {
        
        $page = $request->input('page', 1);
        $size = $request->input('size', 10);

        $totalCustomers = $this->customerRepo->countCustomers(); // Lấy tổng số khách hàng
        $totalPages = ceil($totalCustomers / $size); // Tính số trang

        $customers = $this->customerRepo->getCustomers($page, $size);

        
        $hasNextPage = $page < $totalPages;

        return view('customers.index', compact('customers', 'page', 'size', 'hasNextPage', 'totalPages'));
    }
    
   
}
