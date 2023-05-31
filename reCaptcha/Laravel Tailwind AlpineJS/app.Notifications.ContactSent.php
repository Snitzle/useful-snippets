<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Http;

class ContactSent extends Notification
{
    use Queueable;

    public array $validated;

    /**
     * Create a new notification instance.
     */
    public function __construct( $validated )
    {

        $this->validated = $validated;

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

        $name = '<b>Name:</b> '.$this->validated['name'];
        $email = '<b>Email:</b> '.$this->validated['email'];
        $phone = '<b>Contact No:</b> '.$this->validated['phone_number'];
        $message = $this->validated['message'];

        // Validate Google reCaptcha
        $data = [
            'secret' => config('services.google.recaptcha.secret'),
            'response' => $this->validated['token'],
        ];

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', $data);
        $body = json_decode($response->body());
        if($body->success == false || $body->score < 0.8) {
            return back()->with('showCaptchaMessage', 'There was an error validating your message, please try again.');   
        }

        return (new MailMessage)
            ->replyTo($this->validated['email'])
            ->subject('A message from the Purusha Retreats website')
            ->greeting('A message from the website')
            ->line(new HtmlString($name.'<br>'.$email.'<br>'.$phone))
            ->line(new HtmlString('<b>Their message:</b><br>' .$message));

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
