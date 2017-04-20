<?php

namespace PlatformBundle\Email;

use UserBundle\Entity\User;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    protected $twig;

    public function __construct(\Twig_Environment $twig, \Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    public function registerMail(User $user)
    {
        $message = \Swift_Message::newInstance()
            ->setSubject('Confirmation de votre inscription')
            ->setFrom('karim.mecielgmail.com')
            ->setTo($user->getEmail())
            ->setBody($this->twig->render(
                'Emails/inscription.html.twig', array (
                'user' => $user
            )),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }

    public function resetPasswordMail(User $user, $password)
    {
        $body = $this->twig->render(
            'Emails/password.html.twig', array (
            'user' => $user,
            'password' => $password
        ));

        $message = \Swift_Message::newInstance()
            ->setSubject('Demande d\'un nouveau mot de passe')
            ->setFrom('karim.meciel@gmail.com')
            ->setTo($user->getEmail())
            ->setBody($body,
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }
}