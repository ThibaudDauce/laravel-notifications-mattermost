<?php

namespace ThibaudDauce\Mattermost;

use Illuminate\Notifications\Notification;

class MattermostChannel
{
    /**
     * The Mattermost HTTP instance.
     *
     * @var \ThibaudDauce\Mattermost
     */
    protected $mattermost;

    /**
     * Create a new Mattermost channel instance.
     *
     * @param  \ThibaudDauce\Mattermost  $mattermost
     * @return void
     */
    public function __construct(Mattermost $mattermost)
    {
        $this->mattermost = $mattermost;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send($notifiable, Notification $notification)
    {
        if (! $url = $notifiable->routeNotificationFor('mattermost')) {
            return;
        }

        $message = $notification->toMattermost($notifiable);

        return $this->mattermost->send($message, $url);
    }
}
