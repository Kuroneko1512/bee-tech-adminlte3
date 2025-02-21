<?php

namespace App\Jobs;

use App\Mail\UserMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\RateLimiter;

class ProcessCreateUpdateEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mail;
    protected $to;
    /**
     * Create a new job instance.
     */
    public function __construct(UserMail $mail, string $to)
    {
        $this->mail = $mail;
        $this->to = $to;
        $this->onQueue('user-notifications');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        // Key để track rate limit
        $minuteKey = 'mail-limit:minute:' . $this->to;
        $hourKey = 'mail-limit:hour:' . $this->to;
        $dayKey = 'mail-limit:day:' . $this->to;
        $monthKey = 'mail-limit:month:' . $this->to;

        try {
            // // Kiểm tra và ghi log
            // if (RateLimiter::tooManyAttempts($minuteKey, 2)) {
            //     $seconds = RateLimiter::availableIn($minuteKey);
            //     Log::warning("Rate limit exceeded - minute", [
            //         'email' => $this->to,
            //         'wait_time' => $seconds,
            //         'type' => 'reset_password'
            //     ]);
            //     return;
            // }

            // if (RateLimiter::tooManyAttempts($hourKey, 5)) {
            //     $minutes = ceil(RateLimiter::availableIn($hourKey) / 60);
            //     Log::warning("Rate limit exceeded - hour", [
            //         'email' => $this->to,
            //         'wait_time' => $minutes,
            //         'type' => 'reset_password'
            //     ]);
            //     return;
            // }
            // // Giới hạn theo ngày
            // if (RateLimiter::tooManyAttempts($dayKey, 10)) {
            //     $hours = ceil(RateLimiter::availableIn($dayKey) / 3600);
            //     Log::warning("Rate limit exceeded - day", [
            //         'email' => $this->to,
            //         'wait_hours' => $hours,
            //         'type' => 'reset_password'
            //     ]);
            //     return;
            // }

            // // Giới hạn theo tháng - sử dụng Carbon để tính chính xác số ngày trong tháng
            // if (RateLimiter::tooManyAttempts($monthKey, 20)) {
            //     $daysInMonth = Carbon::now()->daysInMonth;
            //     $seconds = $daysInMonth * 86400; // Số giây trong tháng hiện tại

            //     Log::warning("Rate limit exceeded - month", [
            //         'email' => $this->to,
            //         'days_in_month' => $daysInMonth,
            //         'type' => 'reset_password'
            //     ]);
            //     return;
            // }

            // // Increment counters
            // RateLimiter::hit($minuteKey, 60);
            // RateLimiter::hit($hourKey, 3600);
            // RateLimiter::hit($dayKey, 86400);
            // RateLimiter::hit($monthKey, Carbon::now()->daysInMonth * 86400);

            // Gửi mail
            Mail::to($this->to)->send($this->mail);
            //Nhớ chạy worker :email  php artisan queue:work --queue=user-notifications
            Log::info("Đã gửi mail thành công cho {$this->to}", );
        } catch (\Exception $e) {
            Log::error("Lỗi gửi mail: {$e->getMessage()}");
            throw $e;
        }
    }

    public function failed(\Throwable $e)
    {
        Log::error("Job gửi mail thất bại cho {$this->to}: {$e->getMessage()}");
    }
}
