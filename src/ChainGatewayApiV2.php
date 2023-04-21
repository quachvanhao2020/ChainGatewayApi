<?php
namespace ChainGatewayApi;

class ChainGatewayApiV2{
    public $network;
    public $endpoint;
    public $key;
    public $gas = 0;
    public function __construct(string $key,\Network $network = \Network::ETH)
    {
        $this->key = $key;
        $this->setNetwork($network);
    }
    public function setNetwork(string|\Network $network){
        if(is_string($network)){
            $network = cover_to_network($network);
        }
        $endpoint = "https://api.chaingateway.io/v2";
        switch ($network) {
            case \Network::BSC:
                $endpoint .= "/bsc";
                break;
            case \Network::TRON:
                $endpoint .= "/tron";
                break;
            case \Network::ETH:
                $endpoint .= "/ethereum";
                break;
        }
        $this->endpoint = $endpoint;
        $this->network = $network;
    }
    public function getToken(string $address){
        $curl = curl_init();
        $data = 
        [
            "contractaddress" => $address,
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/getToken",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);
    }
    public function getLastBlockNumber(){
        $curl = curl_init();
        $data = 
        [
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/getLastBlockNumber",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);
    }
    public function getGasPrice(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: '.$this->key
            ),
            CURLOPT_URL => $this->endpoint."/gasprice",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);
    }
    public function getExchangeRate(){
        $curl = curl_init();
        $data = 
        [
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/getExchangeRate",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);
    }
    public function getBalance(string $address){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: '.$this->key
            ),
            CURLOPT_URL => $this->endpoint."/balances/{$address}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $rs = json_decode($response,true);
        if(@$rs["ok"] == false){
            throw new \Exception($response);
        }
        return $rs['data'];
    }
    public function getTokenBalance(string $contract,string $address){
        $curl = curl_init();
        $e = "erc20";
        switch ($this->network) {
            case \Network::BSC:
                $e = "bep20";
                break;
            case \Network::TRON:
                break;
            case \Network::ETH:
                $e = "erc20";
                break;
        }
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: '.$this->key
            ),
            CURLOPT_URL => $this->endpoint."/balances/{$contract}/{$e}/{$address}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
        ));
        $response = curl_exec($curl);
        $rs = json_decode($response,true);
        if(@$rs["ok"] == false){
            throw new \Exception($response);
        }
        return $rs['data'];
    }
    public function getTransactionReceipt(string $txid){
        $curl = curl_init();
        $data = 
        [
            "txid" => $txid,
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/getTransactionReceipt",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);
    }
    public function listAddresses(){
        $curl = curl_init();
        $data = 
        [
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/listAddresses",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);
    }
    public function importAddress(string $filename,array $content,string $password){
        $curl = curl_init();
        $data = 
        [
            "filename" => $filename,
            "content" => $content,
            "password" => $password,
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/importAddress",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $rs = json_decode($response,true);
        if($rs["ok"] == false){
            throw new \Exception($rs["description"]);
        }
        return $rs;
    }
    public function exportAddress(string $address,string $password){
        $curl = curl_init();
        $data = 
        [
            "password" => $password,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: '.$this->key
            ),
            CURLOPT_URL => $this->endpoint."/addresses/export/{$address}",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $rs = json_decode($response,true);
        if(@$rs["ok"] == false){
            throw new \Exception($response);
        }
        return $rs['data'];
    }
    public function subscribeAddress(string $address,string $contract,string $url){
        $curl = curl_init();
        $data = 
        [
            "ethereumaddress" => $address,
            "contractaddress" => $contract,
            "url" => $url,
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/subscribeAddress",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);
    }
    public function unsubscribeAddress(string $address,string $contract,string $url){
        $curl = curl_init();
        $data = 
        [
            "ethereumaddress" => $address,
            "contractaddress" => $contract,
            "url" => $url,
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/UnsubscribeAddress",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);
    }
    public function listSubscribedAddresses(){
        $curl = curl_init();
        $data = 
        [
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/listSubscribedAddresses",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);
    }
    public function listFailedIPNs(){
        $curl = curl_init();
        $data = 
        [
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/listFailedIPNs",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);
    }
    public function resendFailedIPN(string $id){
        $curl = curl_init();
        $data = 
        [
            "id" => $id,
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/resendFailedIPN",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);
    }
    public function newAddress(string $password){
        $curl = curl_init();
        $data = 
        [
            "password" => $password,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: '.$this->key
            ),
            CURLOPT_URL => $this->endpoint."/addresses",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $rs = json_decode($response,true);
        if(@$rs["ok"] == false){
            throw new \Exception($response);
        }
        $rs = $rs['data'];
        switch ($this->network) {
            case \Network::BSC:
                $rs["address"] = $rs["binancecoinaddress"];
                break;
            case \Network::TRON:
                break;
            case \Network::ETH:
            default:
                $rs["address"] = $rs["ethereumaddress"];
        }
        return $rs;
    }
    public function deleteAddress(string $address,string $password){
        $curl = curl_init();
        $data = 
        [
            "ethereumaddress" => $address,
            "password" => $password,
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/deleteAddress",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);
    }
    public function send(float $amount,string $from,string $to,string $password){
        $url = $this->endpoint."/transactions";
        $curl = curl_init();
        $data = 
        [
            "amount" => $amount,
            "from" => $from,
            "to" => $to,
            "password" => $password,
            "gas" => $this->gas,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: '.$this->key
            ),
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $rs = json_decode($response,true);
        if(@$rs["ok"] == false){
            throw new \Exception($response);
        }
        return $rs['data'];
    }
    public function clearAddress(string $address,string $newaddress,string $password){
        $curl = curl_init();
        $data = 
        [
            "ethereumaddress" => $address,
            "newaddress" => $newaddress,
            "password" => $password,
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/clearAddress",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response,true);
    }
    public function sendToken(float $amount,string $contract,string $from,string $to,string $password){
        $curl = curl_init();
        $data = 
        [
            "amount" => $amount,
            "contractaddress" => $contract,
            "from" => $from,
            "to" => $to,
            "password" => $password,
            "gas" => $this->gas,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: '.$this->key
            ),
            CURLOPT_URL => $this->endpoint."/transactions/bep20",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $rs = json_decode($response,true);
        if(@$rs["ok"] == false){
            throw new \Exception($response);
        }
        return $rs['data'];
    }
}