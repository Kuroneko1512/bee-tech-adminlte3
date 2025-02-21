<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\RateLimiter;

class UserResetPasswordEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mail;
    protected $to;

    /**
     * Create a new job instance.
     */
    public function __construct(ResetPasswordMail $mail, $to)
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
        try {
            // Key để track rate limit
            $minuteKey = 'reset_email:minute:' . $this->to;
            $hourKey = 'reset_email:hour:' . $this->to;
            $dayKey = 'reset_email:day:' . $this->to;
            $monthKey = 'reset_email:month:' . $this->to;

            // Kiểm tra và ghi log
            if (RateLimiter::tooManyAttempts($minuteKey, 2)) {
                $seconds = RateLimiter::availableIn($minuteKey);
                Log::warning("Rate limit exceeded - minute", [
                    'email' => $this->to,
                    'wait_time' => $seconds,
                    'type' => 'reset_password'
                ]);
                return;
            }

            if (RateLimiter::tooManyAttempts($hourKey, 5)) {
                $minutes = ceil(RateLimiter::availableIn($hourKey) / 60);
                Log::warning("Rate limit exceeded - hour", [
                    'email' => $this->to,
                    'wait_time' => $minutes,
                    'type' => 'reset_password'
                ]);
                return;
            }
            // Giới hạn theo ngày
            if (RateLimiter::tooManyAttempts($dayKey, 10)) {
                $hours = ceil(RateLimiter::availableIn($dayKey) / 3600);
                Log::warning("Rate limit exceeded - day", [
                    'email' => $this->to,
                    'wait_hours' => $hours,
                    'type' => 'reset_password'
                ]);
                return;
            }

            // Giới hạn theo tháng - sử dụng Carbon để tính chính xác số ngày trong tháng
            if (RateLimiter::tooManyAttempts($monthKey, 20)) {
                $daysInMonth = Carbon::now()->daysInMonth;
                $seconds = $daysInMonth * 86400; // Số giây trong tháng hiện tại

                Log::warning("Rate limit exceeded - month", [
                    'email' => $this->to,
                    'days_in_month' => $daysInMonth,
                    'type' => 'reset_password'
                ]);
                return;
            }

            // Increment counters
            RateLimiter::hit($minuteKey, 60);
            RateLimiter::hit($hourKey, 3600);
            RateLimiter::hit($dayKey, 86400);
            RateLimiter::hit($monthKey, Carbon::now()->daysInMonth * 86400);

            //Gửi mail
            Mail::to($this->to)->send($this->mail);
            Log::info("Đã gửi mail reset password thành công", [
                'email' => $this->to,
                'type' => 'reset_password'
            ]);
        } catch (\Throwable $th) {
            Log::error("Lỗi gửi mail reset password: {$th->getMessage()}", [
                'email' => $this->to,
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
}
