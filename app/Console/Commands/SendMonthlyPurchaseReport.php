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

        // Lấy users đang hoạt động
        $users = User::where('status', 'active')->get();

        $sentCount = 0;
        foreach ($users as $user) {
            // Tính tổng đơn hàng và số tiền của mỗi user
            $report = Order::where('user_id', $user->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->selectRaw('
                                COUNT(*) as total_orders,
                                SUM(total_amount) as total_amount,
                                COUNT(DISTINCT product_id) as unique_products
                            ')
                ->first();

            if ($report->total_orders > 0) {
                Mail::to($user->email)
                    ->queue(new MonthlyPurchaseReport($report));
                $sentCount++;
            }
        }

        $this->info("Đã gửi báo cáo cho {$sentCount} người dùng");
    }
}
