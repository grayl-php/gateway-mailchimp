<?php

namespace Grayl\Gateway\MailChimp;

use DrewM\MailChimp\MailChimp;
use Grayl\Gateway\Common\GatewayPorterAbstract;
use Grayl\Gateway\MailChimp\Controller\MailChimpSubscribeRequestController;
use Grayl\Gateway\MailChimp\Entity\MailChimpGatewayData;
use Grayl\Gateway\MailChimp\Entity\MailChimpSubscribeRequestData;
use Grayl\Gateway\MailChimp\Service\MailChimpGatewayService;
use Grayl\Gateway\MailChimp\Service\MailChimpSubscribeRequestService;
use Grayl\Gateway\MailChimp\Service\MailChimpSubscribeResponseService;
use Grayl\Mixin\Common\Traits\StaticTrait;

/**
 * Front-end for the MailChimp package
 * @method MailChimpGatewayData getSavedGatewayDataEntity (string $endpoint_id)
 *
 * @package Grayl\Gateway\MailChimp
 */
class MailChimpPorter extends
    GatewayPorterAbstract
{

    // Use the static instance trait
    use StaticTrait;

    /**
     * The name of the config file for the MailChimp package
     *
     * @var string
     */
    protected string $config_file = 'gateway.mailchimp.php';


    /**
     * Creates a new MailChimp object for use in a MailChimpGatewayData entity
     *
     * @param array $credentials An array containing all of the credentials needed to create the gateway API
     *
     * @return MailChimp
     * @throws \Exception
     */
    public function newGatewayAPI(array $credentials): object
    {

        // Return the new API entity
        return new MailChimp($credentials['token']);
    }


    /**
     * Creates a new MailChimpGatewayData entity
     *
     * @param string $endpoint_id The API endpoint ID to use (typically "default" is there is only one API gateway)
     *
     * @return MailChimpGatewayData
     * @throws \Exception
     */
    public function newGatewayDataEntity(string $endpoint_id): object
    {

        // Grab the gateway service
        $service = new MailChimpGatewayService();

        // Get an API
        $api = $this->newGatewayAPI(
            $service->getAPICredentials(
                $this->config,
                $this->environment,
                $endpoint_id
            )
        );

        // Configure the API as needed using the service
        $service->configureAPI(
            $api,
            $this->environment
        );

        // Return the gateway
        return new MailChimpGatewayData(
            $api,
            $this->config->getConfig('name'),
            $this->environment
        );
    }


    /**
     * Creates a new MailChimpSubscribeRequestController entity
     *
     * @param string $list_alias    The MailChimp list alias from the Config to add this subscriber to
     * @param string $email_address The email address of the subscriber
     * @param string $status        The default status of the subscriber
     * @param array  $merge_tags    The associative array of merge tags to set ( key => value )
     *
     * @return MailChimpSubscribeRequestController
     * @throws \Exception
     */
    public function newMailChimpSubscribeRequestController(
        string $list_alias,
        string $email_address,
        string $status,
        array $merge_tags
    ): MailChimpSubscribeRequestController {

        // Convert the list name into a list ID
        $list_id = $this->getMailChimpListIDFromListAlias($list_alias);

        // Create the MailChimpSubscribeRequestData entity
        $request_data = new MailChimpSubscribeRequestData(
            'subscribe',
            $list_id,
            $email_address,
            $status,
            $merge_tags
        );

        // Return a new MailChimpSubscribeRequestController entity
        return new MailChimpSubscribeRequestController(
            $this->getSavedGatewayDataEntity('default'),
            $request_data,
            new MailChimpSubscribeRequestService(),
            new MailChimpSubscribeResponseService()
        );
    }


    /**
     * Gets the actual MailChimp list ID using a list alias from the Config
     *
     * @param string $list_alias The MailChimp list alias from the Config
     *
     * @return ?string
     */
    private function getMailChimpListIDFromListAlias(string $list_alias
    ): ?string {

        // Get the full array of lists
        $lists = $this->config->getConfig('lists');

        // Return the value if we have one
        if ( ! empty ($lists[$list_alias])) {
            // Match
            return $lists[$list_alias];
        }

        // No match
        return null;
    }

}