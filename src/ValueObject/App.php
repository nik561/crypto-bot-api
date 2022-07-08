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

class App
{
    private string $paymentProcessingBotUsername;
    private string $name;
    private int $appId;

    public function __construct(
        int $appId,
        string $name,
        string $paymentProcessingBotUsername
    ) {
        $this->appId = $appId;
        $this->name = $name;
        $this->paymentProcessingBotUsername = $paymentProcessingBotUsername;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getAppId(): int
    {
        return $this->appId;
    }

    /**
     * @return string
     */
    public function getPaymentProcessingBotUsername(): string
    {
        return $this->paymentProcessingBotUsername;
    }
}
