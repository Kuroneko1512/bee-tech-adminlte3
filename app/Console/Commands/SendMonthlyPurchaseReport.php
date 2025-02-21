<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Console\Command;
use App\Mail\MonthlyPurchaseReport;
use Illuminate\Support\Facades\Mail;

class SendMonthlyPurchaseReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-monthly-purchase-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi báo cáo mua hàng hàng tháng cho users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Tính toán khoảng thời gian tháng trước
        $lastMonth = Carbon::now()->subMonth();
        $startDate = $lastMonth->startOfMonth();
        $endDate = $lastMonth->endOfMonth();

        // Lấy thống kê mua hàng của customers
        $customerStats = Order::join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->selectRaw('
                            orders.customer_id,
                            customers.full_name,
                            customers.phone,
                            customers.email,
                            COUNT(DISTINCT orders.id) as total_orders,
                            SUM(orders.total) as total_amount,
                            COUNT(DISTINCT order_details.product_id) as unique_products,
                            SUM(order_details.quantity) as total_items
                        ')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->where('customers.status', 'active')
            ->where('customers.flag_delete', 0)
            ->groupBy('orders.customer_id', 'customers.full_name', 'customers.phone', 'customers.email')
            ->get();

        // Lấy users đang hoạt động
        $users = User::where('status', 'active')->get();
        $sentCount = 0;

        foreach ($users as $user) {

            // Gửi mail qua queue đã định nghĩa trong Mailable
            Mail::to($user->email)->send(new MonthlyPurchaseReport($customerStats));
            $sentCount++;
        }

        $this->info("Đã gửi báo cáo cho {$sentCount} User");
    }
}
