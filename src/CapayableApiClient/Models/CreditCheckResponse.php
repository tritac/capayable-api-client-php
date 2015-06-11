<?php
namespace CapayableApiClient\Models
{
	
	use CapayableApiClient\Models\BaseModel;
	use CapayableApiClient\Enums\RefuseReason;
		
    class CreditCheckResponse extends BaseModel
    {
    	protected $isAccepted;
		protected $transactionNumber;
		protected $refuseReason;
		protected $refuseContactName;
		protected $refuseContactPhoneNumber;

		public function __construct(){
			$this->isAccepted = false;
			$this->transactionNumber = '';
			$this->refuseReason = RefuseReason::CREDITCHECK_UNAVAILABLE;
		}

		public function setAccepted($transactionNumber){
			$this->isAccepted = true;
			$this->transactionNumber = $transactionNumber;
		}
		
		public function setRefused($refuseReason, $refuseContactName, $refusePhoneNumber){
			$this->isAccepted = false;
			$this->refuseReason = $refuseReason;
			$this->refuseContactName = $refuseContactName;
			$this->refuseContactPhoneNumber = $refusePhoneNumber;
		}
		
		function getIsAccepted() { return $this->isAccepted; }
		function getTransactionNumber() { return $this->transactionNumber; }
		function getRefuseReason() { return $this->refuseReason; }
		function getRefuseContactName() { return $this->refuseContactName; }
		function getRefuseContactPhoneNumber() { return $this->refuseContactPhoneNumber; }
	}
}
?>