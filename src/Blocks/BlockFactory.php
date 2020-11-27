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
     * @return Block
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     * @throws TncAPIException
     * @throws TncException
     */
    public function getBlockByNumber(int $blockNumber) :Block
    {
        if(!$blockNumber)
        {
            throw new TncException("Blocknumber must not be empty");
        }
        $param = ["blockNum"=>$blockNumber];
        $data = $this->tnc->httpClient()->sendRequest("getBlock",$param,[],"POST");

        if(($data["status"]=="success")&&($data["result"]))
        {
            return new Block($data["result"]);
        }
        else if($data["status"]=="fail")
        {
            throw new TncException($data["result"]["message"]);
        }
        throw new TncException($data["result"]??"Nothing Found");
    }

    /**
     * @return int
     * @throws TncException
     */
    public function getLatestBlockNumber():int
    {
        try {
            $response = $this->tnc->httpClient()->sendRequest("getDynamicGlobal", [], [], "POST");
        } catch (HttpResponseException $e) {
        } catch (SSL_Exception $e) {
        } catch (HttpRequestException $e) {
        } catch (TncAPIException $e) {
        }
        if($response["status"]=="success"&&$response["result"])
        {
            return $response["result"]["head_block_number"];
        }
        else if($response["status"]=="fail")
        {
            throw new TncException($response["result"]["message"]);
        }
        throw new TncException("Server not working");
    }
}