<?php

declare(strict_types=1);
namespace TNC\Blocks;


use Comely\Http\Exception\HttpRequestException;
use Comely\Http\Exception\HttpResponseException;
use Comely\Http\Exception\SSL_Exception;
use TNC\Exception\TnxAPIException;
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
        $param = ["blockNum"=>$blockNumber];
        try {
            $data = $this->tnc->httpClient()->sendRequest("/api/getBlock",$param,[],"POST");
            print_r($data);
        } catch (HttpResponseException $e) {
        } catch (SSL_Exception $e) {
        } catch (HttpRequestException $e) {
        } catch (TnxAPIException $e) {
        }
    }
}