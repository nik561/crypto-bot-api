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

class Invoice
{
    public const STATUS_ACTIVE = 'active';
    public const STATUS_PAID = 'paid';
    public const STATUS_EXPIRED = 'expired';

    private ?int $invoiceId = null;
    private ?string $status = null;
    private ?string $hash = null;
    private ?string $payUrl = null;
    private ?Carbon $createdAt = null;
    private ?bool $allowComments = null;
    private ?bool $allowAnonymous = null;
    private ?Carbon $expirationDate = null;
    private ?Carbon $paidAt = null;
    private ?bool $paidAnonymously = null;
    private ?string $paidBtnName = null;
    private ?string $paidBtnUrl = null;
    private ?string $hiddenMessage = null;
    private ?string $description = null;
    private ?array $payload = null;
    private ?string $comment = null;
    private float $amount;
    private string $asset;

    public function __construct(
        string $asset,
        float $amount
    ) {
        $this->asset = $asset;
        $this->amount = $amount;
    }

    public function toArray(): array
    {
        $array = [
            'asset' => $this->getAsset(),
            'amount' => (string)$this->getAmount()
        ];
        if ($this->getDescription() !== null) {
            $array['description'] = $this->getDescription();
        }
        if ($this->getPaidBtnName() !== null) {
            $array['paid_btn_name'] = $this->getPaidBtnName();
        }
        if ($this->getHiddenMessage() !== null) {
            $array['hidden_message'] = $this->getHiddenMessage();
        }
        if ($this->getPaidBtnName() !== null) {
            $array['paid_btn_name'] = $this->getPaidBtnName();
        }
        if ($this->getPaidBtnUrl() !== null) {
            $array['paid_btn_url'] = $this->getPaidBtnUrl();
        }
        if ($this->getPayload() !== null) {
            $array['payload'] = json_encode($this->getPayload());
        }
        if ($this->getAllowComments() !== null) {
            $array['allow_comments'] = $this->getAllowComments();
        }
        if ($this->getAllowAnonymous() !== null) {
            $array['allow_anonymous'] = $this->getAllowAnonymous();
        }
        if ($this->getExpirationDate() !== null) {
            $array['expires_in'] = (int)$this->getExpirationDate()->timestamp;
        }

        return $array;
    }

    /**
     * @param string|null $comment
     * @return Invoice
     */
    public function setComment(?string $comment): Invoice
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @param array|null $payload
     * @return Invoice
     */
    public function setPayload(?array $payload): Invoice
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * @param string|null $description
     * @return Invoice
     */
    public function setDescription(?string $description): Invoice
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param float $amount
     * @return Invoice
     */
    public function setAmount(float $amount): Invoice
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @param string $asset
     * @return Invoice
     */
    public function setAsset(string $asset): Invoice
    {
        $this->asset = $asset;

        return $this;
    }

    /**
     * @param string|null $hiddenMessage
     * @return Invoice
     */
    public function setHiddenMessage(?string $hiddenMessage): Invoice
    {
        $this->hiddenMessage = $hiddenMessage;

        return $this;
    }

    /**
     * @param Carbon|null $paidAt
     * @return Invoice
     */
    public function setPaidAt(?Carbon $paidAt): Invoice
    {
        $this->paidAt = $paidAt;

        return $this;
    }

    /**
     * @param Carbon|null $createdAt
     * @return Invoice
     */
    public function setCreatedAt(?Carbon $createdAt): Invoice
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @param string|null $paidBtnName
     * @return Invoice
     */
    public function setPaidBtnName(?string $paidBtnName): Invoice
    {
        $this->paidBtnName = $paidBtnName;

        return $this;
    }

    /**
     * @param bool|null $paidAnonymously
     * @return Invoice
     */
    public function setPaidAnonymously(?bool $paidAnonymously): Invoice
    {
        $this->paidAnonymously = $paidAnonymously;

        return $this;
    }

    /**
     * @param Carbon|null $expirationDate
     * @return Invoice
     */
    public function setExpirationDate(?Carbon $expirationDate): Invoice
    {
        $this->expirationDate = $expirationDate;

        return $this;
    }

    /**
     * @param bool|null $allowComments
     * @return Invoice
     */
    public function setAllowComments(?bool $allowComments): Invoice
    {
        $this->allowComments = $allowComments;

        return $this;
    }

    /**
     * @param bool|null $allowAnonymous
     * @return Invoice
     */
    public function setAllowAnonymous(?bool $allowAnonymous): Invoice
    {
        $this->allowAnonymous = $allowAnonymous;

        return $this;
    }

