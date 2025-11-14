<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Slack\BlockKit\Blocks\ContextBlock;
use Illuminate\Notifications\Slack\BlockKit\Blocks\SectionBlock;
use Illuminate\Notifications\Slack\SlackMessage;

class SlackChannelNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $channel, public $text, public $header, )
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
        return ['slack'];
    }

    public function toSlack(object $notifiable): SlackMessage
    {
        return (new SlackMessage)
            ->text($this->text)
            ->headerBlock($this->header);
        // ->contextBlock(function (ContextBlock $block) {
        //     $block->text('Customer #1234');
        // })
        // ->sectionBlock(function (SectionBlock $block) {
        //     $block->text('An invoice has been paid.');
        //     $block->field("*Invoice No:*\n1000")->markdown();
        //     $block->field("*Invoice Recipient:*\ntaylor@laravel.com")->markdown();
        // })
        // ->dividerBlock()
        // ->sectionBlock(function (SectionBlock $block) {
        //     $block->text('Congratulations!');
        // });
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