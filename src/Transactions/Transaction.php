<?php
declare(strict_types=1);

namespace MediaParkPK\TNC\Transactions;

/**
 * Class Transaction
 * @package MediaParkPK\TNC\Transactions
 */
class Transaction
{
    /** @var int */
    public int $refBlockNum;
    /** @var int */
    public int $refBlockPrefix;
    /** @var array */
    public array $operations;
    /** @var string */
    public string $signature;
    /** @var string */
    public string $transactionId;
    /** @var int */
    public int $blockNum;
    /** @var int */
    public int $transactionNum;

    /**
     * Transaction constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {

        $this->refBlockNum = (int)$data['ref_block_num'];
        $this->refBlockPrefix = (int)$data['ref_block_prefix'];
        if ($data["operations"]) {
            $this->operations = $data["operations"];
        }
        $this->signature = $data["signatures"][0];
        $this->transactionId = $data["transaction_id"];
        $this->blockNum = $data["block_num"];
        $this->transactionNum = $data["transaction_num"];
    }
}
