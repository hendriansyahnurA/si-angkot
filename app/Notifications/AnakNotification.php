<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnakNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    protected $anak;

    public function __construct($anak)
    {
        $this->anak = $anak;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Akun anak Anda, {$this->anak->nama_lengkap}, telah diverifikasi oleh admin.",
            'anak_id' => $this->anak->id,
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Verifikasi Akun Anak')
            ->greeting("Halo, {$notifiable->nama_lengkap}")
            ->line("Akun anak Anda, {$this->anak->nama_lengkap}, telah diverifikasi oleh admin.")
            ->action('Lihat Detail', url('/dashboard'))
            ->line('Terima kasih telah menggunakan layanan kami!');
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
