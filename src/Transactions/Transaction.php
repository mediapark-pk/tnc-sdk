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
    public function __construct(array $tx)
    {
//        $status = $tx["status"];
//        if(!is_array($status) || !$status) {
//            throw new TncException('No "status" object in response tx');
//        }
    }


}