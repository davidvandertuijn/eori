<?php

namespace Davidvandertuijn\Eori\Ec;

use Davidvandertuijn\Eori\Ec\Exceptions\Timeout as EcTimeoutException;
use SoapClient;
use SoapFault;

class Client extends SoapClient
{
    /**
     * Do Request.
     * @param string $request The XML SOAP request.
     * @param string $location The URL to request.
     * @param string $action The SOAP action.
     * @param int $version The SOAP version.
     * @param int  $one_way If one_way is set to 1, this method returns nothing. Use this where a response is not expected.
     */
    public function __doRequest($request, $location, $action, $version, $one_way = null)
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
                throw new EoriTimeoutException($error);
            } else {
                throw new SoapFault('Client', $error);
            }
        }

        curl_close($ch);

        if (!$one_way) {
            return $response;
        }
    }
}
