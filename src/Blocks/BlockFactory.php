<?php
declare(strict_types=1);

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
     * @throws TNC_APIResponseException
     * @throws \MediaParkPK\TNC\Exception\TNC_APIException
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
        $global = $this->tnc->dynamicGlobal();
        return (int)$global["head_block_number"];
    }
}
