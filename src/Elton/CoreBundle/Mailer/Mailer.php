<?php


namespace Elton\CoreBundle\Mailer;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Routing\RouterInterface;
use Elton\TeacherBundle\Entity\Teacher as Teacher;
use Elton\TeacherBundle\Entity\Flyer as Flyer;

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
    protected $teacherManager;

    public function __construct($mailer, RouterInterface $router, $payment, EngineInterface $templating, $jumbotron, array $parameters, $teacherManager)
    {
        $this->jumbotron = $jumbotron;
        $this->mailer = $mailer;
        $this->router = $router;
        $this->payment = $payment;
        $this->templating = $templating;
        $this->parameters = $parameters;
        $this->teacherManager = $teacherManager;
    }
    
    public function sendBoarding($relance, $expiration, $payment, $registration, $isOpenTicket) 
    {
        $template = $this->parameters['template']['boarding'];
        $rendered = $this->templating->render($template, array(
            'relance' => $relance,
            'isOpenTicket' => $isOpenTicket,
            'expiration' => $expiration,
            'payment' => $payment,
            'registration' => $registration,
            'date' => new \DateTime(),
            ));
        
        $this->sendEmailMessage($rendered, "best_dev@elton.fr", $this->parameters['from_email']['elton']);
    }
    
    public function sendPaymentRequest(Teacher $user, $relance = false)
    {
        if($relance){
            $template = $this->parameters['template']['paymentRelance'];
        }
        else{
            $template = $this->parameters['template']['payment'];
        };
        $rendered = $this->templating->render($template, array(
            'user' => $user,
            'offer' => $user->getSubscriptions()->last()->getOffer(),
            'url' => $this->router->generate('teacher_payment_form', array('id' => $user->getId())),
        ));
        $this->sendEmailMessage($rendered, $this->parameters['from_email']['elton'], $user->getEmail());
    }
    
    public function sendRegisterEnd(Flyer $user)
    {
        $template = $this->parameters['template']['registerEnd'];
        $rendered = $this->templating->render($template, array(
            'user' => $user,
            'url' => $this->router->generate('flyer_to_teacher', array('id' => $user->getId())),
        ));
        
        $this->sendEmailMessage($rendered, $this->parameters['from_email']['elton'], $user->getEmail());
    }
    
    public function sendPaymentConfirmation(Teacher $user)
    {
        $template = $this->parameters['template']['paymentConfirm'];
        $rendered = $this->templating->render($template, array(
            'user' => $user,
            'offer' => $user->getSubscriptions()->last()->getOffer(),
        ));
        
        $this->sendEmailMessage($rendered, $this->parameters['from_email']['elton'], $user->getEmail());
    }
    
    public function sendPaymentFree(Teacher $user)
    {        
        $template = $this->parameters['template']['paymentFree'];
        $rendered = $this->templating->render($template, array(
            'user' => $user,
            'offer' => $user->getSubscriptions()->last()->getOffer(),
            'url' => $this->router->generate('teacher_payment_form', array('id' => $user->getId())),
        ));
        
        $this->sendEmailMessage($rendered, $this->parameters['from_email']['elton'], $user->getEmail());
        
    }
    public function sendTestEnd(Teacher $user, $end = false)
    {
        $subscription = $user->getSubscriptions()->last();
        //si fini
        if($end){
            $template = $this->parameters['template']['testEnd'];
        }
        else{
            $template = $this->parameters['template']['testEnding'];
        }
        $rendered = $this->templating->render($template, array(
            'user' => $user,
            'offer' => $subscription->getOffer(),
            'url' => $this->router->generate('teacher_payment_form', array('id' => $user->getId())),
        ));

        $this->sendEmailMessage($rendered, $this->parameters['from_email']['elton'], $user->getEmail());
    }
    /**
     * @param string $renderedTemplate
     * @param string $fromEmail
     * @param string $toEmail
     */
    protected function sendEmailMessage($renderedTemplate, $fromEmail, $toEmail)
    {   
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
