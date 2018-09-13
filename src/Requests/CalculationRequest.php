<?php
/*
 * This code is licensed under the MIT License.
 *
 * Copyright (c) 2018 appwilio <appwilio.com>
 * Copyright (c) 2018 JhaoDa <jhaoda@gmail.com>
 * Copyright (c) 2018 greabock <greabock17@gmail.com>
 * Copyright (c) 2018 Alexey Kopytko <alexey@kopytko.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

declare(strict_types=1);

namespace CdekSDK\Requests;

use CdekSDK\Contracts\JsonRequest;
use CdekSDK\Requests\Concerns\RequestCore;
use CdekSDK\Responses\CalculationResponse;

/**
 * Class CalculationRequest.
 */
class CalculationRequest implements JsonRequest
{
    use RequestCore;

    const SERVICE_INSURANCE = 2;  // Страховка
    const SERVICE_HAZARDOUS_CARGO = 7;  // Опасный груз
    const SERVICE_PICKUP = 16; // Забор в городе отправителе
    const SERVICE_DELIVERY_TO_DOOR = 17; // Доставка в городе получателе
    const SERVICE_PACKAGE_1 = 24; // Упаковка 1
    const SERVICE_PACKAGE_2 = 25; // Упаковка 2
    const SERVICE_FITTING_AT_HOME = 30; // Примерка на дому
    const SERVICE_PERSONAL_DELIVERY = 31; // Доставка лично в руки
    const SERVICE_DOCUMENTS_COPY = 32; // Скан документов
    const SERVICE_PARTIAL_DELIVERY = 36; // Частичная доставка
    const SERVICE_CARGO_CHECK = 37; // Осмотр вложения

    const MODE_DOOR_DOOR = 1;
    const MODE_DOOR_WAREHOUSE = 2;
    const MODE_WAREHOUSE_DOOR = 3;
    const MODE_WAREHOUSE_WAREHOUSE = 4;

    const METHOD = 'POST';
    const ADDRESS = 'https://api.cdek.ru/calculator/calculate_price_by_json.php';
    const RESPONSE = CalculationResponse::class;

    protected $senderCityId;
    protected $senderCityPostCode;

    protected $goods;
    protected $modeId;
    protected $services;
    protected $tariffId;
    protected $tariffList = [];
    protected $receiverCityId;
    protected $receiverCityPostCode;

    public static function withAuthorization(): CalculationRequest
    {
        return new CalculationAuthorizedRequest();
    }

    public function setSenderCityId($id)
    {
        $this->senderCityId = $id;

        return $this;
    }

    public function setReceiverCityId($id)
    {
        $this->receiverCityId = $id;

        return $this;
    }

    public function setSenderCityPostCode($code)
    {
        $this->senderCityPostCode = $code;

        return $this;
    }

    public function setReceiverCityPostCode($code)
    {
        $this->receiverCityPostCode = $code;

        return $this;
    }

    public function setTariffId($id)
    {
        $this->tariffList = [];

        $this->tariffId = $id;

        return $this;
    }

    /**
     * @phan-suppress PhanUnusedPublicMethodParameter
     *
     * @param mixed $id
     * @param mixed $priority
     *
     * @return \CdekSDK\Requests\CalculationRequest
     */
    public function addTariffToList($id, $priority)
    {
        $this->tariffId = null;

        $this->tariffList[] = compact('id', 'priority');

        return $this;
    }

    public function setModeId($id)
    {
        $this->modeId = $id;

        return $this;
    }

    public function addGood($good)
    {
        $this->goods[] = $good;

        return $this;
    }

    public function addAdditionalService($serviceId, $param = null)
    {
        $this->services[] = [
            'id' => $serviceId,
            'param' => $param,
        ];

        return $this;
    }

    public function getBody(): array
    {
        return array_filter([
            'version' => '1.0',
            'goods' => $this->goods,
            'modeId' => $this->modeId,
            'tariffId' => $this->tariffId,
            'tariffList' => $this->tariffList,
            'senderCityId' => $this->senderCityId,
            'senderCityPostCode' => $this->senderCityPostCode,
            'services' => $this->services,
            'receiverCityId' => $this->receiverCityId,
            'receiverCityPostCode' => $this->receiverCityPostCode,
        ]);
    }
}
