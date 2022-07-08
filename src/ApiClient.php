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

namespace Nik561\CryptoBotApi;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Nik561\CryptoBotApi\Collection\CurrencyCollection;
use Nik561\CryptoBotApi\Collection\ExchangeRateCollection;
use Nik561\CryptoBotApi\Collection\InvoiceCollection;
use Nik561\CryptoBotApi\Exception\ApiException;
use Nik561\CryptoBotApi\Exception\InvalidTokenException;
use Nik561\CryptoBotApi\ValueObject\App;
use Nik561\CryptoBotApi\ValueObject\Balance;
use Nik561\CryptoBotApi\ValueObject\Currency;
use Nik561\CryptoBotApi\ValueObject\ExchangeRate;
use Nik561\CryptoBotApi\ValueObject\Invoice;
use Nik561\CryptoBotApi\ValueObject\Transfer;
use Psr\Http\Message\ResponseInterface;

class ApiClient
{
    public const BASE_URL = 'https://pay.crypt.bot';
    public const TEST_URL = 'https://testnet-pay.crypt.bot';
    private string $apiToken;
    private bool $isTest;
    private Client $client;

    public function __construct(string $apiToken, bool $isTest = false)
    {
        $this->isTest = $isTest;
        $this->apiToken = $apiToken;
        $this->client = new Client();
    }

    private function getUrl(): string
    {
        return $this->isTest ? self::TEST_URL : self::BASE_URL;
    }

    /**
     * @return string
     */
    public function getApiToken(): string
    {
        return $this->apiToken;
    }

    /**
     * @param string $method
     * @param array $params
     * @return ResponseInterface
     * @throws ApiException
     * @throws InvalidTokenException
     */
    private function get(string $method, array $params = []): ResponseInterface
    {
        try {
            return $this->client->get(
                sprintf('%s/api/%s', $this->getUrl(), $method),
                [
                    'query_params' => $params,
                    'headers' => [
                        'Crypto-Pay-API-Token' => $this->getApiToken()
                    ]
                ]
            );
        } catch (GuzzleException $exception) {
            switch ($exception->getCode()) {
                case 401:
                    throw new InvalidTokenException();
                default:
                    throw new ApiException($exception->getMessage());
            }
        }
    }

    /**
     * @throws ApiException
     * @throws InvalidTokenException
     */
    private function post(string $method, array $params = []): ResponseInterface
    {
        try {
            return $this->client->post(
                sprintf('%s/api/%s', $this->getUrl(), $method),
                [
                    'form_params' => $params,
                    'headers' => [
                        'Crypto-Pay-API-Token' => $this->getApiToken()
                    ]
                ]
            );
        } catch (GuzzleException $exception) {
            switch ($exception->getCode()) {
                case 401:
                    throw new InvalidTokenException();
                default:
                    throw new ApiException($exception->getMessage());
            }
        }
    }

    /**
     * @return App
     * @throws ApiException
     * @throws InvalidTokenException
     */
    public function getMe(): App
    {
        $body = json_decode($this->get('getMe')->getBody()->getContents(), true)['result'];

        return new App($body['app_id'], $body['name'], $body['payment_processing_bot_username']);
    }

    /**
     * @param Invoice $invoice
     * @return Invoice
     * @throws ApiException
     * @throws InvalidTokenException
     */
    public function createInvoice(Invoice $invoice): Invoice
    {
        $response = $this->post('createInvoice', $invoice->toArray());
        $body = json_decode($response->getBody()->getContents(), true);
        $result = $body['result'];

        $this->extracted($invoice, $result);

        return $invoice;
    }

    /**
     * @return Balance
     * @throws ApiException
     * @throws InvalidTokenException
     */
    public function getBalance(): Balance
    {
        $body = json_decode($this->get('getBalance')->getBody()->getContents(), true);
        $asset = new Balance();
        $assets = $body['result'];
        foreach ($assets as $item) {
            $asset->set($item['currency_code'], (float)$item['available']);
        }

        return $asset;
    }

