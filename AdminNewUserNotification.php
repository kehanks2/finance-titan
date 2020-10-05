
<?php

{
 private $user; 
  
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('New user has registered: ' . $this->user->name . ' ('.$this->user->email.')')
                    ->action('Login to adminpanel to approve', route('admin.users.edit', $this->user->id));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
