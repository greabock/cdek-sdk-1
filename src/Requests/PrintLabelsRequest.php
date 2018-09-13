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

namespace Appwilio\CdekSDK\Requests;

use Appwilio\CdekSDK\Common\Fillable;
use Appwilio\CdekSDK\Requests\Concerns\Authorized;
use Appwilio\CdekSDK\Requests\Concerns\RequestCore;
use Appwilio\CdekSDK\Requests\Template\PrintRequest;
use JMS\Serializer\Annotation as JMS;

/**
 * Class PrintLabelsRequest.
 *
 * @JMS\XmlRoot(name="OrdersPackagesPrint")
 */
final class PrintLabelsRequest extends PrintRequest
{
    use Fillable, Authorized, RequestCore;

    const METHOD = 'POST';
    const ADDRESS = '/ordersPackagesPrint';

    const PRINT_FORMAT_A4 = 'A4';
    const PRINT_FORMAT_A5 = 'A5';
    const PRINT_FORMAT_A6 = 'A6';

    /**
     * @JMS\XmlAttribute
     * @JMS\SerializedName("PrintFormat")
     * @JMS\Type("int")
     *
     * @var string
     */
    private $PrintFormat = self::PRINT_FORMAT_A4;
}