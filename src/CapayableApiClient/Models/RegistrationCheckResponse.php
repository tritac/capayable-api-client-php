<?php
namespace CapayableApiClient\Models
{
    
    use CapayableApiClient\Models\BaseModel;
    use Exception;
        
    class RegistrationCheckResponse extends BaseModel
    {
        protected $isAccepted;
        
        protected $houseNumber;
        protected $houseNumberSuffix;
        protected $zipCode;
        protected $city;
        protected $countryCode;
        protected $phoneNumber;
        protected $corporationName;
        protected $cocNumber;

        public function __construct($isAccepted, $houseNumber, $houseNumberSuffix, $zipCode, $city, $countryCode, $phoneNumber, $corporationName, $cocNumber){
            $this->isAccepted = $isAccepted;
            $this->houseNumber = $houseNumber;
            $this->houseNumberSuffix = $houseNumberSuffix;
            $this->zipCode = $zipCode;
            $this->city = $city;
            $this->countryCode = $countryCode;
            $this->phoneNumber = $phoneNumber;
            $this->corporationName = $corporationName;
            $this->cocNumber = $cocNumber;
        }

        public function getCocNumber(){
            return $this->cocNumber;
        }

        public function getIsAccepted(){
            return $this->isAccepted;
        }

        public function getHouseNumber(){
            return $this->houseNumber;
        }

        public function getHouseNumberSuffix(){
            return $this->houseNumberSuffix;
        }

        public function getZipCode(){
            return $this->zipCode;
        }

        public function getCity(){
            return $this->city;
        }

        public function getCountryCode(){
            return $this->countryCode;
        }

        public function getPhoneNumber(){
            return $this->phoneNumber;
        }

        public function getCorporationName(){
            return $this->corporationName;
        }

    }
}
?>