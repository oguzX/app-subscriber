<?php

namespace App\Security;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    /**
     * @var ParameterBagInterface
     */
    private $params;


    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): ?bool
    {
        return $request->headers->has('client-token');
    }

    public function authenticate(Request $request): Passport
    {
        $accessToken = $request->headers->get('client-token');
        if (null === $accessToken) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }

        try {
            $tokenData = JWT::decode($accessToken, new Key($this->params->get('auth_secret'), 'HS256'));
        } catch (\Exception $e) {
            throw new CustomUserMessageAuthenticationException(
                'AUTH_NEED_RELOGIN'
            );
        }


        if($tokenData->expireTime < time())
        {
            throw new CustomUserMessageAuthenticationException(
                'AUTH_TOKEN_EXPIRED'
            );
        }

        return new SelfValidatingPassport(
            new UserBadge($accessToken, function () use ($tokenData,$accessToken) {
                $apiKeyUser = new ApiKeyUser();
                $apiKeyUser->setUid($tokenData->uId);
                $apiKeyUser->setAppId($tokenData->appId);
                $apiKeyUser->setOperatingSystem($tokenData->operatingSystem);
                $apiKeyUser->setToken($accessToken);

                return $apiKeyUser;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}