<?php

namespace Athens\SendGrid;

use UWDOEM\Framework\Emailer\AbstractEmailer;
use UWDOEM\Framework\Email\EmailInterface;

use SendGrid;
use SendGrid\Response;
use SendGrid\Email as SendGridEmail;

/**
 * Class Emailer
 *
 * @package Athens\SendGrid\Emailer
 */
class Emailer extends AbstractEmailer
{

    /** @var SendGrid */
    protected static $sendgrid;

    /**
     * Get the active SendGrid connection.
     *
     * @return SendGrid
     * @throws \Exception If SENDGRID_API_KEY has not been declared.
     */
    protected function getSendGrid()
    {
        if (static::$sendgrid === null) {
            if (defined('SENDGRID_API_KEY') === false) {
                throw new \Exception("You must define a constant SENDGRID_API_KEY before using this library.");
            }

            static::$sendgrid = new SendGrid(SENDGRID_API_KEY);
        }

        return static::$sendgrid;
    }

    /**
     * @param string         $body
     * @param EmailInterface $email
     * @return boolean
     */
    protected function doSend($body, EmailInterface $email)
    {
        /** @var SendGridEmail $sendgridEmail */
        $sendgridEmail = new SendGridEmail();

        $sendgridEmail
            ->addTo($email->getTo())
            ->setFrom($email->getFrom())
            ->setSubject($email->getSubject())
            ->addCc($email->getCc())
            ->setBcc($email->getBcc())
            ->setHtml($body);

        /** @var Response $res */
        $res = static::getSendGrid()->send($sendgridEmail);

        return $res->getCode() === 200;
    }
}
