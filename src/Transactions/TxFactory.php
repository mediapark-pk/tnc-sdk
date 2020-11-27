<?php
declare(strict_types=1);

namespace TNC\Transactions;

use Comely\Http\Exception\HttpRequestException;
use Comely\Http\Exception\HttpResponseException;
use Comely\Http\Exception\SSL_Exception;
use TNC\Exception\TncAPIException;
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
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     * @throws TncAPIException
     */
    public function getTransactionById(string $txId)  //: Transaction
    {
        if(!$txId)
        {
            throw new TncException("TxId cannot be null");
        }
        $param = ["transaction_id"=>$txId];

        $data = $this->tncCoin->httpClient()->sendRequest("getTransaction", $param,[],"POST");

        print_r($data);
        die();


//        if(($data["status"]=="success")&&($data["result"]))
//        {
//            return new Transaction($data);
//        }
//        throw new TncException($data["result"]??"Nothing Found");

    }

}