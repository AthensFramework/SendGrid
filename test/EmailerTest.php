<?php

namespace UWDOEM\Encryption\Test;

use Athens\SendGrid\Test\Mock\MockEmailer;

use Athens\SendGrid\Test\Mock\MockSendGrid;
use Athens\Core\Email\EmailBuilder;
use Athens\Core\Email\EmailInterface;

use PHPUnit_Framework_TestCase;

/**
 * Class EmailerTest
 *
 * @package UWDOEM\Encryption\Test
 */
class EmailerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return EmailInterface
     */
    protected function makeEmail()
    {
        return EmailBuilder::begin()
            ->setSubject('title')
            ->setMessage('message')
            ->setTo('address')
            ->setFrom('from')
            ->build();
    }

    /**
     * If SENDGRID_API_KEY has not been defined when this library is called to use, then
     * an exception shall be raised.
     *
     * @return void
     * @expectedException              Exception
     * @expectedExceptionMessageRegExp #You must define a constant SENDGRID_API_KEY before using this library.*#
     */
    public function testExceptionRaisedIfAPIKeyNotDefined()
    {
        // The constant SENDGRID_API_KEY must be undefined to proceed with this test.
        $this->assertFalse(defined('SENDGRID_API_KEY'));

        $email = $this->makeEmail();

        $emailer = new MockEmailer();

        $emailer->send($email);
    }

    /**
     * If the code of the SendGrid\Response is 200, then the return of Emailer::send shall
     * be true.
     *
     * @return void
     */
    public function testReturnTrueIfResponseCode200()
    {
        if (defined('SENDGRID_API_KEY') !== true) {
            define('SENDGRID_API_KEY', 'asfdasdfasdfasdfasdfasdf');
        }

        MockSendGrid::$responseCode = 200;

        $email = $this->makeEmail();

        $emailer = new MockEmailer();

        $result = $emailer->send($email);

        $this->assertTrue($result);

    }

    /**
     * If the code of the SendGrid\Response is not 200, then the return of Emailer::send
     * shall be false.
     *
     * @return void
     */
    public function testReturnFalseIfResponseCodeNot200()
    {
        if (defined('SENDGRID_API_KEY') !== true) {
            define('SENDGRID_API_KEY', 'asfdasdfasdfasdfasdfasdf');
        }

        MockSendGrid::$responseCode = 400;

        $email = $this->makeEmail();

        $emailer = new MockEmailer();

        $result = $emailer->send($email);

        $this->assertFalse($result);
    }
}
