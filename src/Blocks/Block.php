<?php
declare(strict_types=1);
namespace TNC\Blocks;

use TNC\Exception\TncException;

/**
 * Class Block
 * @package TNC\Blocks
 */
class Block
{
    /** @var string  */
    public string $previous;
    /** @var string  */
    public string $timestamp;
    /** @var string  */
    public string $bobserver;
    /** @var string  */
    public string $bobserverSignature;
    /** @var string  */
    public string $blockId;
    /** @var string  */
    public string $signingKey;
    /** @var string  */
    public string $transactionMerkleRoot;
    /** @var array  */
    public array $transactions;

    /**
     * Block constructor.
     * @param array $block
     */
    public function __construct(array $block)
    {
        $this->previous=$block["previous"];
        $this->timestamp=$block["timestamp"];
        $this->bobserver=$block["bobserver"];
        $this->bobserverSignature=$block["bobserver_signature"];
        $this->transactionMerkleRoot=$block["transaction_merkle_root"];
        $this->blockId=$block["block_id"];
        $this->signingKey=$block["signing_key"];
        $this->transactions=[];
        $transactions = $block["transactions"];
        if (is_array($transactions)) {
            foreach ($transactions as $tx) {
                if (isset($tx["txid"]) && is_string($tx["txid"]) && preg_match('/^[a-f0-9]{64}$/i', $tx["txid"])) {
                    $this->transactions[] = $tx["txid"];
                }
            }
        }


    }
}