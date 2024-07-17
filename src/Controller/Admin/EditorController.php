<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\Editor;
use App\Form\EditorType;


#[Route('/admin/editor')]
class EditorController extends AbstractController
{
    #[Route('', name: 'app_admin_editor')]
    public function index(): Response
    {
        return $this->render('admin/editor/index.html.twig', [
            'controller_name' => 'EditorController',
        ]);
    }

    #[isGranted('ROLE_AJOUT_DE_LIVRE')]
    #[Route('/new', name: 'app_admin_editor_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_admin_editor_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Editor $editor, Request $request, EntityManagerInterface $manager): Response
    {
        if ($editor) {
            $this->denyAccessUnlessGranted('ROLE_EDITION_DE_LIVRE');
        }

        $editor ??= new Editor();
        $form = $this->createForm(EditorType::class, $editor);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($editor);
            $manager->flush();

            return $this->redirectToRoute('app_admin_editor', ['id' => $book->getId()] );
        }

        return $this->render('admin/editor/new.html.twig', [
            'form' => $form,
        ]);
    }
}
