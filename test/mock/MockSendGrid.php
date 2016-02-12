<?php

namespace Athens\SendGrid\Test\Mock;

use SendGrid;
use SendGrid\Response;

/**
 * Class MockSendGrid
 *
 * @package Athens\SendGrid\Test\Mock
 */
class MockSendGrid extends SendGrid
{

    /** @var integer */
    public static $responseCode = 200;

    /**
     * Makes a post request to SendGrid to send an email
     *
     * @param SendGrid\Email $email Email object built.
     *
     * @throws SendGrid\Exception if the response code is not 200.
     * @return stdClass SendGrid response object
     */
    public function send(SendGrid\Email $email)
    {
        return new Response(static::$responseCode, null, null, null);
    }
}
