<?php
class ChainGatewayApiV1{
    public $network;
    public $endpoint;
    public $key;
    public function __construct(string $key,Network $network = Network::ETH)
    {
        $this->key = $key;
        $this->setNetwork($network);
    }
    public function setNetwork(string|Network $network){
        if(is_string($network)){
            $network = cover_to_network($network);
        }
        $endpoint = "https://eu.eth.chaingateway.io/v1";
        switch ($network) {
            case Network::BSC:
                $endpoint = "https://eu.bsc.chaingateway.io/v1";
                break;
            case Network::TRON:
                $endpoint = "https://eu.trx.chaingateway.io/v1";
                break;
            case Network::ETH:
            default:
            $endpoint = "https://eu.eth.chaingateway.io/v1";
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
        $data = 
        [
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/getGasPrice",
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
        $data = 
        [
            "ethereumaddress" => $address,
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/getEthereumBalance",
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
    public function getTokenBalance(string $address,string $contract){
        $curl = curl_init();
        $data = 
        [
            "contractaddress" => $contract,
            "apikey" => $this->key,
        ];
        switch ($this->network) {
            case Network::BSC:
                $data["binancecoinaddress"] = $address;
                break;
            case Network::TRON:
                $data["ethereumaddress"] = $address;
                break;
            case Network::ETH:
            default:
            $data["ethereumaddress"] = $address;
        }
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/getTokenBalance",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));
        $response = curl_exec($curl);
        $rs = json_decode($response,true);
        if($rs["ok"] == false){
            throw new Exception($rs["description"]);
        }
        return $rs;
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
            throw new Exception($rs["description"]);
        }
        return $rs;
    }
    public function exportAddress(string $address,string $password){
        $curl = curl_init();
        $data = 
        [
            "password" => $password,
            "apikey" => $this->key,
        ];
        switch ($this->network) {
            case Network::BSC:
                $data["binancecoinaddress"] = $address;
                break;
            case Network::TRON:
                $data["ethaddress"] = $address;
                break;
            case Network::ETH:
            default:
            $data["ethaddress"] = $address;
        }
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/exportAddress",
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
            throw new Exception($rs["description"]);
        }
        switch ($this->network) {
            case Network::BSC:
                $rs["address"] = $rs["binancecoinaddress"];
                break;
            case Network::TRON:
                break;
            case Network::ETH:
            default:
                $rs["address"] = $rs["ethereumaddress"];
        }
        return $rs;
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
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/newAddress",
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
            throw new Exception($rs["description"]);
        }
        switch ($this->network) {
            case Network::BSC:
                $rs["address"] = $rs["binancecoinaddress"];
                break;
            case Network::TRON:
                break;
            case Network::ETH:
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
    public function send(string $amount,string $from,string $to,string $password,string $nonce = "15"){
        $url = $this->endpoint."/sendEthereum";
        switch ($this->network) {
            case Network::BSC:
                $url = $this->endpoint."/sendBinancecoin";
                break;
            case Network::TRON:
            case Network::ETH:
            default:
        }
        $curl = curl_init();
        $data = 
        [
            "amount" => $amount,
            "from" => $from,
            "to" => $to,
            "password" => $password,
            "nonce" => $nonce,
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
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
        if($rs["ok"] == false){
            throw new Exception($rs["description"]);
        }
        return $rs;
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
            "apikey" => $this->key,
        ];
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            ),
            CURLOPT_URL => $this->endpoint."/sendToken",
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
            throw new Exception($rs["description"]);
        }
        return $rs;
    }
}