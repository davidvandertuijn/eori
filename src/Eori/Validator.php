<?php

namespace Davidvandertuijn\Eori;

use Exception;
use Davidvandertuijn\Eori\Ec\Client as EcClient;
use Davidvandertuijn\Eori\Ec\Exceptions\Timeout as EcTimeoutException;
use SoapFault;

class Validator
{
    /**
     * @const WSDL_URL
     */
    public const WSDL_URL = 'https://ec.europa.eu/taxation_customs/dds2/eos/validation/services/validation?wsdl';

    /**
     * @var EcClient
     */
    protected $ecClient = null;

    /**
     * @var bool
     */
    protected $valid = false;

    /**
     * @var bool
     */
    protected $strict = true;

    /**
     * Construct.
     */
    public function __construct()
    {
        ini_set('default_socket_timeout', 3);
        ini_set('max_execution_time', 30);

        $ecClient = new EcClient(self::WSDL_URL, [
            'connection_timeout' => 3,
            'exceptions' => true,
        ]);

        $this->setEcClient($ecClient);
    }

    /**
     * Get Ec Client.
     */
    private function getEcClient(): EcClient
    {
        return $this->ecClient;
    }

    /**
     * Set Ec Client.
     */
    private function setEcClient(EcClient $ecClient): void
    {
        $this->ecClient = $ecClient;
    }

    /**
     * Get Valid.
     */
    private function getValid(): bool
    {
        return $this->valid;
    }

    /**
     * Set Valid.
     */
    private function setValid(bool $valid): void
    {
        $this->valid = $valid;
    }

    /**
     * Get Strict.
     */
    public function getStrict(): bool
    {
        return $this->strict;
    }

    /**
     * Set Strict.
     */
    public function setStrict(bool $strict): void
    {
        $this->strict = $strict;
    }

    /**
     * Is Valid.
     */
    public function isValid(): bool
    {
        return $this->getValid();
    }

    /**
     * Validate.
     */
    public function validate(string $eoriNumber): bool
    {
        try {
            $ecClient = $this->getEcClient();

            $response = $ecClient->validateEORI([
                'eori' => $eoriNumber
            ]);

            if ($response->return->result->statusDescr != "Valid") {
                $this->setValid(false);
                return false;
            }

            $this->setValid(true);
            return true;
        } catch (EcTimeoutException $e) {
            if (!$this->getStrict()) {
                $this->setValid(true);
                return true;
            }

            $this->setValid(false);
            return false;
        } catch (SoapFault $e) {
            if ($this->getStrict() == false) {
                $this->setValid(true);
                return true;
            }

            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
}
