<?php
namespace Elton\CoreBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Elton\PaymentBundle\Entity\Subscription;

/**
 * Description of PremiumCommand
 *
 * @author Christian Hiroz christian.hiroz[at]gmail.com
 */
class RelanceCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('payment:relance')
            ->setDescription('Check for every use if a relance email is needed (8 day and expire)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = "END: Relance= ";
        $relance = 0; $fin = 0; $payment = 0; $registration = 0;
        $mailer = $this->getContainer()->get('elton.mailer');
        $userManager = $this->getContainer()->get('elton.teacher.manager');
        $userRepo = $userManager->getRepository();
        $allUser = $userRepo->findAll();
        $isOpenTicket = $this->getContainer()->get('elton.ticket.manager')->isOpenTicket();
        foreach($allUser as $user){
            $subscription = $user->getSubscriptions()->last();
            if(!$user->hasRole("ROLE_TEACHER_PREMIUM") && !$user->hasRole("ROLE_TEACHER_INACTIF")){
                $dif = $subscription->getSubscriptionDate()->diff(new \DateTime());
                if($dif->d == 8) {
                    $mailer->sendTestEnd($user, false);
                    $relance++;
                }
                else if($dif->d == 11) {
                    $mailer->sendTestEnd($user, true);
                    $user->addRole("ROLE_TEACHER_INACTIF");
                    $user->removeRole("ROLE_TEACHER_PAYING");
                    $userManager->persist($user);
                    $fin++;
                }
                else if($dif->d == 1) {
                    $registration++;
                }
            }
            else{
                $dif2 = $subscription->getPaymentDate()->diff(new \DateTime());
                if($dif2->d == 1) {
                    $payment++;
                }
            }
        }
        $mailer->sendBoarding($relance, $fin, $payment, $registration, $isOpenTicket);
        $text = $text . $relance . " Inactif= ". $fin;
        $output->writeln($text);
    }
}
