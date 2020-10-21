<?php
declare(strict_types=1);
namespace TNC;
use TNC\Exception\TncException;
use TNC\Exception\TncAPIException;
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
     * @throws Exception\TncAPIException
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
     * @throws Exception\TncAPIException
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
     * @throws Exception\TncAPIException
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
     * @throws Exception\TncAPIException
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
     * @throws Exception\TncAPIException
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
     * @throws Exception\TncAPIException
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




    /**
     * @param string $username
     * @param string $password
     * @param string $role
     * @return array
     * @throws TncAPIException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function toWif(string $username, string $password, string $role) : array
    {
        $params = ['username' => $username, "password" => $password, "role" => $role];
        $response =  $this->httpClient->sendRequest("toWif",$params,[],"POST");
        if($response&&$response["result"])
        {
            return $response;
        }
        throw new TncAPIException("Server not working");
    }

    /**
     * @param string $privatekey
     * @return bool
     * @throws TncAPIException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function isWif(string $privatekey) : bool
    {
        $params = ["wif" => $privatekey];
       // return $this->httpClient->sendRequest("isWif",$params,[],"POST");
        $response =  $this->httpClient->sendRequest("isWif",$params,[],"POST");
        if($response&&$response["result"])
        {
            return (bool)$response;
        }
        throw new TncAPIException("False");
    }

    /**
     * @param string $privateKey
     * @return array
     * @throws TncAPIException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function wifToPublic(string $privateKey) : array
    {
        $params = ["private_key" => $privateKey];
        $response =  $this->httpClient->sendRequest("wifToPublic",$params,[],"POST");
        if($response&&$response["result"])
        {
            return $response;
        }
        throw new TncAPIException("False");
    }


    /**
     * @param string $privateKey
     * @param string $publicKey
     * @return array
     * @throws TncAPIException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function wifIsValid(string $privateKey , string $publicKey) : array
    {
        $params = ["private_key" => $privateKey , "public_key" => $publicKey];
        $response = $this->httpClient->sendRequest("wifIsValid",$params,[],"POST");
        if($response&&$response["result"])
        {
            return $response;
        }
        throw new TncAPIException("False");
    }

    /**
     * @param string $username
     * @param string $password
     * @param array $roles
     * @return array
     * @throws TnxAPIException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     */
    public function getPrivateKeys(string $username , string $password, array $roles) : array
    {
        $params = ["username" => $username , "password" => $password , 'roles' => json_encode($roles)];
        $response = $this->httpClient->sendRequest("getPrivateKeys",$params,[],"POST");
        if($response&&$response["result"])
        {
            return $response["result"];
        }
        throw new TncAPIException("Server not working");
    }

}
