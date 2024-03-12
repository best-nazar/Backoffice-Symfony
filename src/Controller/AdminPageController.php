<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\User;
use App\Form\ImageType;
use App\Service\FileUploader\ImageUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminPageController extends AbstractController
{
    #[Route('/admin/home', name: 'app_admin_home')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminPageController',
        ]);
    }
    #[Route('/admin/user-settings', name: 'app_user_settings')]
    public function userSettings(Request $request, ImageUploader $imageUploader, EntityManagerInterface $entityManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();

            if ($imageFile && $imageUploader->upload($imageFile)) {
                $image->setPath($imageUploader->getPath());
                $image->setContext($user);
                $image->setEntityId($user->getUuid());
                $entityManager->persist($image);
                $entityManager->flush();
            }
        } else {
            $image = $entityManager->getRepository(Image::class)->getAvatar($user);
            $form->get('title')->setData($image->getTitle()) ;
        }

        return $this->render('admin/settings.html.twig', [
            'fileForm' => $form,
            'avatar' => $image,
        ]);
    }
}
