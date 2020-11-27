<?php
declare(strict_types=1);

namespace MediaParkPK\TNC\Transactions;

use MediaParkPK\TNC\Exception\TNC_APIResponseException;
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
     * @throws TNC_APIResponseException
     * @throws \MediaParkPK\TNC\Exception\TNC_APIException
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
