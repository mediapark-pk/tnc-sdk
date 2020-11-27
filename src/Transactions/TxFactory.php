<?php
declare(strict_types=1);

namespace MediaParkPK\TNC\Transactions;

<<<<<<< HEAD
use Comely\Http\Exception\HttpRequestException;
use Comely\Http\Exception\HttpResponseException;
use Comely\Http\Exception\SSL_Exception;
use TNC\Exception\TncAPIException;
use TNC\TncCoin;
use TNC\Exception\TncException;
=======
use MediaParkPK\TNC\Exception\TNC_APIResponseException;
use MediaParkPK\TNC\TNC_Client;
>>>>>>> 9e417ea224497d31264febadc721afdac6e151c8

/**
 * Class TxFactory
 * @package MediaParkPK\TNC\Transactions
 */
class TxFactory
{
    /** @var TNC_Client */
    private TNC_Client $tncCoin;

    /**
     * TxFactory constructor.
     * @param TNC_Client $tc
     */
    public function __construct(TNC_Client $tc)
    {
        $this->tncCoin = $tc;
    }

    /**
     * @param string $txId
     * @return Transaction
<<<<<<< HEAD
     * @throws TncException
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     * @throws TncAPIException
=======
     * @throws TNC_APIResponseException
     * @throws \MediaParkPK\TNC\Exception\TNC_APIException
>>>>>>> 9e417ea224497d31264febadc721afdac6e151c8
     */
    public function getTransactionById(string $txId): Transaction
    {
        if (!$txId) {
            throw new \InvalidArgumentException('Transaction id is required');
        }

<<<<<<< HEAD
        $data = $this->tncCoin->httpClient()->sendRequest("getTransaction", $param,[],"POST");

        print_r($data);
        die();


//        if(($data["status"]=="success")&&($data["result"]))
//        {
//            return new Transaction($data);
//        }
//        throw new TncException($data["result"]??"Nothing Found");
=======
        $params = [
            "transaction_id" => $txId
        ];
        $result = $this->tncCoin->callAPI("getTransaction", $params);

        if (!is_array($result) || !$result) {
            throw TNC_APIResponseException::unexpectedResultType("getTransaction", "object", gettype($result));
        }
>>>>>>> 9e417ea224497d31264febadc721afdac6e151c8

        return new Transaction($result);
    }
}
