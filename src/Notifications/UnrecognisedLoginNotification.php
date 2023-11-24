<?php

namespace ReesMcIvor\SecureLogin\Notifications;

use Google\Service\ManagedServiceforMicrosoftActiveDirectoryConsumerAPI\Trust;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use ReesMcIvor\SecureLogin\Models\TrustedDevice;
use Illuminate\Support\Facades\URL;

class UnrecognisedLoginNotification extends Notification
{
    use Queueable;

    protected string $trustLink;

    public function __construct(
        protected TrustedDevice $trustedDevice
    )
    {
        $this->trustLink = $this->createTrustLink();
    }

    protected function createTrustLink() : string
    {
        $trustedDevice = $this->trustedDevice;
        return URL::temporarySignedRoute(
            "secure-login.approve",
            now()->addHour(),
            ['trustedDevice' => $trustedDevice]
        );
    }

    protected function getTitle() : string
    {
        return  sprintf("Unrecognised Login Please Approve");
    }

    public function via($notifiable)
    {
        return ['slack', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->getTitle())
            ->bcc(['Rees McIvor' => 'hello@logicrises.co.uk' ])
            ->line("There has been a Unrecognised Login Attempt.")
            ->line(sprintf("IP Address: %s", $this->trustedDevice->ip_address))
            ->line(sprintf("User Agent: %s", $this->trustedDevice->user_agent))
            ->action('Approve', $this->trustLink);
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage())
            ->content($this->getTitle())
            ->info()
            ->attachment(function ($attachment) {
                $attachment->title($this->trustedDevice?->user?->email, $this->trustLink)
                    ->fields([
                        'IP' => $this->trustedDevice->ip_address,
                        'User Agent' => $this->trustedDevice->user_agent,
                        'Approve' => $this->trustLink,
                    ]);
            });
    }

}
