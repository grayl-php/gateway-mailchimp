<?php

   namespace Grayl\Test\Gateway\MailChimp;

   use Grayl\Gateway\MailChimp\Controller\MailChimpSubscribeRequestController;
   use Grayl\Gateway\MailChimp\Controller\MailChimpSubscribeResponseController;
   use Grayl\Gateway\MailChimp\Entity\MailChimpGatewayData;
   use Grayl\Gateway\MailChimp\MailChimpPorter;
   use PHPUnit\Framework\TestCase;

   /**
    * Test class for the MailChimp package
    *
    * @package Grayl\Gateway\MailChimp
    */
   class MailChimpSubscribeRequestControllerTest extends TestCase
   {

      /**
       * Test setup for sandbox environment
       */
      public static function setUpBeforeClass (): void
      {

         // Change the API environment to sandbox mode
         MailChimpPorter::getInstance()
                        ->setEnvironment( 'sandbox' );
      }


      /**
       * Tests the creation of a MailChimpGatewayData object
       *
       * @return MailChimpGatewayData
       * @throws \Exception
       */
      public function testCreateMailChimpGatewayData (): MailChimpGatewayData
      {

         // Create the object
         $gateway = MailChimpPorter::getInstance()
                                   ->getSavedGatewayDataEntity( 'default' );

         // Check the type of object returned
         $this->assertInstanceOf( MailChimpGatewayData::class,
                                  $gateway );

         // Return the object
         return $gateway;
      }


      /**
       * Tests the creation of a MailChimpSubscribeRequestController object
       *
       * @return MailChimpSubscribeRequestController
       * @throws \Exception
       */
      public function testCreateMailChimpSubscribeRequestController (): MailChimpSubscribeRequestController
      {

         // Create the object
         $request = MailChimpPorter::getInstance()
                                   ->newMailChimpSubscribeRequestController( 'newsletter',
                                                                             'devtest@grogwood.com',
                                                                             'pending',
                                                                             [ 'FNAME' => 'TEST',
                                                                               'LNAME' => 'TESTING', ] );

         // Check the type of object returned
         $this->assertInstanceOf( MailChimpSubscribeRequestController::class,
                                  $request );

         // Return the object
         return $request;
      }


      /**
       * Tests the sending of a MailChimpSubscribeRequestData through a MailChimpSubscribeRequestController
       *
       * @param MailChimpSubscribeRequestController $request A configured MailChimpSubscribeRequestController entity to use as a gateway
       *
       * @depends testCreateMailChimpSubscribeRequestController
       * @return MailChimpSubscribeResponseController
       * @throws \Exception
       */
      public function testSendMailChimpSubscribeRequestController ( MailChimpSubscribeRequestController $request ): MailChimpSubscribeResponseController
      {

         // Send the request using the gateway
         $response = $request->sendRequest();

         // Check the type of object returned
         $this->assertInstanceOf( MailChimpSubscribeResponseController::class,
                                  $response );

         // Return the response
         return $response;
      }


      /**
       * Checks a MailChimpSubscribeResponseController for data and errors
       *
       * @param MailChimpSubscribeResponseController $response A MailChimpSubscribeResponseController returned from the gateway
       *
       * @depends testSendMailChimpSubscribeRequestController
       */
      public function testMailChimpSubscribeResponseController ( MailChimpSubscribeResponseController $response ): void
      {

         // Test the data
         $this->assertTrue( $response->isSuccessful() );
         $this->assertNotNull( $response->getReferenceID() );

         // Test the raw data
         $this->assertIsArray( $response->getData() );
      }

   }