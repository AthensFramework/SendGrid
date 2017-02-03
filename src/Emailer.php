<?php

namespace Athens\SendGrid;

use Athens\Core\Emailer\AbstractEmailer;
use Athens\Core\Email\EmailInterface;

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

        foreach (explode(';', $email->getTo()) as $to) {
            $sendgridEmail->addTo(trim($to));
        }

        foreach (explode(';', $email->getCc()) as $cc) {
            $sendgridEmail->addCc(trim($cc));
        }

        foreach (explode(';', $email->getBcc()) as $bcc) {
            $sendgridEmail->addBcc(trim($bcc));
        }

        if (((string)$email->getReplyTo()) !== "") {
            $sendgridEmail->setReplyTo($email->getReplyTo());
        }
        
        $sendgridEmail
            ->setReplyTo($email->getReplyTo())
            ->setFrom($email->getFrom())
            ->setSubject($email->getSubject())
            ->setHtml($body);

        /** @var Response $res */
        $res = static::getSendGrid()->send($sendgridEmail);

        return $res->getCode() === 200;
    }
}
