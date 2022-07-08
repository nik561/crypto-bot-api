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

class ExchangeRate
{
    private float $rate;
    private string $target;
    private string $source;
    private bool $isValid;

    public function __construct(
        bool $isValid,
        string $source,
        string $target,
        float $rate
    ) {
        $this->isValid = $isValid;
        $this->source = $source;
        $this->target = $target;
        $this->rate = $rate;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getTarget(): string
    {
        return $this->target;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }
}
