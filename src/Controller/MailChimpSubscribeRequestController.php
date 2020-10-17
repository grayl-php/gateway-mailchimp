<?php

namespace Grayl\Gateway\MailChimp\Controller;

use Grayl\Gateway\Common\Controller\RequestControllerAbstract;
use Grayl\Gateway\MailChimp\Entity\MailChimpSubscribeRequestData;
use Grayl\Gateway\MailChimp\Entity\MailChimpSubscribeResponseData;

/**
 * Class MailChimpSubscribeRequestController
 * The controller for working with MailChimpSubscribeRequestData entities
 * @method MailChimpSubscribeRequestData getRequestData()
 * @method MailChimpSubscribeResponseController sendRequest()
 *
 * @package Grayl\Gateway\MailChimp
 */
class MailChimpSubscribeRequestController extends
    RequestControllerAbstract
{

    /**
     * Creates a new MailChimpSubscribeResponseController to handle data and functions returned from the gateway
     *
     * @param MailChimpSubscribeResponseData $response_data The MailChimpSubscribeResponseData entity received from the gateway
     *
     * @return MailChimpSubscribeResponseController
     */
    public function newResponseController($response_data): object
    {

        // Return a new MailChimpSubscribeResponseController entity
        return new MailChimpSubscribeResponseController(
            $response_data,
            $this->response_service
        );
    }

}