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
     */
    public function __construct(TncCoin $tc)
    {
        $this->tncCoin = $tc;
    }

    /**
     * @param string $txId
     * @return Transaction
     */
    public function getById(string $txId) : Transaction
    {
        $tx = $this->tncCoin->httpClient()->sendRequest();
       return new Transaction($tx);
    }
}