    /**
     * @return InvoiceCollection
     * @throws ApiException
     * @throws InvalidTokenException
     */
    public function getInvoices(): InvoiceCollection
    {
        $body = json_decode($this->get('getInvoices')->getBody()->getContents(), true);
        $invoices = $body['result']['items'];
        $invoiceCollection = new InvoiceCollection(Invoice::class);
        foreach ($invoices as $item) {
            $invoice = new Invoice(
                $item['asset'],
                (float)$item['amount']
            );
            $this->extracted($invoice, $item);
            $invoiceCollection->add($invoice);
        }

        return $invoiceCollection;
    }

    /**
     * @param Invoice $invoice
     * @param array $item
     * @return void
     */
    public function extracted(Invoice $invoice, array $item): void
    {
        $invoice->setInvoiceId($item['invoice_id'] ?? null);
        $invoice->setStatus($item['status'] ?? null);
        $invoice->setHash($item['hash'] ?? null);
        $invoice->setAsset($item['asset'] ?? null);
        $invoice->setAmount((float)$item['amount'] ?? null);
        $invoice->setPayUrl($item['pay_url'] ?? null);
        $invoice->setDescription($item['description'] ?? null);
        $invoice->setCreatedAt(isset($item['created_at']) ? Carbon::parse($item['created_at']) : null);
        $invoice->setAllowComments($item['allow_comments'] ?? null);
        $invoice->setAllowAnonymous($item['allow_anonymous'] ?? null);
        $invoice->setExpirationDate(isset($item['expiration_date']) ? Carbon::parse($item['expiration_date']) : null);
        $invoice->setPaidAt(isset($item['paid_at']) ? Carbon::parse($item['paid_at']) : null);
        $invoice->setPaidAnonymously($item['paid_anonymously'] ?? null);
        $invoice->setComment($item['comment'] ?? null);
        $invoice->setHiddenMessage($item['hidden_message'] ?? null);
        $invoice->setPayload(json_decode($item['payload'] ?? '[]', true));
        $invoice->setPaidBtnName($item['paid_btn_name'] ?? null);
        $invoice->setPaidBtnUrl($item['paid_btn_url'] ?? null);
    }

    /**
     * @param Transfer $transfer
     * @return Transfer
     * @throws ApiException
     * @throws InvalidTokenException
     */
    public function transfer(Transfer $transfer): Transfer
    {
        $body = json_decode($this->post('transfer', $transfer->toArray())->getBody()->getContents(), true);
        $result = $body['result'];
        $transfer->setTransferId($result['transfer_id']);
        $transfer->setCompletedAt($result['completed_at']);

        return $transfer;
    }

    /**
     * @param array $body
     * @param string $signature
     * @return bool
     */
    public function validateWebhook(array $body, string $signature): bool
    {
        $checkString = json_encode($body, JSON_UNESCAPED_SLASHES);
        $secretHash = hash('sha256', $this->getApiToken(), true);
        $checkHash = hash_hmac('sha256', $checkString, $secretHash, false);

        return $checkHash === $signature;
    }

    /**
     * @return CurrencyCollection
     * @throws ApiException
     * @throws InvalidTokenException
     */
    public function getCurrencies(): CurrencyCollection
    {
        $body = json_decode($this->get('getCurrencies')->getBody()->getContents(), true);
        $result = $body['result'];
        $collection = new CurrencyCollection(Currency::class);
        foreach ($result as $item) {
            $currency = new Currency(
                $item['is_blockchain'],
                $item['is_stablecoin'],
                $item['is_fiat'],
                $item['name'],
                $item['code'],
                $item['decimals']
            );
            if (isset($item['url'])) {
                $currency->setUrl($item['url']);
            }
            $collection->add($currency);
        }

        return $collection;
    }

    /**
     * @return ExchangeRateCollection
     * @throws ApiException
     * @throws InvalidTokenException
     */
    public function getExchangeRates(): ExchangeRateCollection
    {
        $body = json_decode($this->get('getExchangeRates')->getBody()->getContents(), true);
        $result = $body['result'];
        $collection = new ExchangeRateCollection(ExchangeRate::class);
        foreach ($result as $item) {
            $exchangeRate = new ExchangeRate(
                $item['is_valid'],
                $item['source'],
                $item['target'],
                (float)$item['rate']
            );
            $collection->add($exchangeRate);
        }

        return $collection;
    }
}
