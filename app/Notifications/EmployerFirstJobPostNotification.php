<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\JobPost;
use Illuminate\Bus\Queueable;
use Filament\Notifications\Actions\Action;
use Illuminate\Notifications\Notification;
use App\Filament\Admin\Resources\JobPostResource;
use Illuminate\Notifications\Messages\MailMessage;
use Filament\Notifications\Notification as FilamentNotification;


class EmployerFirstJobPostNotification extends Notification
{
    use Queueable;

    /**
     * 
     * Create a new notification instance.
     */
    public function __construct(public JobPost $jobPost)
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->markdown('mail.employer-first-job-post-notification', [
                'url' => JobPostResource::getUrl('view', [
                    'record' => $this->jobPost->id
                ]),
                'company' => $this->jobPost->employer->name,
                ...$this->jobPost->toArray()
            ]);
    }

    public function toDatabase(User $notifiable): array
    {
        return FilamentNotification::make()
            ->title('Employer First Job Posted')
            ->body('A new job post has been created by ' . $this->jobPost->employer->name)
            ->info()
            ->actions([
                Action::make('view')
                    ->button()
                    ->url(JobPostResource::getUrl('view', [
                        'record' => $this->jobPost->id
                    ]))
                    ->label('View Job Post')
                    ->color('info')
                    ->close(),
            ])
            ->getDatabaseMessage();
    }
}
