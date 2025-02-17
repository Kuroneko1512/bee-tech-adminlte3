<?php

namespace App\Console;

use App\Console\Commands\SendLowStockNotification;
use App\Console\Commands\SendMonthlyPurchaseReport;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
     /**
     * Đăng ký các lệnh Artisan của ứng dụng.
     */
    protected $commands = [
        // Đăng ký các command đã tạo
        SendLowStockNotification::class,
        SendMonthlyPurchaseReport::class,
    ];
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        // Chạy hàng ngày lúc 8:00 sáng
        $schedule->command('app:send-low-stock-notification')
            ->dailyAt('08:00')
            ->description('Gửi email thông báo sản phẩm có số lượng dưới 10')
            ->withoutOverlapping();

        // Chạy vào 20:00 ngày đầu tiên của tháng
        $schedule->command('app:send-monthly-purchase-report')
            ->monthlyOn(1, '20:00')
            ->description('Gửi email tổng hợp mua hàng của tháng trước')
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
