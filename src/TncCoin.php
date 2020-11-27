<?php
declare(strict_types=1);
namespace TNC;
use Comely\Http\Exception\HttpRequestException;
use Comely\Http\Exception\HttpResponseException;
use Comely\Http\Exception\SSL_Exception;
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
    public function __construct(string $ip, ?int $port = NULL, ?string $username = "", ?string $password = "",
                                bool $https = false)
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
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     * @throws TncAPIException
     * @throws TncException
     */
    public function dynamicGlobal(): array
    {
        $response =  $this->httpClient->sendRequest("getDynamicGlobal");
        if($response["status"]=="success"&&$response["result"])
        {
            return $response["result"];
        }
        throw new TncException("Server not working");

    }

    /**
     * @return array
     * @throws Exception\TncAPIException
     * @throws TncException
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     */
    public function getConfig():array
    {
        $response =  $this->httpClient->sendRequest("getConfig");
        if($response["status"]=="success"&&$response["result"])
        {
            return $response["result"];
        }
        throw new TncException("Server not working");
    }

    /**
     * @return int
     * @throws Exception\TncAPIException
     * @throws TncException
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     */
    public function getAccountCount():int
    {
        $response = $this->httpClient->sendRequest("getAccountCount");
        if($response["status"]=="success"&&$response["result"])
        {
            return $response["result"];
        }
        throw new TncException("Server not working");
    }

    /**
     * @param string $username
     * @param string $password
     * @return string
     * @throws TncAPIException
     * @throws TncException
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     */
    public function login(string $username, string $password)
    {
        $param = ["username"=>$username,"password"=>$password];
        $response =$this->httpClient->sendRequest("login",$param);
        if($response["auth"])
        {
            return "Logged In!";
        }
        throw new TncException("Login Failed");
    }

    /**
     * @param string $lowerBoundName
     * @param int $limit
     * @return mixed
     * @throws Exception\TncAPIException
     * @throws TncException
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     */
    public function lookUpAccounts(string $lowerBoundName, int $limit)
    {
        $param = ["lowerBoundName"=>$lowerBoundName,"limit"=>$limit];
        $response = $this->httpClient->sendRequest("lookupAccounts",$param);
        if($response["status"]=="success"&&$response["result"])
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
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     */
    public function getAccountHistory(string $account, int $from, int $limit=0)
    {
        if($from<0||$limit<0)
        {
            throw new TncException("From & Limit Must Be Greater Than 0");
        }
        if($from<$limit)
        {
            throw new TncException("From Must Be Greater Than Limit");
        }
        $param = ["account"=>$account,"from"=>$from,"limit"=>$limit];
        $response = $this->httpClient->sendRequest("getAccountHistory",$param);
        if($response["status"]=="success"&&$response["result"])
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
     * @return string
     * @throws TncAPIException
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     */
    public function toWif(string $username, string $password, string $role="owner") : string
    {
        $params = ['username' => $username, "password" => $password, "role" => $role];
        $response =  $this->httpClient->sendRequest("toWif",$params);
        if($response["result"])
        {
            return $response["result"];
        }
        throw new TncAPIException("Server not working");
    }

    /**
     * @param string $privatekey
     * @return bool
     * @throws TncAPIException
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     */
    public function isWif(string $privatekey) : bool
    {
        $params = ["wif" => $privatekey];
       // return $this->httpClient->sendRequest("isWif",$params,[],"POST");
        $response =  $this->httpClient->sendRequest("isWif",$params);
        if($response["status"]=="success"&&$response["result"])
        {
            return $response["result"];
        }
        throw new TncAPIException("False");
    }

    /**
     * @param string $privateKey
     * @return array
     * @throws TncAPIException
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     */
    public function wifToPublic(string $privateKey) : string
    {
        $params = ["private_key" => $privateKey];
        $response =  $this->httpClient->sendRequest("wifToPublic",$params);
        if($response["status"]=="success"&&$response["result"])
        {
            return $response["result"];
        }
        throw new TncAPIException("Incorrect Private Key");
    }


    /**
     * @param string $privateKey
     * @param string $publicKey
     * @return array
     * @throws TncAPIException
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     */
    public function wifIsValid(string $privateKey , string $publicKey) : bool
    {
        $params = ["private_key" => $privateKey , "public_key" => $publicKey];
        $response = $this->httpClient->sendRequest("wifIsValid",$params);
        if($response["status"]=="success"&&$response["result"])
        {
            return $response["result"];
        }
        throw new TncAPIException("False");
    }

    /**
     * @param string $username
     * @param string $password
     * @param array $roles
     * @return array
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     * @throws TncAPIException
     */
    public function getPrivateKeys(string $username , string $password, array $roles) : array
    {
        $params = ["username" => $username , "password" => $password , 'roles' => json_encode($roles)];
        $response = $this->httpClient->sendRequest("getPrivateKeys",$params);
        if($response["result"])
        {
            return $response["result"];
        }
        throw new TncAPIException("Server not working");
    }

    /**
     * @param string $from
     * @param string $fromPassword
     * @param string $to
     * @param string $amount
     * @param string|null $memo
     * @param string|null $memo_key
     * @return array
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     * @throws TncAPIException
     * @throws TncException
     */
    public function transfer(string $from, string $fromPassword, string $to , string $amount, ?string $memo ="",
                             ?string $memo_key=""):array
    {
        if(!$from)
        {
            throw  new TncException("From cannot be null");
        }
        if(!$fromPassword)
        {
            throw  new TncException("From Password cannot be null");
        }
        if(!$to)
        {
            throw  new TncException("To cannot be null");
        }
        $params = [
            "from" => $from,
            "from_pwd" => $fromPassword,
            "to" => $to ,
            "amount" => $amount ,
            "memo" => $memo,
            "memo_Key" => $memo_key
        ];
        $response = $this->httpClient->sendRequest("transfer",$params);

        if($response["status"]=="success"&& $response["result"])
        {
            return $response["result"];
        }
        else if($response["status"]=="fail")
        {
           throw new TncException($response["result"]["message"]);
        }
        throw new TncException("Server not found");
    }
}
