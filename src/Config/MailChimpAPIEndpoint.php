<?php

   namespace Grayl\Gateway\MailChimp\Config;

   use Grayl\Gateway\Common\Config\GatewayAPIEndpointAbstract;

   /**
    * Class MailChimpAPIEndpoint
    * The class of a single MailChimp API endpoint
    *
    * @package Grayl\Gateway\MailChimp
    */
   class MailChimpAPIEndpoint extends GatewayAPIEndpointAbstract
   {

      /**
       * The MailChimp token for communicating with the API
       *
       * @var string
       */
      protected string $token;


      /**
       * Class constructor
       *
       * @param string $api_endpoint_id The ID of this API endpoint (default, provision, etc.)
       * @param string $token           The MailChimp token for communicating with the API
       */
      public function __construct ( string $api_endpoint_id,
                                    string $token )
      {

         // Call the parent constructor
         parent::__construct( $api_endpoint_id );

         // Set the class data
         $this->setToken( $token );
      }


      /**
       * Gets the MailChimp token
       *
       * @return string
       */
      public function getToken (): string
      {

         // Return it
         return $this->token;
      }


      /**
       * Sets the MailChimp token
       *
       * @param string $token The MailChimp token for communicating with the API
       */
      public function setToken ( string $token ): void
      {

         // Set the token
         $this->token = $token;
      }

   }