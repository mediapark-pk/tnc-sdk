<?php
declare(strict_types=1);

namespace TNC\Accounts;


use TNC\Exception\TncException;
use TNC\TncCoin;

/**
 * Class AccountFactory
 * @package TNC\Accounts
 */
class AccountFactory
{
    /** @var TncCoin  */
    private TncCoin $tnc;

    /**
     * AccountFactory constructor.
     * @param TncCoin $tnc
     */
    public function __construct(TncCoin $tnc)
    {
        $this->tnc=$tnc;
    }

    /**
     * @param array $usernames
     * @return array
     * @throws TncException
     * @throws \Comely\Http\Exception\HttpRequestException
     * @throws \Comely\Http\Exception\HttpResponseException
     * @throws \Comely\Http\Exception\SSL_Exception
     * @throws \TNC\Exception\TncAPIException
     */
    public function getAccounts(array $usernames) :array
    {
        $params=array (
            'usernames' => json_encode($usernames),
        );
        $response =$this->tnc->httpClient()->sendRequest("getAccounts",$params,[],"POST");
        if(($response["status"]=="success") && ($response["result"]))
        {
            $results=[];
            foreach ($response["result"] as $result)
            {
                $results[]=new Account($result);
            }
            return $results;
        }

        throw new TncException("Nothing Found!");
    }
}