    /**
     * @param string|null $status
     * @return Invoice
     */
    public function setStatus(?string $status): Invoice
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param string|null $payUrl
     * @return Invoice
     */
    public function setPayUrl(?string $payUrl): Invoice
    {
        $this->payUrl = $payUrl;

        return $this;
    }

    /**
     * @param int|null $invoiceId
     * @return Invoice
     */
    public function setInvoiceId(?int $invoiceId): Invoice
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

    /**
     * @param string|null $hash
     * @return Invoice
     */
    public function setHash(?string $hash): Invoice
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @param string|null $paidBtnUrl
     * @return $this
     */
    public function setPaidBtnUrl(?string $paidBtnUrl): Invoice
    {
        $this->paidBtnUrl = $paidBtnUrl;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @return bool|null
     */
    public function getPaidAnonymously(): ?bool
    {
        return $this->paidAnonymously;
    }

    /**
     * @return string|null
     */
    public function getHiddenMessage(): ?string
    {
        return $this->hiddenMessage;
    }

    /**
     * @return bool|null
     */
    public function getAllowComments(): ?bool
    {
        return $this->allowComments;
    }

    /**
     * @return bool|null
     */
    public function getAllowAnonymous(): ?bool
    {
        return $this->allowAnonymous;
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
    public function getAsset(): string
    {
        return $this->asset;
    }

    /**
     * @return string|null
     */
    public function getPaidBtnName(): ?string
    {
        return $this->paidBtnName;
    }

    /**
     * @return Carbon|null
     */
    public function getPaidAt(): ?Carbon
    {
        return $this->paidAt;
    }

    /**
     * @return Carbon|null
     */
    public function getExpirationDate(): ?Carbon
    {
        return $this->expirationDate;
    }

    /**
     * @return Carbon|null
     */
    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    /**
     * @return string|null
     */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /**
     * @return string|null
     */
    public function getPayUrl(): ?string
    {
        return $this->payUrl;
    }

    /**
     * @return int|null
     */
    public function getInvoiceId(): ?int
    {
        return $this->invoiceId;
    }

    /**
     * @return string|null
     */
    public function getHash(): ?string
    {
        return $this->hash;
    }

    /**
     * @return array|null
     */
    public function getPayload(): ?array
    {
        return $this->payload;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getPaidBtnUrl(): ?string
    {
        return $this->paidBtnUrl;
    }

    public static function fromArray(array $array): Invoice
    {
        $invoice = new Invoice(
            $array['asset'],
            (float)$array['amount']
        );
        if (array_key_exists('invoice_id', $array)) {
            $invoice = $invoice->setInvoiceId((int)$array['invoice_id']);
        }
        if (array_key_exists('status', $array)) {
            $invoice = $invoice->setStatus($array['status']);
        }
        if (array_key_exists('hash', $array)) {
            $invoice = $invoice->setHash($array['hash']);
        }
        if (array_key_exists('pay_url', $array)) {
            $invoice = $invoice->setPayUrl($array['pay_url']);
        }
        if (array_key_exists('created_at', $array)) {
            $invoice = $invoice->setCreatedAt(Carbon::parse($array['created_at']));
        }
        if (array_key_exists('paid_at', $array)) {
            $invoice = $invoice->setCreatedAt(Carbon::parse($array['paid_at']));
        }
        if (array_key_exists('paid_anonymously', $array)) {
            $invoice = $invoice->setPaidAnonymously((bool)$array['paid_anonymously']);
        }
        if (array_key_exists('hidden_message', $array)) {
            $invoice = $invoice->setHiddenMessage($array['hidden_message']);
        }
        if (array_key_exists('comment', $array)) {
            $invoice = $invoice->setComment($array['comment']);
        }
        if (array_key_exists('description', $array)) {
            $invoice = $invoice->setDescription($array['description']);
        }
        if (array_key_exists('paid_btn_name', $array)) {
            $invoice = $invoice->setPaidBtnName($array['paid_btn_name']);
        }
        if (array_key_exists('hidden_message', $array)) {
            $invoice = $invoice->setHiddenMessage($array['hidden_message']);
        }
        if (array_key_exists('paid_btn_url', $array)) {
            $invoice = $invoice->setPaidBtnUrl($array['paid_btn_url']);
        }
        if (array_key_exists('payload', $array)) {
            $invoice = $invoice->setPayload(json_decode($array['payload'], true));
        }
        if (array_key_exists('allow_comments', $array)) {
            $invoice = $invoice->setAllowComments($array['allow_comments']);
        }
        if (array_key_exists('allow_anonymous', $array)) {
            $invoice = $invoice->setAllowAnonymous($array['allow_anonymous']);
        }
        if (array_key_exists('expires_in', $array)) {
            $invoice = $invoice->setExpirationDate(Carbon::parse($array['expires_in']));
        }

        return $invoice;
    }
}
