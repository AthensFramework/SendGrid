<?php

namespace Athens\SendGrid\Emailer;

use UWDOEM\Framework\Emailer\AbstractEmailer;
use UWDOEM\Framework\Email\EmailInterface;

use SendGrid;
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
     * @return SendGrid
     * @throws \Exception If SENDGRID_API_KEY has not been declared.
     */
    protected function getSendGrid() {
        if (static::$sendgrid === null) {
            if (defined('SENDGRID_API_KEY') === false) {
                throw new \Exception("You must define a constant SENDGRID_API_KEY before using this library.");
            }

            static::$sendgrid = new SendGrid(SENDGRID_API_KEY);
        }

        return static::$sendgrid;
    }

    /**
     * @param EmailInterface $email
     * @return string
     */
    protected function buildHeaders(EmailInterface $email)
    {
        $headers = ["From: " . $email->getFrom(), ];

        if ($email->getMimeVersion() !== null) {
            $headers[] = "MIME-VERSION: " . $email->getMimeVersion();
        }

        if ($email->getContentType() !== null) {
            $headers[] = "Content-type: " . $email->getContentType();
        }

        if ($email->getCc() !== null) {
            $headers[] = "Cc: " . $email->getCc();
        }

        if ($email->getBcc() !== null) {
            $headers[] = "Bcc: " . $email->getBcc();
        }

        if ($email->getXMailer() !== null) {
            $headers[] = "X-Mailer: " . $email->getXMailer();
        }

        return implode("\r\n", $headers);
    }

    /**
     * @param string         $body
     * @param EmailInterface $email
     * @return boolean
     */
    protected function doSend($body, EmailInterface $email)
    {
        $sendgridEmail = new SendGridEmail();

        $sendgridEmail
            ->addTo($email->getTo())
            ->setSubject($email->getSubject())
            ->addCc($email->getCc())
            ->setBcc($email->getBcc())
            ->setHtml($body);

        $res = static::getSendGrid()->send($sendgridEmail);

        return $res->getCode === 200;
    }
}
