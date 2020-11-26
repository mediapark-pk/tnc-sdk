<?php
declare(strict_types=1);

namespace TNC\Accounts;


use Comely\Http\Exception\HttpRequestException;
use Comely\Http\Exception\HttpResponseException;
use Comely\Http\Exception\SSL_Exception;
use http\Exception\InvalidArgumentException;
use TNC\Exception\TncAPIException;
use TNC\Exception\TncException;
use TNC\TncCoin;

/**
 * Class AccountFactory
 * @package TNC\Accounts
 */
class AccountFactory
{
    /** @var TncCoin */
    private TncCoin $tnc;

    /**
     * AccountFactory constructor.
     * @param TncCoin $tnc
     */
    public function __construct(TncCoin $tnc)
    {
        $this->tnc = $tnc;
    }

    /**
     * @param array $usernames
     * @return array
     * @throws TncException
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     * @throws TncAPIException
     */
    public function getAccounts(array $usernames): array
    {
        $params = array(
            'usernames' => json_encode($usernames),
        );
        $response = $this->tnc->httpClient()->sendRequest("getAccounts", $params, [], "POST");
        if (($response["status"] == "success") && ($response["result"])) {
            $results = [];
            foreach ($response["result"] as $result) {
                $results[] = new Account($result);
            }
            return $results;
        }

        throw new TncException("Nothing Found!");
    }

    /**
     * @param string $username
     * @return float
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     * @throws TncAPIException
     * @throws TncException
     */
    public function getAccountBalance(string $username): float
    {
        if(!$username)
        {
            throw new TncException("Username must not be empty");
        }
        $username = [$username];
        $params = array(
            'usernames' => json_encode($username),
        );
        $response = $this->tnc->httpClient()->sendRequest("getAccounts", $params, [], "POST");
        if (($response["status"] == "success") && ($response["result"])) {

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
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     * @throws TncAPIException
     */
    public function createAccount(string $creator, string $creatorWif, string $username, string $password): array
    {
        if(!($username) )
        {
            throw new TncException("Username must not be empty");
        }
        if( !($password))
        {
            throw new TncException("Password must not be empty");
        }
        $param = ["creator" => $creator, "creator_wif" => $creatorWif, "username" => $username, "password" => $password];
        $response = $this->tnc->httpClient()->sendRequest("createAccount", $param, [], "POST");
        if ($response["status"] == "success" && $response["result"]) {
            $data = $response["result"];
            return [
                "id" => $data["id"],
                "blockNumber" => $data["block_num"],
                "trxNum" => $data["trx_num"],
                "expired" => $data["expired"]
            ];
        } else if ($response["status"] == "fail") {
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
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     * @throws TncAPIException
     */
    public function updateAccountPassword(string $username, string $oldPassword, string $password): array
    {
        $checkResponse=self::checkPassword($password);
        if($checkResponse)
        {
            throw new TncAPIException(sprintf('%s %s %s',$checkResponse[0],$checkResponse[1],$checkResponse[2]));
        }

        $param = ["username" => $username, "old_password" => $oldPassword, "password" => $password];
        $response = $this->tnc->httpClient()->sendRequest("updateAccount", $param, [], "POST");
        if ($response["status"] == "success" && $response["result"]) {
            $data = $response["result"];
            return [
                "id" => $data["id"],
                "blockNumber" => $data["block_num"],
                "trxNum" => $data["trx_num"],
                "expired" => $data["expired"]
            ];
        } else if ($response["status"] == "fail") {
            throw new TncException($response["result"]["message"]);
        }
    }


    /**
     * @param $pwd
     * @return array
     */
    public function checkPassword($pwd): array
    {
        $errors = [];

        if (strlen($pwd) < 8) {
            $errors[] = "Password too short!";
        }

        if (!preg_match("#[0-9]+#", $pwd)) {
            $errors[] = "Password must include at least one number!";
        }

        if (!preg_match("#[a-zA-Z]+#", $pwd)) {
            $errors[] = "Password must include at least one letter!";
        }

        return $errors;
    }
}