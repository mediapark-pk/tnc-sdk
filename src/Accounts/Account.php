<?php

declare(strict_types=1);
namespace TNC\Accounts;


/**
 * Class Account
 * @package TNC\Accounts
 */
class Account
{
    /** @var int  */
    public int $id;
    /** @var string  */
    public string $name;
    /** @var array  */
    public array $owner;
    /** @var array  */
    public array $active;
    /** @var array  */
    public array $posting;
    /** @var string  */
    public string $memoKey;
    /** @var string  */
    public string $lastOwnerUpdate;
    /** @var string  */
    public string $lastAccountUpdate;
    /** @var string  */
    public string $created;
    /** @var bool  */
    public bool $mined;
    /** @var string  */
    public string $recoveryAccount;
    /** @var string  */
    public string $lastAccountRecovery;
    /** @var string  */
    public string $balance;
    /** @var string  */
    public string $savingBalance;
    /** @var int  */
    public int $postCount;
    /** @var string  */
    public string $lastPost;
    /** @var string  */
    public string $lastRootPost;
    /** @var array  */
    public array $transferHistory;
    /** @var array  */
    public array $otherHistory;
    /** @var array  */
    public array $bobServerVotes;

    public function __construct(array $data)
    {
        $this->id=$data["id"];
        $this->name=$data["name"];
        $this->owner=$data["owner"];
        $this->active=$data["active"];
        $this->posting=$data["posting"];
        $this->memoKey=$data["memo_key"];
        $this->lastOwnerUpdate=$data["last_owner_update"];
        $this->lastAccountUpdate=$data["last_account_update"];
        $this->created=$data["created"];
        $this->recoveryAccount=$data["recovery_account"];
        $this->lastAccountRecovery=$data["last_account_recovery"];
        $this->balance=$data["balance"];
        $this->savingBalance=$data["saving_balance"];
        $this->postCount=$data["post_count"];
        $this->lastPost=$data["last_post"];
        $this->lastRootPost=$data["last_root_post"];
        $this->transferHistory=$data["transfer_history"];
        $this->otherHistory=$data["other_history"];
        $this->bobServerVotes=$data["bob_server_votes"];
    }


}