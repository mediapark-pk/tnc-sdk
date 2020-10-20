<?php
declare(strict_types=1);
namespace TNC\Transactions;
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
     */
    public function __construct()
    {

    }

}