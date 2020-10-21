<?php
declare(strict_types=1);
namespace TNC;
use TNC\Exception\TncException;
use TNC\Exception\TnxAPIException;
use TNC\HttpClient;

/**
 * Class TncCoin
 * @package TNC
 */
class TncCoin
{
    /** @var HttpClient */
    private HttpClient $httpClient;

    /**
     * TncCoin constructor.
     * @param string $ip
     * @param int|null $port
     * @param string|null $username
     * @param string|null $password
     * @param bool $https
     */
    public function __construct(string $ip, ?int $port = NULL, ?string $username = "", ?string $password = "", bool $https = false)
    {
        $this->httpClient = new \TNC\HttpClient($ip, $port, $username, $password, $https);
    }
    /**
     * @return HttpClient
     */
    public function httpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * @return array
     * @throws Exception\TnxAPIException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function dynamicGlobal(): array
    {
        $response =  $this->httpClient->sendRequest("getDynamicGlobal",[],[],"POST");
        if($response["status"]=="success")
        {
            return $response["result"];
        }
        throw new TncException("Server not working");

    }

    /**
     * @return array
     * @throws Exception\TnxAPIException
     * @throws TncException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function getConfig():array
    {
        $response =  $this->httpClient->sendRequest("getConfig",[],[],"POST");
        if($response["status"]=="success")
        {
            return $response["result"];
        }
        throw new TncException("Server not working");
    }

    /**
     * @return int
     * @throws Exception\TnxAPIException
     * @throws TncException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function getAccountCount():int
    {
        $response = $this->httpClient->sendRequest("getAccountCount",[],[],"POST");
        if($response["status"]=="success")
        {
            return $response["result"];
        }
        throw new TncException("Server not working");
    }


    /**
     * @param string $username
     * @param string $password
     * @param string $role
     * @return array
     * @throws TnxAPIException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function toWif(string $username, string $password, string $role) : array
    {
        $params = ['username' => $username, "password" => $password, "role" => $role];
        $response =  $this->httpClient->sendRequest("toWif",$params,[],"POST");
        if(!empty($response))
        {
            return $response;
        }
        throw new TnxAPIException("Server not working");
    }

    /**
     * @param string $privatekey
     * @return array
     * @throws TnxAPIException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function isWif(string $privatekey) : array
    {
        $params = ["wif" => $privatekey];
       // return $this->httpClient->sendRequest("isWif",$params,[],"POST");
        $response =  $this->httpClient->sendRequest("isWif",$params,[],"POST");
        if(!empty($response))
        {
            return $response;
        }
        throw new TnxAPIException("Server not working");
    }

    /**
     * @param string $privateKey
     * @return array
     * @throws TnxAPIException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function wifToPublic(string $privateKey) : array
    {
        $params = ["private_key" => $privateKey];
        $response =  $this->httpClient->sendRequest("wifToPublic",$params,[],"POST");
        if(!empty($response))
        {
            return $response;
        }
        throw new TnxAPIException("Server not working");
    }


    /**
     * @param string $privateKey
     * @param string $publicKey
     * @throws TnxAPIException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function wifIsValid(string $privateKey , string $publicKey)
    {
        $params = ["private_key" => $privateKey , "public_key" => $publicKey];
        $response = $this->httpClient->sendRequest("wifIsValid",$params,[],"POST");
        if(!empty($response))
        {
            return $response;
        }
        throw new TnxAPIException("Server not working");

    }

}
