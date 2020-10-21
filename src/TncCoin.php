<?php
declare(strict_types=1);
namespace TNC;
use TNC\Exception\TncException;
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
     * @return mixed
     * @throws Exception\TnxAPIException
     * @throws TncException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function login(string $username, string $password)
    {
        $param = ["username"=>$username,"password"=>$password];
        $response =$this->httpClient->sendRequest("login",$param,[],"POST");
        if($response["auth"])
        {
            return $response["result"];
        }
        throw new TncException("Login Failed");
    }

    /**
     * @param string $lowerBoundName
     * @param int $limit
     * @return mixed
     * @throws Exception\TnxAPIException
     * @throws TncException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function lookupAccounts(string $lowerBoundName, int $limit)
    {
        $param = ["lowerBoundName"=>$lowerBoundName,"limit"=>$limit];
        $response = $this->httpClient->sendRequest("lookupAccounts",$param,[],"POST");
        if($response["status"]=="success")
        {
            return $response["result"];
        }
        throw new TncException("Server not working");
    }

    /**
     * @param string $account
     * @param int $from
     * @param int $limit
     * @return mixed
     * @throws Exception\TnxAPIException
     * @throws TncException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function getAccountHistory(string $account, int $from, int $limit)
    {
        if($from<$limit)
        {
            throw new TncException("From Must Be Greater Than Limit");
        }
        $param = ["account"=>$account,"from"=>$from,"limit"=>$limit];
        $response = $this->httpClient->sendRequest("getAccountHistory",$param,[],"POST");
        if($response["status"]=="success")
        {
            return $response["result"];
        }
        else if($response["status"]=="fail")
        {
            throw new TncException($response["result"]["message"]);
        }
        throw new TncException("Server not working");
    }




}