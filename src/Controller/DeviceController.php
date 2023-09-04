<?php

namespace App\Controller;

use App\Service\Security\LoginService;
use App\Type\RegisterType;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationListInterface;

#[Route('/api/device', name: 'app_api_device_')]
class DeviceController extends AbstractController
{
    #[Route('/login', name: 'register_check', methods: ['POST'])]
    #[ParamConverter('registerType', class: RegisterType::class, converter: 'fos_rest.request_body')]
    public function index(RegisterType $registerType, LoginService $loginService, ConstraintViolationListInterface $validationErrors): View
    {
        if (\count($validationErrors) > 0) {
            return View::create($validationErrors, Response::HTTP_BAD_REQUEST);
        }

        $token = $loginService->login($registerType);

        return View::create([
            'message' => 'OK',
            'client-token' => $token,
        ]);
    }
}