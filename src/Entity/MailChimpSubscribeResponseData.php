<?php

namespace Grayl\Gateway\MailChimp\Entity;

use Grayl\Gateway\Common\Entity\ResponseDataAbstract;

/**
 * Class MailChimpSubscribeResponseData
 * The class for working with a subscribe response from the MailChimp gateway
 * @method void __construct(array $api_response, string $gateway_name, string $action)
 * @method void setAPIResponse(array $api_response)
 * @method array getAPIResponse()
 *
 * @package Grayl\Gateway\MailChimp
 */
class MailChimpSubscribeResponseData extends
    ResponseDataAbstract
{

    /**
     * The raw API response entity from the gateway
     *
     * @var array
     */
    protected $api_response;

}