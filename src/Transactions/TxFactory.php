<?php
declare(strict_types=1);

namespace MediaParkPK\TNC\Transactions;


use Comely\Http\Exception\HttpRequestException;
use Comely\Http\Exception\HttpResponseException;
use Comely\Http\Exception\SSL_Exception;
use TNC\Exception\TncAPIException;
use TNC\Exception\TncException;
use MediaParkPK\TNC\TNC_Client;

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
     * @throws TncException
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     * @throws TncAPIException

     */
    public function getTransactionById(string $txId): Transaction
    {
        if (!$txId) {
            throw new \InvalidArgumentException('Transaction id is required');
        }

        $params = [
            "transaction_id" => $txId
        ];
        $result = $this->tncCoin->callAPI("getTransaction", $params);

        if (!is_array($result) || !$result) {
            throw TNC_APIResponseException::unexpectedResultType("getTransaction", "object", gettype($result));
        }

        return new Transaction($result);
    }
}
