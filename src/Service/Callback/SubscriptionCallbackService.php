<?php

namespace App\Service\Callback;


use App\Entity\Application;
use App\Entity\Subscription;

class SubscriptionCallbackService{


    private CallbackService $callbackService;

    public function __construct(
        CallbackService $callbackService
    )
    {
        $this->callbackService = $callbackService;
    }

    public function send(Subscription $subscription, Application $application,  $callbackUrl){
        return $this->callbackService->request($callbackUrl, [
            'appId' => $application->getAppId(),
            'deviceId' => $subscription->getDevice()->getUid()
        ]);
    }

    public function started(Subscription $subscription)
    {
        $application = $subscription->getDevice()->getApplication();
        return $this->send($subscription, $application, $application->getCallbackStarted());
    }

    public function renewed(Subscription $subscription)
    {
        $application = $subscription->getDevice()->getApplication();
        return $this->send($subscription, $application, $application->getCallbackRenewed());
    }

    public function cancelled(Subscription $subscription)
    {
        $application = $subscription->getDevice()->getApplication();
        return $this->send($subscription, $application, $application->getCallbackCanceled());
    }

}
