<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Entity\Book;
use App\Form\BookType;


#[Route('/admin/book')]
class BookController extends AbstractController
{
    #[Route('', name: 'app_admin_book')]
    public function index(): Response
    {
        return $this->render('admin/book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/new', name: 'app_admin_book_new', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'app_admin_book_edit', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function new(?Book $book, Request $request, EntityManagerInterface $manager): Response
    {
        if($book){
            $this->denyAccessUnlessGranted('book.is_creator', $book);
            $this->denyAccessUnlessGranted('ROLE_EDITION_DE_LIVRE');
        }
        else{
            $this->denyAccessUnlessGranted('ROLE_AJOUT_DE_LIVRE');
        }

        $book ??= new Book();
        $form = $this->createForm(BookType::class, $book);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            if (!$book->getId() && $user instanceof User){
                $book->setCreatedBy($user);
            }
            $manager->persist($book);
            $manager->flush();

            return $this->redirectToRoute('app_book_index', ['id' => $book->getId()]);
        }

        return $this->render('admin/book/new.html.twig', [
            'form' => $form,
        ]);
    }
}
