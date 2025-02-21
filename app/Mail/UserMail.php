<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;

    // Khai báo các thuộc tính
    protected $user;
    protected $type;
    protected $data;
    /**
     * Create a new message instance.
     */
    public function __construct(User $user, string $type, array $data = [])
    {
        //Khởi tạo instance của mail với các tham số
        $this->user = $user;
        $this->type = $type;
        $this->data = $data;
    }

    public function getType(): string
    {
        return $this->type;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        //Cấu hình envelope (subject, từ, đến, cc, bcc...)
        $subject = match($this->type) {
            'created' => 'Chào mừng thành viên mới',
            'updated' => 'Cập nhật thông tin tài khoản',
            default => 'Thông báo hệ thống'
        };
        return new Envelope(
            // subject: 'User Mail',
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $provinceName = str_replace(['"', '[', ']'], '', $this->user->province->name);
        //Cấu hình nội dung email (view, data)
        return new Content(
            // view: 'view.name',
            view: "emails.users.{$this->type}",
            with: [
                'user' => $this->user,
                'data' => $this->data,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        //Cấu hình file đính kèm nếu có
        return [];
    }
}
