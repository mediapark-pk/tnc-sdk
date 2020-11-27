<?php
declare(strict_types=1);

namespace MediaParkPK\TNC\Accounts;

use MediaParkPK\TNC\Exception\TNC_APIResponseException;
use MediaParkPK\TNC\TNC_Client;

/**
 * Class AccountFactory
 * @package MediaParkPK\TNC\Accounts
 */
class AccountFactory
{
    /** @var TNC_Client */
    private TNC_Client $tnc;

    /**
     * AccountFactory constructor.
     * @param TNC_Client $tnc
     */
    public function __construct(TNC_Client $tnc)
    {
        $this->tnc = $tnc;
    }

    /**
     * @param array $usernames
     * @return array
     * @throws TNC_APIResponseException
     * @throws \MediaParkPK\TNC\Exception\TNC_APIException
     */
    public function getAccounts(array $usernames): array
    {
        $params = [
            "username" => json_encode($usernames),
        ];

        $result = $this->tnc->callAPI("getAccounts", $params);
        if (!is_array($result)) {
            throw TNC_APIResponseException::unexpectedResultType("getAccounts", "array", gettype($result));
        }

        $accounts = [];
        foreach ($result as $acc) {
            $accounts[] = new Account($acc);
        }

        return $accounts;
    }

    /**
     * @param string $username
     * @return string
     * @throws TNC_APIResponseException
     * @throws \MediaParkPK\TNC\Exception\TNC_APIException
     */
    public function getAccountBalance(string $username): string
    {
        if (!$username) {
<<<<<<< HEAD
            throw new TncException("Username must not be empty");
=======
            throw new \InvalidArgumentException("Username must not be empty");
>>>>>>> 9e417ea224497d31264febadc721afdac6e151c8
        }

        $params = [
            "usernames" => json_encode([$username])
        ];

        $result = $this->tnc->callAPI("getAccounts", $params);
        if (!is_array($result)) {
            throw TNC_APIResponseException::unexpectedResultType("getAccountBalance", "array", gettype($result));
        }

        return strval($result[0]["balance"]);
    }

    /**
     * @param string $creator
     * @param string $creatorWif
     * @param string $username
     * @param string $password
     * @return array
     * @throws TNC_APIResponseException
     * @throws \MediaParkPK\TNC\Exception\TNC_APIException
     */
    public function createAccount(string $creator, string $creatorWif, string $username, string $password): array
    {
<<<<<<< HEAD
        if (!($username)) {
            throw new TncException("Username must not be empty");
        }
        if (!($password)) {
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
=======
        $params = [
            "creator" => $creator,
            "creator_wif" => $creatorWif,
            "username" => $username,
            "password" => $password
        ];

        $result = $this->tnc->callAPI("createAccount", $params);
        if (!is_array($result)) {
            throw TNC_APIResponseException::unexpectedResultType("createAccount", "object", gettype($result));
>>>>>>> 9e417ea224497d31264febadc721afdac6e151c8
        }

        return [
            "id" => $result["id"],
            "blockNumber" => $result["block_num"],
            "trxNum" => $result["trx_num"],
            "expired" => $result["expired"]
        ];
    }

    /**
     * @param string $username
     * @param string $oldPassword
     * @param string $password
     * @return array
     * @throws TNC_APIResponseException
     * @throws \MediaParkPK\TNC\Exception\TNC_APIException
     */
    public function updateAccountPassword(string $username, string $oldPassword, string $password): array
    {
<<<<<<< HEAD
        $checkResponse = self::checkPassword($password);
        if ($checkResponse) {
            throw new TncAPIException(sprintf('%s %s %s', $checkResponse[0], $checkResponse[1], $checkResponse[2]));
=======
        $checkResponse = $this->checkPassword($password);
        if ($checkResponse) {
            throw new TNC_APIResponseException(implode(" ", $checkResponse));
>>>>>>> 9e417ea224497d31264febadc721afdac6e151c8
        }

        $params = [
            "username" => $username,
            "old_password" => $oldPassword,
            "password" => $password
        ];

        $result = $this->tnc->callAPI("updateAccount", $params);
        if (!is_array($result)) {
            throw TNC_APIResponseException::unexpectedResultType("updateAccount", "object", gettype($result));
        }

        return [
            "id" => $result["id"],
            "blockNumber" => $result["block_num"],
            "trxNum" => $result["trx_num"],
            "expired" => $result["expired"]
        ];
    }

    /**
     * @param $pwd
     * @return array
     */
    private function checkPassword($pwd): array
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
