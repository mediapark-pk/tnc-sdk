<?php

declare(strict_types=1);
namespace TNC\Blocks;


use TNC\TncCoin;

class BlockFactory
{
    private TncCoin $tnc;
    public function __construct(TncCoin $tnc)
    {
        $this->tnc=$tnc;
    }

    public function getBlockByNumber(int $blockNumber) :Block
    {
        $data =$this->tnc
    }
}