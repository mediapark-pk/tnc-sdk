<?php
declare(strict_types=1);

namespace TNC\Accounts;


use http\Exception\InvalidArgumentException;
use TNC\Exception\TncException;
use TNC\TncCoin;

/**
 * Class AccountFactory
 * @package TNC\Accounts
 */
class AccountFactory
{
    /** @var TncCoin  */
    private TncCoin $tnc;

    /**
     * AccountFactory constructor.
     * @param TncCoin $tnc
     */
    public function __construct(TncCoin $tnc)
    {
        $this->tnc=$tnc;
    }

    /**
     * @param array $usernames
     * @return array
     * @throws TncException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     * @throws \TNC\Exception\TncAPIException
     */
    public function getAccounts(array $usernames) :array
    {
        $params=array (
            'usernames' => json_encode($usernames),
        );
        $response =$this->tnc->httpClient()->sendRequest("getAccounts",$params,[],"POST");
        if(($response["status"]=="success") && ($response["result"]))
        {
            $results=[];
            foreach ($response["result"] as $result)
            {
                $results[]=new Account($result);
            }
            return $results;
        }

        throw new TncException("Nothing Found!");
    }

    /**
     * @param string $username
     * @return string
     * @throws TncException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     * @throws \TNC\Exception\TncAPIException
     */
    public function getAccountBalance(string $username):float
    {
        $username = [$username];
        $params=array (
            'usernames' => json_encode($username),
        );
        $response =$this->tnc->httpClient()->sendRequest("getAccounts",$params,[],"POST");
        if(($response["status"]=="success") && ($response["result"]))
        {

            return (float)$response["result"][0]["balance"];
        }

        throw new TncException("Nothing Found!");
    }

    /**
     * @param string $creator
     * @param string $creatorWif
     * @param string $username
     * @param string $password
     * @return Account
     * @throws TncException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     * @throws \TNC\Exception\TncAPIException
     */
    public function createAccount(string $creator, string $creatorWif, string $username, string $password):array
    {
        $param =["creator"=>$creator,"creator_wif"=>$creatorWif,"username"=>$username,"password"=>$password];
        $response=$this->tnc->httpClient()->sendRequest("createAccount",$param,[],"POST");
        if($response["status"]=="success" && $response["result"])
        {
            $data =$response["result"];
            return [
                "id"=>$data["id"],
                "blockNumber"=>$data["block_num"],
                "trxNum"=>$data["trx_num"],
                "expired"=>$data["expired"]
            ];
        }
        else if($response["status"]=="fail")
        {
            throw new TncException($response["result"]["message"]);
        }
        throw new TncException("Server not working");

    }

    /**
     * @param string $username
     * @param string $oldPassword
     * @param string $password
     * @return array
     * @throws TncException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     * @throws \TNC\Exception\TncAPIException
     */
    public function updateAccountPassword(string $username, string $oldPassword, string $password):array
    {
        $param = ["username"=>$username,"old_password"=>$oldPassword,"password"=>$password];
        $response = $this->tnc->httpClient()->sendRequest("updateAccount",$param,[],"POST");
        if($response["status"]=="success" && $response["result"])
        {
            $data =$response["result"];
            return [
                "id"=>$data["id"],
                "blockNumber"=>$data["block_num"],
                "trxNum"=>$data["trx_num"],
                "expired"=>$data["expired"]
            ];
        }
        else if($response["status"]=="fail")
        {
            throw new TncException($response["result"]["message"]);
        }
    }
}