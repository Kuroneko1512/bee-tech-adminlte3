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

class ProcessEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Số lần thử lại tối đa khi gặp lỗi
    public $tries = 3;

    // Thời gian timeout cho mỗi lần chạy job
    public $timeout = 60;

    protected $mail;
    protected $to;
    /**
     * Create a new job instance.
     */
    public function __construct(UserMail $mail, string $to)
    {
        $this->mail = $mail;
        $this->to = $to;
        $this->onQueue('emails');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Debugbar::info('Bắt đầu xử lý email job - 
        To: ' . $this->to . ', Type: ' . $this->mail->getType());

        // Key để track rate limit
        $minuteKey = 'mail-limit:minute:' . $this->to;
        $hourKey = 'mail-limit:hour:' . $this->to;
        $monthKey = 'mail-limit:month:' . $this->to;

        try {
            // Kiểm tra giới hạn gửi mail theo phút
            if (RateLimiter::tooManyAttempts($minuteKey, 2)) {
                $seconds = RateLimiter::availableIn($minuteKey);
                Debugbar::warning('Đạt giới hạn phút - 
                                            Email: ' . $this->to 
                                            . ', Wait: ' . $seconds . ' giây');
                // Log::info("Đợi {$seconds} giây để gửi mail tiếp");
                $this->release($seconds);
                return;
            }

            // Kiểm tra giới hạn gửi mail theo giờ
            if (RateLimiter::tooManyAttempts($hourKey, 20)) {
                $seconds = RateLimiter::availableIn($hourKey);
                Debugbar::warning('Đạt giới hạn giờ - 
                                            Email: ' . $this->to 
                                            . ', Wait: ' . $seconds . ' giây');
                // Log::info("Đợi {$seconds} giây để gửi mail tiếp");
                $this->release($seconds);
                return;
            }

            // Kiểm tra giới hạn gửi mail theo tháng
            if (RateLimiter::tooManyAttempts($monthKey, 500)) {
                Debugbar::error('Đạt giới hạn tháng - Email: ' . $this->to);
                Log::warning("Đã đạt giới hạn tháng cho: {$this->to}");
                return;
            }

            // Tăng counter
            RateLimiter::hit($minuteKey, 60);
            RateLimiter::hit($hourKey, 3600);
            RateLimiter::hit($monthKey, 2592000);
            Debugbar::info('Counters hiện tại - 
                                        Minute: ' . RateLimiter::attempts($minuteKey) 
                                    . ', Hour: ' . RateLimiter::attempts($hourKey) 
                                    . ', Month: ' . RateLimiter::attempts($monthKey));

            // Gửi mail
            Mail::to($this->to)->send($this->mail);
            Debugbar::success('Gửi mail thành công - To: ' . $this->to);
            //Nhớ chạy worker :email  php artisan queue:work --queue=emails
            // Log::info("Đã gửi mail thành công tới: {$this->to}");
        } catch (\Exception $e) {
            Debugbar::error('Lỗi gửi mail: ' . $e->getMessage() . ' - Trace: ' . $e->getTraceAsString());
            // Log::error("Lỗi gửi mail: {$e->getMessage()}");
            throw $e;
        }
    }

    public function failed(\Throwable $e)
    {
        Log::error("Job gửi mail thất bại cho {$this->to}: {$e->getMessage()}");
    }
}
