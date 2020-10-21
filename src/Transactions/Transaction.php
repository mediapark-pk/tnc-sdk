<?php
declare(strict_types=1);
namespace TNC\Transactions;
use TNC\Exception\TncException;

/**
 * Class Transaction
 * @package TNC\Transactions
 */
class Transaction
{
    /** @var int  */
    public int $refBlockNum;
    /** @var int  */
    public int $refBlockPrefix;
    /** @var string  */
    public string $creator;
    /** @var string  */
    public string $signature;
    /** @var string  */
    public string $transactionId;
    /** @var int  */
    public int $blockNum;
    /** @var int  */
    public int $transactionNum;

    /**
     * Transaction constructor.
     * @param array $tx
     * @throws TncException
     */
    public function __construct(array $data)
    {

        $this->refBlockNum = $data['result']['ref_block_num'];
        $this->refBlockPrefix = $data['result']['ref_block_prefix'];
        if($data['result']["operations"]) {
            $this->creator = $data['result']["operations"][0][1]["creator"];
        }
        $this->signature = $data['result']["signatures"][0];
        $this->transactionId = $data['result']["transaction_id"];
        $this ->blockNum = $data['result']["block_num"];
        $this->transactionNum = $data['result']["transaction_num"];
    }


}