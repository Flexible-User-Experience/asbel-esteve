<?php

namespace AppBundle\Tests\Repository;

use AppBundle\Entity\ContactMessage;
use AppBundle\Tests\AbstractBaseTest;

/**
 * Class ContactMessageRepositoryTest
 *
 * @category Test
 * @package  AppBundle\Tests\Repository
 * @author   David Romaní <david@flux.cat>
 */
class ContactMessageRepositoryTest extends AbstractBaseTest
{
    /**
     * Main test
     */
    public function testMain()
    {
        $pendingMessagesAmount = $this->getContainer()->get('doctrine')->getRepository('AppBundle:ContactMessage')->getPendingMessagesAmount();
        $allMessages = $this->getContainer()->get('doctrine')->getRepository('AppBundle:ContactMessage')->findAll();
        $pendingMessages = 0;
        /** @var ContactMessage $cm */
        foreach ($allMessages as $cm) {
            if (!$cm->getChecked()) {
                $pendingMessages++;
            }
        }

        $this->assertEquals($pendingMessagesAmount, $pendingMessages);
    }
}
