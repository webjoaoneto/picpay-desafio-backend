<?php

namespace App\Listeners\Transaction;

use App\Events\TransactionEvent;
use Log;

class ValidatorListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\TransactionEvent  $event
     * @return void
     */
    public function handle(TransactionEvent $event)
    {

        if( !!$event->getPayer()->is_merchant === true ) {
            return $event->abort('Merchant Payer not permitted');
        }


        if( $event->getPayer()->balance < $event->getTransaction()->value ) {
            return $event->abort('Payer balance is insuficient');
        }

        Log::debug('Payer authorized');
        return $event;
    }
}
