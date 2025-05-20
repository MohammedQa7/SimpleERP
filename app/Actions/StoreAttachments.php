<?php
namespace App\Actions;

use App\Models\Product;
use App\Traits\hasAttachments;

class StoreAttachments
{
    use hasAttachments;
    function handle($payment_transaction, $attachments)
    {
        foreach ($attachments as $attachment) {
            $new_path = $this->moveToNewPath($attachment);
            $payment_transaction->attachments()->create([
                'attachment_path' => $new_path,
            ]);
        }
    }



}