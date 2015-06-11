<?php
	
	// When not using other frameworks, use this loader to autoload the namepaces.
	//require_once __DIR__ . '/../loader.php';

	// Autoload files using Composer autoload
	require_once __DIR__ . '/../vendor/autoload.php'; 

	// Import the required namespaces
	use CapayableApiClient\Client\CapayableClient;
	use CapayableApiClient\Enums\Environment;
	use CapayableApiClient\Enums\Gender;
	use CapayableApiClient\Enums\RefuseReason;
	use CapayableApiClient\Enums\InvoiceCreditStatus;
	use CapayableApiClient\Models\Invoice;
	use CapayableApiClient\Models\CreditCheckRequest;
	use CapayableApiClient\Models\RegistrationCheckRequest;
	use CapayableApiClient\Models\InvoiceCreditRequest;
	
	class Examples {

		private $client;

		function __construct()
		{
			// Instantiate the client with your personal api key and api secret.
			$this->client = new CapayableClient('xxxxxxx', 'yyyyyyy', Environment::ACC);

			// Run the examples
			try{
				// Create a credit check request
				$req = new CreditCheckRequest();
				$req->setLastName('Tritac');
				$req->setInitials('T.T.');
				$req->setGender(Gender::MALE);
				$req->setBirthDate('1977-01-01');
				$req->setStreetName('Rapenburg');
				$req->setHouseNumber(27);
				$req->setHouseNumberSuffix('');
				$req->setZipCode('2311 GG');
				$req->setCity('Leiden');
				$req->setCountryCode('NL');
				$req->setPhoneNumber('0715288792');
				$req->setFaxNumber('');
				$req->setEmailAddress('test@tritac.com');

				// If the customer is a corporation
				$req->setIsCorporation(false);
				$req->setCocNumber('28096738');
				$req->setCorporationName('Tritac B.V.');
				// Set to true in case of a small business / freelancer / independent contractor etc (zzp/eenmanszaak)
				$req->setIsSoleProprietor(false);

				$req->setIsFinal(true);
				$req->setClaimAmount(10000);

				// Optional check to find a company's address and name by chamber of commerce number.
				$registrationCheckRequest = new RegistrationCheckRequest($req->getCocNumber());
				$registrationCheckResult = $this->client->doRegistrationCheck($registrationCheckRequest);
				echo('RegistrationCheck: ' . ($registrationCheckResult->getIsAccepted() ? 'FOUND: ' . $registrationCheckResult->getCorporationName() : 'NOT FOUND') . "\r\n<br />");

				// Perform the credit check
				$result = $this->client->doCreditCheck($req);
				echo('CreditCheck: ' . ($result->getIsAccepted() ? 'ACCEPTED' : 'REJECTED: (' . RefuseReason::toString($result->getRefuseReason()) . ')' ) . "\r\n<br />");

				
				if($result->getIsAccepted())
				{
					echo('Transaction No: ' . $result->getTransactionNumber() . "\r\n<br />");

					// If the credit check succeeds, ship the order and register the invoice with Capayable.
					$this->registerInvoice($result);

					// Credit part of the invoice
					$this->creditInvoice($result);
				}

			} catch(Exception $e) {
				$this->printError($e->getMessage());
			}


		}

		private function registerInvoice($result){

			$invoice = new Invoice();
			$invoice->setTransactionNumber($result->getTransactionNumber());
			$invoice->setInvoiceNumber('ORD-123456');
			$invoice->setInvoiceAmount(10000);
			$invoice->setInvoiceDescription('Factuur 123456');

			// Option 1. Tell Capayable that the PDF-invoice has been sent to them by email.
			$invoice->setInvoiceByEmail('support@tritac.com', 'Bevestiging van order 123456');

			// Option 2. Tell Capayable that you supply the PDF-invoice at a URL.
			$invoice->setInvoiceByUrl('http://www.tritac.com/my-invoice.pdf');

			// Send the invoice
			$isAccepted = $this->client->registerInvoice($invoice);	

			echo('Invoice: ' . ($isAccepted ? 'ACCEPTED' : 'REJECTED') . "\r\n<br />");
		}

		private function creditInvoice($result){

			$request = new InvoiceCreditRequest($result->getTransactionNumber(), 'RET-123456', 5000);
			$creditInvoiceResult = $this->client->creditInvoice($request);

			echo('Invoice Credit: ' . InvoiceCreditStatus::toString($creditInvoiceResult->getResult()) . ' ( credited: ' . $creditInvoiceResult->getAmountCredited() . ' uncredited: ' . $creditInvoiceResult->getAmountNotCredited() . ')' . "\r\n<br />");
		}

		private function printError($message)
		{
			echo('<div style="color: #b94a48; border: 1px solid #eed3d7; background: #f2dede; margin: 5px; padding: 5px;">');
			echo('<p><strong>An error occured while making the request</strong></p>');
			echo('<p>The server returned the following message:</p>');
			echo('<pre>'.$message.'</pre>');
			echo('</div>');
		}
		
	}

	$examples = new Examples();
?>