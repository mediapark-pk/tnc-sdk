<?php
declare(strict_types=1);

namespace TNC\Transactions;

use TNC\TncCoin;
use TNC\Exception\TncException;

/**
 * Class TxFactory
 * @package TNC\Transactions
 */
class TxFactory
{
    /** @var TncCoin  */
    private TncCoin $tncCoin;

    /**
     * TxFactory constructor.
     * @param TncCoin $tc
     */
    public function __construct(TncCoin $tc)
    {
        $this->tncCoin = $tc;
    }


    /**
     * @param string $txId
     * @return Transaction
     * @throws TncException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     * @throws \TNC\Exception\TncAPIException
     */
    public function getTransactionById(string $txId)  //: Transaction
    {
        $param = ["transaction_id"=>$txId];

        $data = $this->tncCoin->httpClient()->sendRequest("getTransaction", $param,[],"POST");
        print_r($data);
        if(($data["status"]=="success")&&($data["result"]))
        {
            return new Transaction($data);
        }
        throw new TncException($data["result"]??"Nothing Found");

    }

}