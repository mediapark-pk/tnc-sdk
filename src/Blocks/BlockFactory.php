<?php

declare(strict_types=1);
namespace TNC\Blocks;


use Comely\Http\Exception\HttpRequestException;
use Comely\Http\Exception\HttpResponseException;
use Comely\Http\Exception\SSL_Exception;
use TNC\Exception\TnxAPIException;
use TNC\TncCoin;

/**
 * Class BlockFactory
 * @package TNC\Blocks
 */
class BlockFactory
{
    /** @var TncCoin  */
    private TncCoin $tnc;

    /**
     * BlockFactory constructor.
     * @param TncCoin $tnc
     */
    public function __construct(TncCoin $tnc)
    {
        $this->tnc=$tnc;
    }

    /**
     * @param int $blockNumber
     * @return BlockFactory
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     * @throws TnxAPIException
     */
    public function getBlockByNumber(int $blockNumber)
    {
        $param = ["blockNum"=>$blockNumber];
        $data = $this->tnc->httpClient()->sendRequest("getBlock",$param,[],"POST");
        if($data["status"]=="success")
        {
            return new Block($data["result"]);
        }
    }
}