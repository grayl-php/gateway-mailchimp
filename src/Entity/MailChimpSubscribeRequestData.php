<?php

   namespace Grayl\Gateway\MailChimp\Entity;

   use Grayl\Gateway\Common\Entity\RequestDataAbstract;
   use Grayl\Mixin\Common\Entity\KeyedDataBag;

   /**
    * Class MailChimpSubscribeRequestData
    * The entity for a subscribe request to MailChimp
    *
    * @package Grayl\Gateway\MailChimp
    */
   class MailChimpSubscribeRequestData extends RequestDataAbstract
   {

      /**
       * The MailChimp list ID to add this subscriber to
       *
       * @var string
       */
      private string $list_id;

      /**
       * The email address of the subscriber
       *
       * @var string
       */
      private string $email_address;

      /**
       * The default status of the subscriber
       *
       * @var string
       */
      private string $status;

      /**
       * A set of MailChimp merge tags associated to this subscriber
       *
       * @var KeyedDataBag
       */
      private KeyedDataBag $merge_tags;


      /**
       * Class constructor
       *
       * @param string $action        The action performed in this request (send, etc.)
       * @param string $list_id       The MailChimp list ID to add this subscriber to
       * @param string $email_address The email address of the subscriber
       * @param string $status        The default status of the subscriber
       * @param array  $merge_tags    The associative array of merge tags to set ( key => value )
       */
      public function __construct ( string $action,
                                    string $list_id,
                                    string $email_address,
                                    string $status,
                                    array $merge_tags )
      {

         // Call the parent constructor
         parent::__construct( $action );

         // Create the merge tag bag
         $this->merge_tags = new KeyedDataBag();

         // Set the entity data
         $this->setListID( $list_id );
         $this->setEmailAddress( $email_address );
         $this->setStatus( $status );
         $this->setMergeTags( $merge_tags );
      }


      /**
       * Gets the list ID
       *
       * @return string
       */
      public function getListID (): string
      {

         // Return the list ID
         return $this->list_id;
      }


      /**
       * Sets the list ID
       *
       * @param string $list_id The MailChimp list ID to add this subscriber to
       */
      public function setListID ( string $list_id ): void
      {

         // Set the list ID
         $this->list_id = $list_id;
      }


      /**
       * Gets the email address of the subscriber
       *
       * @return string
       */
      public function getEmailAddress (): string
      {

         // Return the email
         return $this->email_address;
      }


      /**
       * Sets the email address of the subscriber
       *
       * @param string $email_address Full email address of the subscriber
       */
      public function setEmailAddress ( string $email_address ): void
      {

         // Set the email
         $this->email_address = $email_address;
      }


      /**
       * Gets the subscriber status
       *
       * @return string
       */
      public function getStatus (): string
      {

         // Return the status
         return $this->status;
      }


      /**
       * Sets the subscriber status
       *
       * @param string $status The default status of the subscriber
       */
      public function setStatus ( string $status ): void
      {

         // Set the status
         $this->status = $status;
      }


      /**
       * Sets a single merge tag
       *
       * @param string $key   The key name for the merge tag
       * @param mixed  $value The value of the merge tag
       */
      public function setMergeTag ( string $key,
                                    ?string $value ): void
      {

         // Set the merge tag
         $this->merge_tags->setVariable( $key,
                                         $value );
      }


      /**
       * Retrieves the value of a stored merge tag
       *
       * @param string $key The key name for the merge tag
       *
       * @return mixed
       */
      public function getMergeTag ( string $key )
      {

         // Return the value
         return $this->merge_tags->getVariable( $key );
      }


      /**
       * Retrieves the entire array of merge tags
       *
       * @return array
       */
      public function getMergeTags (): array
      {

         // Return all merge tags
         return $this->merge_tags->getVariables();
      }


      /**
       * Sets multiple merge tags using a passed array
       *
       * @param array $merge_tags The associative array of merge tags to set ( key => value )
       */
      public function setMergeTags ( array $merge_tags ): void
      {

         // Set the merge tags
         $this->merge_tags->setVariables( $merge_tags );
      }

   }