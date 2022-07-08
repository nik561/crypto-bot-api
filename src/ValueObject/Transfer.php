<?php
// Copyright 202 Nik561, kitos7@yandex.com
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//     http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
declare(strict_types=1);

namespace Nik561\CryptoBotApi\ValueObject;

use Carbon\Carbon;

class Transfer
{
    private int $transferId;
    private Carbon $completedAt;
    private bool $disableSendNotification;
    private string $comment;
    private string $spendId;
    private float $amount;
    private string $asset;
    private int $userId;

    public function __construct(
        int $userId,
        string $asset,
        float $amount,
        string $spendId,
        string $comment,
        bool $disableSendNotification = false
    ) {
        $this->userId = $userId;
        $this->asset = $asset;
        $this->amount = $amount;
        $this->spendId = $spendId;
        $this->comment = $comment;
        $this->disableSendNotification = $disableSendNotification;
    }

    /**
     * @return string
     */
    public function getAsset(): string
    {
        return $this->asset;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return string
     */
    public function getSpendId(): string
    {
        return $this->spendId;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param string $asset
     */
    public function setAsset(string $asset): void
    {
        $this->asset = $asset;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @param bool $disableSendNotification
     */
    public function setDisableSendNotification(bool $disableSendNotification): void
    {
        $this->disableSendNotification = $disableSendNotification;
    }

    /**
     * @param string $spendId
     */
    public function setSpendId(string $spendId): void
    {
        $this->spendId = $spendId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * @return bool
     */
    public function isDisableSendNotification(): bool
    {
        return $this->disableSendNotification;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->getUserId(),
            'asset' => $this->getAsset(),
            'amount' => (string)$this->getAmount(),
            'spend_id' => $this->getSpendId(),
            'comment' => $this->getComment(),
            'disable_send_notification' => $this->isDisableSendNotification()
        ];
    }

    /**
     * @param Carbon $completedAt
     */
    public function setCompletedAt(Carbon $completedAt): void
    {
        $this->completedAt = $completedAt;
    }

    /**
     * @return Carbon
     */
    public function getCompletedAt(): Carbon
    {
        return $this->completedAt;
    }

    /**
     * @return int
     */
    public function getTransferId(): int
    {
        return $this->transferId;
    }

    /**
     * @param int $transferId
     */
    public function setTransferId(int $transferId): void
    {
        $this->transferId = $transferId;
    }
}
