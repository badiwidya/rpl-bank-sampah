<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserVerification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $url)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Verifikasi Email Nasabah')
            ->greeting('Halo, ' . $notifiable->nama_depan . '!')
            ->line('Terima kasih telah mendaftar di aplikasi kami.')
            ->line('Untuk mengaktifkan akun Anda, silakan verifikasi email Anda dengan menekan tombol di bawah ini.')
            ->action('Verifikasi Email', $this->url)
            ->line('Jika Anda tidak mendaftar ke aplikasi kami, Anda bisa mengabaikan pesan imi.')
            ->line('Terima kasih!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
