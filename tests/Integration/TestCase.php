<?php
/**
 * This code is licensed under the MIT License.
 *
 * Copyright (c) 2018 Appwilio (http://appwilio.com), greabock (https://github.com/greabock), JhaoDa (https://github.com/jhaoda)
 * Copyright (c) 2018 Alexey Kopytko <alexey@kopytko.com> and contributors
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

namespace Tests\CdekSDK\Integration;

use CdekSDK\CdekClient;
use CdekSDK\Contracts\Response;
use GuzzleHttp\Client as GuzzleClient;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /** @var \CdekSDK\CdekClient */
    private $client;

    /**
     * @psalm-suppress PossiblyFalseArgument
     * @psalm-suppress MixedArgument
     */
    protected function setUp()
    {
        if (false === getenv('CDEK_ACCOUNT')) {
            $this->markTestSkipped('Integration testing disabled (CDEK_ACCOUNT missing).');
        }

        if (false === getenv('CDEK_PASSWORD')) {
            $this->markTestSkipped('Integration testing disabled (CDEK_PASSWORD missing).');
        }

        $http = false === getenv('CDEK_BASE_URL') ? null : new GuzzleClient([
            'base_uri' => getenv('CDEK_BASE_URL'),
            'verify'   => !getenv('CI'), // Igonore SSL errors on the likes of Travis CI
        ]);

        $this->client = new CdekClient(getenv('CDEK_ACCOUNT'), getenv('CDEK_PASSWORD'), $http);

        if (in_array('--debug', $_SERVER['argv'])) {
            $this->client->setLogger(new DebuggingLogger());
        }
    }

    protected function getClient(): CdekClient
    {
        return $this->client;
    }

    protected function skipIfKnownAPIErrorCode(Response $response)
    {
        if ($response->hasErrors()) {
            foreach ($response->getMessages() as $message) {
                if ($message->getErrorCode() === '502') {
                    $this->markTestSkipped("CDEK responded with an HTTP error code: {$message->getMessage()}");
                }
                if ($message->getErrorCode() === 'ERROR_INTERNAL') {
                    $this->markTestSkipped("CDEK failed with an internal error: {$message->getMessage()}");
                }
            }
        }
    }
}
