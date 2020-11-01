<?php

   namespace Grayl\Gateway\MailChimp\Config;

   use Grayl\Gateway\Common\Config\GatewayConfigAbstract;
   use Grayl\Mixin\Common\Entity\KeyedDataBag;

   /**
    * Class MailChimpGatewayData
    * The class of the config for MailChimp gateways
    * @method MailChimpAPIEndpoint getLiveAPIEndpoint( string $api_endpoint_id )
    * @method void setLiveAPIEndpoint( MailChimpAPIEndpoint $api_endpoint )
    * @method MailChimpAPIEndpoint getSandboxAPIEndpoint( string $api_endpoint_id )
    * @method void setSandboxAPIEndpoint( MailChimpAPIEndpoint $api_endpoint )
    *
    * @package Grayl\Gateway\MailChimp
    */
   class MailChimpConfig extends GatewayConfigAbstract
   {

      /**
       * A bag of MailChimp list IDs
       *
       * @var KeyedDataBag
       */
      protected KeyedDataBag $mailchimp_list_ids;


      /**
       * Class constructor
       *
       * @param string $gateway_name       The name of the gateway
       * @param array  $mailchimp_list_ids An array of MailChimp lists in the format of alias=MailChimp list ID
       */
      public function __construct ( string $gateway_name,
                                    array $mailchimp_list_ids )
      {

         // Call the parent constructor
         parent::__construct( $gateway_name );

         // Create the required bags
         $this->mailchimp_list_ids = new KeyedDataBag();

         // Set the MailChimp list data
         $this->setMailChimpListIDs( $mailchimp_list_ids );

      }


      /**
       * Retrieves a stored MailChimp list ID
       *
       * @param string $list_alias The alias of the MailChimp list ID (eg. "newsletter")
       *
       * @return string
       */
      public function getMailChimpListID ( string $list_alias ): string
      {

         // Return the MailChimp list ID
         return $this->mailchimp_list_ids->getVariable( $list_alias );
      }


      /**
       * Sets a MailChimp list ID
       *
       * @param string $list_alias        The alias of the MailChimp list ID (eg. "newsletter")
       * @param string $mailchimp_list_id The actual MailChimp list ID
       */
      public function setMailChimpListID ( string $list_alias,
                                           string $mailchimp_list_id ): void
      {

         // Set the MailChimp list ID
         $this->mailchimp_list_ids->setVariable( $list_alias,
                                                 $mailchimp_list_id );
      }


      /**
       * Sets an array of MailChimp list IDs
       *
       * @param array $mailchimp_list_ids An array of MailChimp lists in the format of alias=MailChimp list ID
       */
      public function setMailChimpListIDs ( array $mailchimp_list_ids ): void
      {

         // Set the list IDs
         $this->mailchimp_list_ids->setVariables( $mailchimp_list_ids );
      }

   }