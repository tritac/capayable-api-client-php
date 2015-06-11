<?php
namespace CapayableApiClient\Enums {
    
    use CapayableApiClient\Enums\Enum;

    class InvoiceCreditStatus extends Enum{
        
        // ACCEPTED (0) The invoice is will be credited/refunded
        const ACCEPTED = 0;

        // EXCEEDS_PERIOD_LIMIT (3) The call is later than 14 days after the 
        // InvoiceDate. Credit is no longer possible. (AmountCredited = 0)
        const EXCEEDS_PERIOD_LIMIT = 3;

    }
    
}