<?php

namespace App\Mail;

use App\Models\AdminUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $token;
    public $resetUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(AdminUser $admin, string $token)
    {
        $this->admin = $admin;
        $this->token = $token;
        $this->resetUrl = route('admin.password.reset', [
            'token' => $token,
            'email' => $admin->email
        ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Password - Legian Medical Clinic',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin.reset-password',
            with: [
                'adminName' => $this->admin->name,
                'resetUrl' => $this->resetUrl,
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
        return [];
    }
}
