<?php


namespace Elton\CoreBundle\Mailer;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;
use Elton\TeacherBundle\Entity\Teacher as Teacher;

/**
 * Service Mailer, used to create & send message via SwiftMailer
 *
 * @author Christian Hiroz
 */
class Mailer {
    protected $mailer;
    protected $router;
    protected $payment;
    protected $templating;
    protected $parameters;
    protected $jumbotron;

    public function __construct($mailer, RouterInterface $router, $payment, EngineInterface $templating, $jumbotron, array $parameters)
    {
        $this->jumbotron = $jumbotron;
        $this->mailer = $mailer;
        $this->router = $router;
        $this->payment = $payment;
        $this->templating = $templating;
        $this->parameters = $parameters;
    }
    
    public function sendPaymentRequest(Teacher $user)
    {
        $numCommande = "ELTON" . date("Y") . date("n") . date("d") . $this->jumbotron->getRepository()->find(1)->getNmcmd();
        $this->jumbotron->persist($this->jumbotron->getRepository()->find(1));
	$shastring = $numCommande. ($user->getOffer()->getPrice()*100) . "EUR".$this->payment->getPspId().$this->payment->getShaSign();
        $template = $this->parameters['template']['payment'];
        $rendered = $this->templating->render($template, array(
            'user' => $user,
            'ogoneAddress' => $this->payment->getOgoneAddress(),
            'pspid' => $this->payment->getPspId(),
            'shastring' => strtoupper(sha1($shastring)),
            'numCommande' => $numCommande,
            'montant' => $user->getOffer()->getPrice()*100,
            'accepturl' => $this->router->generate('accepturl'),
            'cancelurl' => $this->router->generate('cancelurl'),
            'declineurl' => $this->router->generate('declineurl'),
            'exceptionurl' => $this->router->generate('exceptionurl'),
        ));
        $this->sendEmailMessage($rendered, $this->parameters['from_email']['elton'], $user->getEmail());
    }
    
    public function sendPaymentFree(Teacher $user)
    {
        
    }
    
    /**
     * @param string $renderedTemplate
     * @param string $fromEmail
     * @param string $toEmail
     */
    protected function sendEmailMessage($renderedTemplate, $fromEmail, $toEmail)
    {
        $toEmail = "twinkie.hiroz@gmail.com";
        // Render the email, use the first line as the subject, and the rest as the body
        $renderedLines = explode("\n", trim($renderedTemplate));
        $subject = $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($fromEmail)
            ->setTo($toEmail)
            ->setBody(
                '<html>' .
                ' <head></head>' .
                ' <body>' .
                $body .
                ' </body>' .
                '</html>',
                'text/html');
        $this->mailer->send($message);
    }
}
