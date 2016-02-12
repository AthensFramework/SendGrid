<?php

namespace Athens\SendGrid\Test\Mock;

use Athens\SendGrid\Emailer;

/**
 * Class MockEmailer substitutes a MockSendGrid when ::getSendGrid is called.
 *
 * @package Athens\SendGrid\Test\Mock
 */
class MockEmailer extends Emailer
{

    /**
     * @return MockSendGrid
     */
    protected function getSendGrid()
    {
        parent::getSendGrid();

        return new MockSendGrid(SENDGRID_API_KEY);
    }
}
