<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class NewOrderCreatedNotification extends Notification
{
    use Queueable;
    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
    //    return ['database','mail','broadcast'];
        return ['database','broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail( $notifiable)
    // {
    //     return (new MailMessage)
    //                  ->subject('New Order')
    //                  ->greeting('hello'.$notifiable->name)
    //                  ->line('A new order has been placed.')
                    
    //                 // ->action('view order', url('/dasboard',$this->order))
    //                 ->action('view order', url('/homebasic'))
    //                 ->line('Thank you for using our application!');
    // }
    public function toDatabase($notifiable)
    {
       // dd($notifiable);
        return[
            'title'=>'new order',
            'body'=>'this order ',
            'action'=>url('/dashborad'),
            'order_id' => $this->order->id,

        ];
    }
    public function toBroadcast($notifiable)
    {
       // dd($notifiable);
      $message= new BroadcastMessage([
            'title'=>'new order',
            'body'=>'this order created ',
          'action'=>url('/dashborad'),
            'order_id' => $this->order->id,

        ]);
        return $message;
    }
   

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    
    public function toArray($notifiable)
    {
        return [
            'message' => $this->getMessage(),
        ];
    }

    public function getMessage()
    {
        return 'A new order has been placed.';
    }
}
