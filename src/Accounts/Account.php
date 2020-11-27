<?php
declare(strict_types=1);

namespace MediaParkPK\TNC\Accounts;

/**
 * Class Account
 * @package MediaParkPK\TNC\Accounts
 */
class Account
{
    /** @var int */
    public int $id;
    /** @var string */
    public string $name;
    /** @var array */
    public array $owner;
    /** @var array */
    public array $active;
    /** @var array */
    public array $posting;
    /** @var string */
    public string $memoKey;
    /** @var string */
    public string $lastOwnerUpdate;
    /** @var string */
    public string $lastAccountUpdate;
    /** @var string */
    public string $created;
    /** @var bool */
    public bool $mined;
    /** @var string */
    public string $recoveryAccount;
    /** @var string */
    public string $lastAccountRecovery;
    /** @var string */
    public string $balance;
    /** @var mixed|string|null */
    public ?string $savingBalance = null;
    /** @var int */
    public int $postCount;
    /** @var string */
    public string $lastPost;
    /** @var string */
    public string $lastRootPost;
    /** @var array */
    public array $transferHistory;
    /** @var array */
    public array $otherHistory;
    /** @var array|mixed|null */
    public ?array $bobServerVotes = null;

    /**
     * Account constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->id = $data["id"];
        $this->name = $data["name"];
        $this->owner = $data["owner"];
        $this->active = $data["active"];
        $this->posting = $data["posting"];
        $this->memoKey = $data["memo_key"];
        $this->lastOwnerUpdate = $data["last_owner_update"];
        $this->lastAccountUpdate = $data["last_account_update"];
        $this->created = $data["created"];
        $this->recoveryAccount = $data["recovery_account"];
        $this->lastAccountRecovery = $data["last_account_recovery"];
        $this->balance = $data["balance"];
        $this->savingBalance = $data["savings_balance"];
        $this->postCount = $data["post_count"];
        $this->lastPost = $data["last_post"];
        $this->lastRootPost = $data["last_root_post"];
        $this->transferHistory = $data["transfer_history"];
        $this->otherHistory = $data["other_history"];
        $this->bobServerVotes = $data["bobserver_votes"];
    }
}
