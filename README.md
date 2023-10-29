# Laravel Notifications for Mattermost

## Installation

```bash
composer require thibaud-dauce/laravel-notifications-mattermost
```

## Creating your webhook URL in Mattermost

Follow the official documentation [https://docs.mattermost.com/developer/webhooks-incoming.html](https://developers.mattermost.com/integrate/webhooks/incoming/).

## Usage

```php
<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use ThibaudDauce\Mattermost\MattermostChannel;
use ThibaudDauce\Mattermost\Message as MattermostMessage;

class TicketWasOpenedByCustomer extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [MattermostChannel::class];
    }

    /**
     * Get the Mattermost representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \ThibaudDauce\Mattermost\Message
     */
    public function toMattermost($notifiable)
    {
        return (new MattermostMessage)
            ->username('Helpdesk')
            ->iconUrl(url('/images/logo_only.png'))
            ->text("A new ticket has been opened.")
            ->attachment(function ($attachment) {
                $attachment->authorName($notifiable->name)
                    ->title("[Ticket #1] Title of the ticket", '/tickets/1')
                    ->text("Message of **the ticket**"); // Markdown supported.
            });
    }
}
```

For all the possibilities with the `Message` and the `Attachment` see https://github.com/ThibaudDauce/mattermost-php.

### Routing a message

```php
…

/**
 * Route notifications for the Mattermost channel.
 *
 * @return int
 */
public function routeNotificationForMattermost()
{
    return $this->mattermost_webhook_url;
}

…
```
