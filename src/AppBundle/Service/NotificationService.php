<?php

namespace AppBundle\Service;
use AppBundle\Entity\ContactMessage;

/**
 * Class NotificationService
 *
 * @category Service
 * @package  AppBundle\Service
 * @author   David Romaní <david@flux.cat>
 */
class NotificationService
{
    /** @var CourierService */
    private $messenger;

    /** @var \Twig_Environment */
    private $twig;

    /** @var string */
    private $amd;

    /**
     * NotificationService constructor
     *
     * @param CourierService    $messenger
     * @param \Twig_Environment $twig
     * @param string            $amd
     */
    public function __construct(CourierService $messenger, \Twig_Environment $twig, $amd)
    {
        $this->messenger = $messenger;
        $this->twig = $twig;
        $this->amd = $amd;
    }

    /**
     * Send a contact form notification to administrator
     *
     * @param ContactMessage $contactMessage
     */
    public function sendAdminNotification(ContactMessage $contactMessage)
    {
        $this->messenger->sendEmail(
            $contactMessage->getEmail(),
            $this->amd,
            'www.asbelesteve.com contact form recived',
            'TO DO...'
        );
    }
}
