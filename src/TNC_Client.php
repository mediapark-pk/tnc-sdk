<?php
declare(strict_types=1);

namespace MediaParkPK\TNC;

use MediaParkPK\TNC\Exception\TNC_APIException;
use MediaParkPK\TNC\Exception\TNC_APIResponseException;
use MediaParkPK\TNC\Transactions\TxFactory;

/**
 * Class TNC_Client
 * @package MediaParkPK\TNC
 */
class TNC_Client
{
    /** @var HttpClient */
    private HttpClient $httpClient;
    /** @var TxFactory */
    private TxFactory $txF;

    /**
     * TNC_Client constructor.
     * @param string $ip
     * @param int $port
     */
    public function __construct(string $ip, int $port)
    {
        $this->httpClient = new HttpClient($ip, $port);
        $this->txF = new TxFactory($this);
    }

    /**
     * @return HttpClient
     */
    private function httpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * @return TxFactory
     */
    public function txFactory(): TxFactory
    {
        return $this->txF;
    }

    /**
     * @param string $endpoint
     * @param array $params
     * @return mixed
     * @throws TNC_APIException
     * @throws TNC_APIResponseException
     */
    public function callAPI(string $endpoint, array $params = [])
    {
        $response = $this->httpClient->request($endpoint, $params);
        $status = isset($response["status"]) && $response["status"] === "success";
        if ($status && isset($response["result"])) {
            return $response["result"];
        }

        $failMsg = $response["result"]["message"] ?? null;
        if (!$failMsg) {
            $failMsg = 'API request failed';
        }

        throw new TNC_APIResponseException($failMsg);
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     * @throws Exception\TNC_APIException
     */
    public function login(string $username, string $password): bool
    {
        $params = [
            "username" => $username,
            "password" => $password
        ];

        $response = $this->httpClient->request("login", $params);
        return isset($response["auth"]);
    }

    /**
     * @return array
     * @throws TNC_APIException
     * @throws TNC_APIResponseException
     */
    public function dynamicGlobal(): array
    {
        $result = $this->callAPI("getDynamicGlobal");
        if (!is_array($result)) {
            throw TNC_APIResponseException::unexpectedResultType("getDynamicGlobal", "object", gettype($result));
        }

        return $result;
    }

    /**
     * @return array
     * @throws TNC_APIException
     * @throws TNC_APIResponseException
     */
    public function getConfig(): array
    {
        $result = $this->callAPI("getConfig");
        if (!is_array($result)) {
            throw TNC_APIResponseException::unexpectedResultType("getConfig", "object", gettype($result));
        }

        return $result;
    }

    /**
     * @return int
     * @throws TNC_APIException
     * @throws TNC_APIResponseException
     */
    public function getAccountCount(): int
    {
        $result = $this->callAPI("getAccountCount");
        if (!is_int($result)) {
            throw TNC_APIResponseException::unexpectedResultType("getAccountCount", "int", gettype($result));
        }

        return $result;
    }

    /**
     * @param string $lowerBoundName
     * @param int $limit
     * @return array
     * @throws TNC_APIException
     */
    public function lookUpAccounts(string $lowerBoundName, int $limit)
    {
        $params = [
            "lowerBoundName" => $lowerBoundName,
            "limit" => $limit
        ];

        // Todo: determine return type
        return $this->httpClient->request("lookupAccounts", $params);
    }

    /**
     * @param string $account
     * @param int $from
     * @param int $limit
     * @return array
     * @throws TNC_APIException
     * @throws TNC_APIResponseException
     */
    public function getAccountHistory(string $account, int $from, int $limit = 0)
    {
        if ($from < 0 || $limit < 0) {
            throw new \OutOfRangeException("Args for from and limit must be positive int");
        } elseif ($from < $limit) {
            throw new \InvalidArgumentException("Value for arg from must be greater than limit");
        }

        $params = [
            "account" => $account,
            "from" => $from,
            "limit" => $limit
        ];

        $result = $this->callAPI("getAccountHistory", $params);
        if (!is_array($result)) {
            throw TNC_APIResponseException::unexpectedResultType("getAccountHistory", "object", gettype($result));
        }

        return $result;
    }

    /**
     * @param string $username
     * @param string $password
     * @param string $role
     * @return string
     * @throws TNC_APIException
     * @throws TNC_APIResponseException
     */
    public function toWIF(string $username, string $password, string $role = "owner"): string
    {
        $params = [
            "username" => $username,
            "password" => $password,
            "role" => $role
        ];

        $result = $this->callAPI("toWif", $params);
        if (!is_string($result) || !$result) {
            throw TNC_APIResponseException::unexpectedResultType("toWif", "string", gettype($result));
        }

        return $result;
    }

    /**
     * @param string $privateKey
     * @return bool
     * @throws TNC_APIException
     * @throws TNC_APIResponseException
     */
    public function isWIF(string $privateKey): bool
    {
        $result = $this->callAPI("isWif", ["wif" => $privateKey]);
        if (!is_bool($result)) {
            throw TNC_APIResponseException::unexpectedResultType("toWif", "boolean", gettype($result));
        }

        return $result;
    }

    /**
     * @param string $privateKey
     * @return string
     * @throws TNC_APIException
     * @throws TNC_APIResponseException
     */
    public function wifToPublic(string $privateKey): string
    {
        $params = [
            "private_key" => $privateKey
        ];

        $result = $this->callAPI("wifToPublic", $params);
        if (!is_string($result) || !$result) {
            throw TNC_APIResponseException::unexpectedResultType("wifToPublic", "string", gettype($result));
        }

        return $result;
    }

    /**
     * @param string $privateKey
     * @param string $publicKey
     * @return bool
     * @throws TNC_APIException
     * @throws TNC_APIResponseException
     */
    public function wifIsValid(string $privateKey, string $publicKey): bool
    {
        $params = [
            "private_key" => $privateKey,
            "public_key" => $publicKey
        ];

        $result = $this->callAPI("wifIsValid", $params);
        if (!is_bool($result)) {
            throw TNC_APIResponseException::unexpectedResultType("wifIsValid", "boolean", gettype($result));
        }

        return $result;
    }

    /**
     * @param string $username
     * @param string $password
     * @param array $roles
     * @return array
     * @throws TNC_APIException
     * @throws TNC_APIResponseException
     */
    public function getPrivateKeys(string $username, string $password, array $roles): array
    {
        $params = [
            "username" => $username,
            "password" => $password,
            "roles" => json_encode($roles)
        ];

        $result = $this->callAPI("getPrivateKeys", $params);
        if (!is_array($result)) {
            throw TNC_APIResponseException::unexpectedResultType("getPrivateKeys", "object", gettype($result));
        }

        return $result;
    }

    /**
     * @param string $from
     * @param string $fromPassword
     * @param string $to
     * @param string $amount
     * @param string|null $memo
     * @param string|null $memo_key
     * @return array
     * @throws TNC_APIException
     * @throws TNC_APIResponseException
     */
    public function transfer(string $from, string $fromPassword, string $to, string $amount, ?string $memo = "", ?string $memo_key = ""): array
    {
        $params = [
            "from" => $from,
            "from_pwd" => $fromPassword,
            "to" => $to,
            "amount" => $amount,
            "memo" => $memo,
            "memo_Key" => $memo_key
        ];

        $result = $this->callAPI("transfer", $params);
        if (!is_array($result)) {
            throw TNC_APIResponseException::unexpectedResultType("transfer", "object", gettype($result));
        }

        return $result;
    }
}
