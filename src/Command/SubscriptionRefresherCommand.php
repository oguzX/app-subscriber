<?php

namespace App\Command;

use App\Entity\Subscription;
use App\Exception\RateLimitExceededException;
use App\Service\Purchase\SubscriptionService;
use App\Service\QueService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * This command created for testing purposes
 * It implements ContainerAwareInterface like Controllers for the accessing Service Container
 */
#[AsCommand(
    name: "app:subscription:refresher",
    description: "Refresh Subscribers status"
)]
class SubscriptionRefresherCommand extends Command
{
    private QueService $queService;
    private SubscriptionService $subscriptionService;

    public function __construct(SubscriptionService $subscriptionService, QueService $queService)
    {
        parent::__construct();
        $this->queService = $queService;
        $this->subscriptionService = $subscriptionService;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $subscriptions = $this->subscriptionService->getActiveExpiredSubscriptions();

        /** @var Subscription $subscription */
        foreach ($subscriptions as $subscription){
            try{
                $io->writeln("#{$subscription->getId()} Checking");
//                $this->subscriptionService->deviceAppSubscription($subscription->getDevice(), $subscription->getReceipt());
                $this->queService->subscriberRefresh($subscription);
                $io->writeln("#{$subscription->getId()} Added To Que");
            }catch (RateLimitExceededException $exception){
                $io->warning("#{$subscription->getId()} couldn't refresh due to rate limit");
            }catch (\Exception $exception){
                $io->error($exception->getMessage());
            }
        }

        return Command::SUCCESS;
    }
}