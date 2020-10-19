<?php

   namespace Grayl\Gateway\MailChimp\Controller;

   use Grayl\Gateway\Common\Controller\ResponseControllerAbstract;
   use Grayl\Gateway\Common\Entity\ResponseDataAbstract;
   use Grayl\Gateway\Common\Service\ResponseServiceInterface;
   use Grayl\Gateway\MailChimp\Entity\MailChimpSubscribeResponseData;
   use Grayl\Gateway\MailChimp\Service\MailChimpSubscribeResponseService;

   /**
    * Class MailChimpSubscribeResponseController
    * The controller for working with MailChimpSubscribeResponseData entities
    *
    * @package Grayl\Gateway\MailChimp
    */
   class MailChimpSubscribeResponseController extends ResponseControllerAbstract
   {

      /**
       * The MailChimpSubscribeResponseData object that holds the gateway API response
       *
       * @var MailChimpSubscribeResponseData
       */
      protected ResponseDataAbstract $response_data;

      /**
       * The MailChimpSubscribeResponseService instance entity to use
       *
       * @var MailChimpSubscribeResponseService
       */
      protected ResponseServiceInterface $response_service;

   }