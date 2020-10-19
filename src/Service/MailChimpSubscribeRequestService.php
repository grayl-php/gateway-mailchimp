<?php

   namespace Grayl\Gateway\MailChimp\Service;

   use Grayl\Gateway\Common\Service\RequestServiceInterface;
   use Grayl\Gateway\MailChimp\Entity\MailChimpGatewayData;
   use Grayl\Gateway\MailChimp\Entity\MailChimpSubscribeRequestData;
   use Grayl\Gateway\MailChimp\Entity\MailChimpSubscribeResponseData;

   /**
    * Class MailChimpSubscribeRequestService
    * The service for working with MailChimp API subscribe requests
    *
    * @package Grayl\Gateway\MailChimp
    */
   class MailChimpSubscribeRequestService implements RequestServiceInterface
   {

      /**
       * Sends a MailChimpSubscribeRequestData object to the MailChimp gateway and returns a reponse
       *
       * @param MailChimpGatewayData          $gateway_data A configured MailChimpGatewayData entity to send the request through
       * @param MailChimpSubscribeRequestData $request_data The MailChimpSubscribeRequestData entity to send
       *
       * @return MailChimpSubscribeResponseData
       * @noinspection PhpUnusedLocalVariableInspection
       */
      public function sendRequestDataEntity ( $gateway_data,
                                              $request_data ): object
      {

         // Get the API method URL with tags replaced properly
         $method = $this->replaceTags( "lists/{LIST_ID}/members/{SUBSCRIBER_HASH}",
                                       [ 'list_id'         => $request_data->getListID(),
                                         'subscriber_hash' => $this->makeSubscriberHash( $request_data->getEmailAddress() ), ] );

         // Get the parameters
         $parameters = $this->translateMailChimpSubscribeRequestData( $request_data );

         // Build the request
         $api_request = $gateway_data->getAPI();

         // Send the request
         $response = $api_request->put( $method,
                                        $parameters );

         // Return a new response entity with the action specified
         // Note this gateway class returns a scrubbed response with no easily identifiable field for success
         // Instead of storing the scrubbed response, we request the full set of data from the class itself
         return $this->newResponseDataEntity( $gateway_data->getAPI()
                                                           ->getLastResponse(),
                                              $gateway_data->getGatewayName(),
                                              'subscribe',
                                              [] );
      }


      /**
       * Creates a new MailChimpSubscribeResponseData object to handle data returned from the gateway
       *
       * @param array    $api_response The response array received directly from a gateway
       * @param string   $gateway_name The name of the gateway
       * @param string   $action       The action performed in this response (send, sendTemplate, etc.)
       * @param string[] $metadata     Extra data associated with this response
       *
       * @return MailChimpSubscribeResponseData
       */
      public function newResponseDataEntity ( $api_response,
                                              string $gateway_name,
                                              string $action,
                                              array $metadata ): object
      {

         // Return a new MailChimpSubscribeResponseData entity
         return new MailChimpSubscribeResponseData( $api_response,
                                                    $gateway_name,
                                                    $action );
      }


      /**
       * Translates a MailChimpSubscribeRequestData into the proper field format required by the API
       *
       * @param MailChimpSubscribeRequestData $request_data A MailChimpSubscribeRequestData entity to translate from
       *
       * @return array
       */
      private function translateMailChimpSubscribeRequestData ( MailChimpSubscribeRequestData $request_data ): array
      {

         // Create the return array
         $parameters = [];

         // Standard fields
         $parameters[ 'email_address' ] = $request_data->getEmailAddress();
         $parameters[ 'status' ]        = $request_data->getStatus();
         $parameters[ 'status_if_new' ] = $request_data->getStatus();

         // Merge tags
         $parameters[ 'merge_fields' ] = $request_data->getMergeTags();

         // Return the array of parameters
         return $parameters;
      }


      /**
       * Convert an email address into a 'subscriber hash' for identifying the subscriber in a method URL
       *
       * @param string $email_address The subscriber's email address
       *
       * @return  string
       */
      private function makeSubscriberHash ( string $email_address ): string
      {

         // Return the hashed subscriber
         return md5( strtolower( $email_address ) );
      }


      /**
       * Replaces tags in a string with data
       *
       * @param string   $string The string that contains the tags
       * @param string[] $tags   An array of tags to replace in the string ( tag = replacement format)
       *
       * @return string
       */
      private function replaceTags ( string $string,
                                     array $tags ): string
      {

         // Loop through each tag and replace it in the string
         foreach ( $tags as $tag => $value ) {
            // Replace it
            $string = str_replace( '{' . strtoupper( $tag ) . '}',
                                   $value,
                                   $string );
         }

         // Return the modified string
         return $string;
      }

   }