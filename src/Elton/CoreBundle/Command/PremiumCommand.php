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
class PremiumCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('premium:give')
            ->setDescription('Give every user a free subscription to the "Premium" offer')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $text = "Complete";
        $premiumOffer = $this->getContainer()->get('elton.offer.manager')->getRepository()->find(2);
        $userManager = $this->getContainer()->get('elton.teacher.manager');
        $userRepo = $userManager->getRepository();
        $allUser = $userRepo->findAll();
        foreach($allUser as $user){
            $user->addRole("ROLE_TEACHER_PREMIUM");
            $subscription = new Subscription();
            $subscription->setOffer($premiumOffer);
            $user->setSubscription($subscription);
            $userManager->persist($user);
        }

        $output->writeln($text);
    }
}
