<?php

namespace App\Http\Controllers\Api\Order;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * API mua sản phẩm của customer.
     *
     * Yêu cầu request (JSON):
     * {
     *   "products": [
     *       { "id": 1, "quantity": 2 },
     *       { "id": 3, "quantity": 1 },
     *       { "id": 5, "quantity": 10 }
     *   ]
     * }
     *
     * Trong đó: mỗi object trong mảng "products" bao gồm
     *  - id: id của sản phẩm (sản phẩm phải tồn tại trong bảng products)
     *  - quantity: số lượng sản phẩm cần mua (tối thiểu là 1)
     *
     * Quá trình:
     * - Validate payload
     * - Tính tổng số lượng và tổng tiền dựa trên giá của sản phẩm và số lượng mua
     * - Tạo đơn hàng (orders) và chèn các chi tiết đơn hàng (order_details) trong transaction,
     *   đảm bảo tính toàn vẹn dữ liệu.
     * - Trả về response chứa thông tin đơn hàng và các chi tiết.
     */
    public function purchase(Request $request)
    {
        // Validate payload: yêu cầu "products" là mảng chứa các object có key "id" và "quantity"
        $request->validate([
            'products'              => 'required|array|min:1',
            'products.*.id'         => 'required|integer|exists:products,id',
            'products.*.quantity'   => 'required|integer|min:1'
        ]);

        // Lấy thông tin customer đã xác thực (với guard 'customer')
        $customer = $request->user();

        try {
            // Sử dụng transaction để đảm bảo toàn vẹn dữ liệu:
            $order = DB::transaction(function () use ($request, $customer) {
                $productsInput = $request->input('products'); // Mảng sản phẩm mua

                $totalQuantity = 0;
                $totalAmount   = 0;
                $orderDetails  = [];

                // Duyệt qua từng sản phẩm trong mảng:
                foreach ($productsInput as $item) {
                    $productId = $item['id'];
                    $quantity  = $item['quantity'];

                    // Lấy thông tin sản phẩm từ bảng products
                    $product = Product::findOrFail($productId);
                    $price   = $product->price;

                    // Tính tổng số lượng và tổng tiền:
                    $totalQuantity += $quantity;
                    $totalAmount   += $price * $quantity;

                    $formattedPrice = number_format($product->price, 0, '', '.');
                    // Chuẩn bị dữ liệu cho một record trong bảng order_details
                    $orderDetails[] = [
                        'product_id' => $productId,
                        'quantity'   => $quantity,
                        'price'      => $price,
                        'status'     => 'pending', // Trạng thái mặc định cho mỗi chi tiết đơn hàng
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                // Tạo đơn hàng trong bảng orders
                $order = Order::create([
                    'customer_id' => $customer->id,
                    'quantity'    => $totalQuantity,
                    'total'       => $totalAmount,
                ]);

                // Gán order_id cho từng record chi tiết và chèn hàng loạt vào bảng order_details
                foreach ($orderDetails as &$detail) {
                    $detail['order_id'] = $order->id;
                }
                OrderDetail::insert($orderDetails);

                // Load quan hệ chi tiết (details) để trả về response đầy đủ
                return $order->load('details');
            });

            return response()->json([
                'success' => true,
                'message' => 'Đơn hàng đã được tạo thành công',
                'data'    => $order
            ], 201);
        } catch (\Exception $e) {
            // Ghi log lỗi nếu có
            Log::error('Lỗi tạo đơn hàng', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tạo đơn hàng',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
