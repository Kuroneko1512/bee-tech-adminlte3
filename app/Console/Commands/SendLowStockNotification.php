<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Product;
use Illuminate\Console\Command;
use App\Mail\LowStockNotification;
use Illuminate\Support\Facades\Mail;

class SendLowStockNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-low-stock-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gửi thông báo cho sản phẩm có số lượng dưới 10';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Lấy sản phẩm có số lượng < 10
        $lowStockProducts = Product::where('stock', '<', 10)
            ->get(['id', 'name', 'stock']);

        if ($lowStockProducts->isEmpty()) {
            $this->info('Không có sản phẩm nào sắp hết hàng');
            return;
        }

        // Lấy danh sách user đang hoạt động
        $users = User::where('status', 'active')
            ->get(['id', 'email']);

        $sentCount = 0;
        foreach ($users as $user) {
            // Gửi mail qua queue đã định nghĩa trong Mailable
            Mail::to($user->email)->send(new LowStockNotification($lowStockProducts));
            $sentCount++;
        }

        $this->info("Đã gửi thông báo đến {$sentCount} người dùng");
    }
}
