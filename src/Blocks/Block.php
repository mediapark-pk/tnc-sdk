<?php
declare(strict_types=1);
namespace TNC\Blocks;

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

    }
}