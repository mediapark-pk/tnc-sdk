<?php

declare(strict_types=1);
namespace TNC\Blocks;


use Comely\Http\Exception\HttpRequestException;
use Comely\Http\Exception\HttpResponseException;
use Comely\Http\Exception\SSL_Exception;
use TNC\Exception\TncException;
use TNC\Exception\TncAPIException;
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
     * @throws TncAPIException
     */
    public function getBlockByNumber(int $blockNumber) :Block
    {
        $param = ["blockNum"=>$blockNumber];
        $data = $this->tnc->httpClient()->sendRequest("getBlock",$param,[],"POST");

        if(($data["status"]=="success")&&($data["result"]))
        {
            return new Block($data["result"]);
        }
        throw new TncException($data["result"]??"Nothing Found");
    }

    /**
     * @return int
     * @throws TncException
     */
    public function getLatestBlockNumber():int
    {
        $response =  $this->tnc->httpClient()->sendRequest("getDynamicGlobal",[],[],"POST");
        if($response["status"]=="success")
        {
            return $response["result"]["head_block_number"];
        }
        throw new TncException("Server not working");
    }
}