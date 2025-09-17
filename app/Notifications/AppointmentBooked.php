<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Appointment;

class AppointmentBooked extends Notification implements ShouldQueue
{
    use Queueable;

    protected $appointment;
    /**
     * Create a new notification instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Appointment Confirmation')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your appointment has been successfully booked.')
            ->line('📅 Date: ' . $this->appointment->appointment_date->format('F j, Y'))
            ->line('⏰ Time: ' . $this->appointment->appointment_date->format('h:i A'))
            ->line('📌 Reason: ' . $this->appointment->reason_for_visit)
            ->action('View Appointment', url('/appointments'))
            ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'message' => 'New appointment for ' . $this->appointment->doctor_name,
            'appointment_id' => $this->appointment->id
        ];
    }
}
