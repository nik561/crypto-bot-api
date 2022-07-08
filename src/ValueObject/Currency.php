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

class Currency
{
    private ?string $url = null;
    private int $decimals;
    private string $code;
    private string $name;
    private bool $isFiat;
    private bool $isStableCoin;
    private bool $isBlockchain;

    public function __construct(
        bool $isBlockchain,
        bool $isStableCoin,
        bool $isFiat,
        string $name,
        string $code,
        int $decimals
    ) {
        $this->isBlockchain = $isBlockchain;
        $this->isStableCoin = $isStableCoin;
        $this->isFiat = $isFiat;
        $this->name = $name;
        $this->code = $code;
        $this->decimals = $decimals;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return int
     */
    public function getDecimals(): int
    {
        return $this->decimals;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return bool
     */
    public function isBlockchain(): bool
    {
        return $this->isBlockchain;
    }

    /**
     * @return bool
     */
    public function isFiat(): bool
    {
        return $this->isFiat;
    }

    /**
     * @return bool
     */
    public function isStableCoin(): bool
    {
        return $this->isStableCoin;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
