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

use Nik561\CryptoBotApi\Exception\InvalidAssetException;

class Balance
{
    public const BTC = 'BTC';
    public const TON = 'TON';
    public const BNB = 'BNB';
    public const BUSD = 'BUSD';
    public const USDC = 'USDC';
    public const USDT = 'USDT';
    public const RUB = 'RUB';

    public const AVAILABLE_ASSETS = [
        self::BNB,
        self::BTC,
        self::BUSD,
        self::TON,
        self::USDT,
        self::USDC
    ];

    private array $assets = [];

    /**
     * @param string $asset
     * @param float $value
     * @return $this
     */
    public function set(string $asset, float $value): Balance
    {
        if (in_array($asset, self::AVAILABLE_ASSETS)) {
            $this->assets[$asset] = $value;
        }

        return $this;
    }

    /**
     * @param string $asset
     * @return float
     * @throws InvalidAssetException
     */
    public function get(string $asset): float
    {
        if (!in_array($asset, self::AVAILABLE_ASSETS)) {
            throw new InvalidAssetException();
        }

        return $this->assets[$asset];
    }
}
