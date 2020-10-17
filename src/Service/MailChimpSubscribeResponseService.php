<?php

namespace Grayl\Gateway\MailChimp\Service;

use Grayl\Gateway\Common\Service\ResponseServiceInterface;
use Grayl\Gateway\MailChimp\Entity\MailChimpSubscribeResponseData;

/**
 * Class MailChimpSubscribeResponseService
 * The service for working with MailChimp API gateway subscribe responses
 *
 * @package Grayl\Gateway\MailChimp
 */
class MailChimpSubscribeResponseService implements
    ResponseServiceInterface
{

    /**
     * Returns a true / false value based on a gateway API response
     *
     * @param MailChimpSubscribeResponseData $response_data The response object to check
     *
     * @return bool
     */
    public function isSuccessful($response_data): bool
    {

        // For a successful response
        if ($this->isHTTPCodeSuccessful($response_data)) {
            // Success
            return true;
        }

        // Failure
        return false;
    }


    /**
     * Returns the reference ID from a gateway API response
     *
     * @param MailChimpSubscribeResponseData $response_data The response object to pull the reference ID from
     *
     * @return string
     */
    public function getReferenceID($response_data): ?string
    {

        // Get the reference ID field from the body
        return $this->getResponseBodyField(
            $response_data,
            'id'
        );
    }


    /**
     * Returns the status message from a gateway API response
     *
     * @param MailChimpSubscribeResponseData $response_data The response object to get the message from
     *
     * @return string
     */
    public function getMessage($response_data): ?string
    {

        // Get the response message field from the body
        return $this->getResponseBodyField(
            $response_data,
            'detail'
        );
    }


    /**
     * Returns the raw data from a gateway API response
     *
     * @param MailChimpSubscribeResponseData $response_data The response object to get the data from
     *
     * @return array
     */
    public function getData($response_data): array
    {

        // Return the raw array response
        return $response_data->getAPIResponse();
    }


    /**
     * Check if the HTTP response code was successful or a failure
     *
     * @param MailChimpSubscribeResponseData $response_data The response object to check
     *
     * @return bool
     */
    private function isHTTPCodeSuccessful(
        MailChimpSubscribeResponseData $response_data
    ): bool {

        // Get the HTTP status code from the response headers
        $code = $this->getResponseHeaderField(
            $response_data,
            'http_code'
        );

        // A successful code will be in the 200s
        if ($code >= 200 && $code <= 299) {
            // Success
            return true;
        }

        // Failed
        return false;
    }


    /**
     * Finds a field specified in a response's headers
     *
     * @param MailChimpSubscribeResponseData $response_data MailChimpSubscribeResponseData $response The response object to check
     * @param string                         $field         The name of the field to return
     *
     * @return mixed
     */
    private function getResponseHeaderField(
        MailChimpSubscribeResponseData $response_data,
        string $field
    ): ?string {

        // Grab the raw API response
        $data = $response_data->getAPIResponse();

        // Check for the field
        if ( ! empty($data['headers']) && isset($data['headers'][$field])) {
            // Match
            return $data['headers'][$field];
        }

        // Nothing found
        return null;
    }


    /**
     * Finds a field specified in a response's body
     *
     * @param MailChimpSubscribeResponseData $response_data MailChimpSubscribeResponseData $response The response object to check
     * @param string                         $field         The name of the field to return
     *
     * @return mixed
     */
    private function getResponseBodyField(
        MailChimpSubscribeResponseData $response_data,
        string $field
    ): ?string {

        // Grab the raw API response
        $data = $response_data->getAPIResponse();

        // If the body is empty, return
        if (empty($data) && isset($data['body'])) {
            // No match
            return null;
        }

        // The 'body' field in the raw response is JSON encoded by default
        // Decode it in an associative array
        $data_decoded = json_decode(
            $data['body'],
            true
        );

        // Check for the field
        if ( ! empty($data_decoded) && isset($data_decoded[$field])) {
            // Match
            return $data_decoded[$field];
        }

        // Nothing found
        return null;
    }

}