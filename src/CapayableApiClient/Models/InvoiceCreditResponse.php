<?php
namespace CapayableApiClient\Models
{
    
    use CapayableApiClient\Models\BaseModel;
        
    class InvoiceCreditResponse extends BaseModel
    {
        protected $result;
        protected $amountNotCredited;
        protected $amountCredited;

        public function __construct($result, $amountCredited, $amountNotCredited){
            $this->result = $result;
            $this->amountCredited = $amountCredited;
            $this->amountNotCredited = $amountNotCredited;
        }

        public function getResult(){
            return $this->result;
        }
        
        public function getAmountNotCredited(){
            return $this->amountNotCredited;
        }

        public function getAmountCredited(){
            return $this->amountCredited;
        }
    }
}
?>