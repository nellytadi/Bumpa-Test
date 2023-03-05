<?php


namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentService
{
    private string $secretKey;
    private string $baseUrl;
    private  $user;

    public function __construct($user) {
        $this->user = $user;
        $this->secretKey = Config::get('paystack.secretKey');
        $this->baseUrl = Config::get('paystack.baseUrl');
    }

    public function sendReward($amount) {
        if ($recipientCode = $this->createTransferRecipient()){
            $this->transfer($recipientCode, $amount);
        }
    }

    /**
     * @throws \Exception
     */
    private function createTransferRecipient() {
        $userBankAccount = $this->user->userBankAccount;
        $data = [
            'name' => $userBankAccount->name,
            'account_number' => $userBankAccount->account_number,
            'bank_code' => $userBankAccount->bank_code,
            'currency' => $userBankAccount->currency,
        ];
        try {
            $response = Http::withToken($this->secretKey)->post("$this->baseUrl/transferrecipient", $data);

            $response = json_decode($response,true);
            if ($response['status'] == 'false'){
                return false;
            }
            $recipient = $response['data']['recipient_code'];
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $recipient;
    }

    /**
     * @throws \Exception
     */
    private function transfer($recipientCode, $amount) {
        $data = [
            'source' => "balance",
            'amount' => $amount,
            'reference' => (string) Str::uuid(),
            'recipient' => $recipientCode,
            'reason' => 'Unlock Badge',
        ];
        try {
            $response = Http::withToken($this->secretKey)->post("$this->baseUrl/transfer", $data);
            $response = json_decode($response,true);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

        return $response['status'];
    }

    public function validateTransfer() {
        //todo - validate from webhook response
    }

    private function verifyBankAccountDetails() {
        //todo - verify bank details before initiating transfer
    }
}