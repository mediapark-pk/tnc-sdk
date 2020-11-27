<?php
declare(strict_types=1);
<<<<<<< HEAD

namespace TNC\Blocks;
=======
>>>>>>> 9e417ea224497d31264febadc721afdac6e151c8

namespace MediaParkPK\TNC\Blocks;

use MediaParkPK\TNC\Exception\TNC_APIResponseException;
use MediaParkPK\TNC\TNC_Client;

/**
 * Class BlockFactory
 * @package MediaParkPK\TNC\Blocks
 */
class BlockFactory
{
    /** @var TNC_Client */
    private TNC_Client $tnc;

    /**
     * BlockFactory constructor.
     * @param TNC_Client $tnc
     */
    public function __construct(TNC_Client $tnc)
    {
        $this->tnc = $tnc;
    }

    /**
     * @param int $blockNumber
     * @return Block
<<<<<<< HEAD
     * @throws HttpRequestException
     * @throws HttpResponseException
     * @throws SSL_Exception
     * @throws TncAPIException
     * @throws TncException
=======
     * @throws TNC_APIResponseException
     * @throws \MediaParkPK\TNC\Exception\TNC_APIException
>>>>>>> 9e417ea224497d31264febadc721afdac6e151c8
     */
    public function getBlockByNumber(int $blockNumber): Block
    {
        $params = [
            "blockNum" => $blockNumber
        ];

        $result = $this->tnc->callAPI("getBlock", $params);
        if (!is_array($result) || !$result) {
            throw TNC_APIResponseException::unexpectedResultType("getBlock", "object", gettype($result));
        }

        return new Block($result);
    }

    /**
     * @return int
     * @throws TNC_APIResponseException
     * @throws \MediaParkPK\TNC\Exception\TNC_APIException
     */
    public function getLatestBlockHeight(): int
    {
<<<<<<< HEAD
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
=======
        $global = $this->tnc->dynamicGlobal();
        return (int)$global["head_block_number"];
>>>>>>> 9e417ea224497d31264febadc721afdac6e151c8
    }
}
