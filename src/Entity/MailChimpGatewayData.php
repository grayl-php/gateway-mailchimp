<?php

   namespace Grayl\Gateway\MailChimp\Entity;

   use DrewM\MailChimp\MailChimp;
   use Grayl\Gateway\Common\Entity\GatewayDataAbstract;

   /**
    * Class MailChimpGatewayData
    * The entity for the MailChimp API
    * @method void __construct( MailChimp $api, string $gateway_name, string $environment )
    * @method void setAPI( MailChimp $api )
    * @method MailChimp getAPI()
    *
    * @package Grayl\Gateway\MailChimp
    */
   class MailChimpGatewayData extends GatewayDataAbstract
   {

      /**
       * Fully configured MailChimp gateway entity
       *
       * @var MailChimp
       */
      protected $api;

   }