<?php

namespace Davidvandertuijn\Eori\Ec;

use Davidvandertuijn\Eori\Ec\Exceptions\Timeout as EcTimeoutException;
use SoapClient;
use SoapFault;

class Client extends SoapClient
{
    /**
     * Do Request.
     */
    public function __doRequest(string $request, string $location, string $action, int $version, bool $oneWay = false): ?string
    {
        $ch = curl_init($location);

        curl_setopt($ch, CURLOPT_VERBOSE, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: text/xml']);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);

        $response = curl_exec($ch);

        $errno = curl_errno($ch);
        $error = curl_error($ch);

        if ($errno) {
            if (in_array($errno, [
                CURLE_OPERATION_TIMEDOUT,
                CURLE_OPERATION_TIMEOUTED,
            ])) {
                throw new EcTimeoutException($error);
            } else {
                throw new SoapFault('Client', $error);
            }
        }

        curl_close($ch);

        if ($oneWay) {
            return null;
        }

        return $response;
    }
}
