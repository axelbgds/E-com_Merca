<?php

namespace App\Controller\Admin;

use App\Entity\Promotions;
use App\Form\PromotionsFormType;
use App\Repository\PromotionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/promotions', name: 'admin_promo_')]
class PromotionsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(PromotionsRepository $promotionsRepository): Response
    {
        $promotions = $promotionsRepository->findAll();
        return $this->render('admin/promotions/index.html.twig', compact('promotions'));
    }

    #[Route('/ajout', name: 'add')]
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $promotion = new Promotions();

        $promotionForm = $this->createForm(PromotionsFormType::class, $promotion);

        $promotionForm->handleRequest($request);
        if ($promotionForm->isSubmitted() && $promotionForm->isValid()) {
            $promotion->getProducts()->setPromotion($promotion);
            $em->persist($promotion->getProducts());
            $em->persist($promotion);
            $em->flush();

            $this->addFlash('success', 'Promotion ajoutée avec succès');

            // On redirige
            return $this->redirectToRoute('admin_index');
        }

        return $this->renderForm('admin/promotions/add.html.twig', compact('promotionForm'));
    }

    #[Route('/edition/{id}', name: 'edit')]
    public function edit(Promotions $promotion, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $promotion);
        $promotionForm = $this->createForm(PromotionsFormType::class, $promotion);
        $promotionForm->handleRequest($request);

        //On vérifie si le formulaire est soumis ET valide
        if ($promotionForm->isSubmitted() && $promotionForm->isValid()) {
            // On stocke
            $em->persist($promotion);
            $em->flush();

            $this->addFlash('success', 'Promotion modifiée avec succès');

            // On redirige
            return $this->redirectToRoute('admin_promo_index');
        }

        return $this->render('admin/promotions/edit.html.twig', [
            'promotionForm' => $promotionForm->createView(),
            'promotion' => $promotion
        ]);
    }

    #[Route('/supprimer/{id}', name: 'delete', methods: ['POST', 'GET'])]
    public function delete(Request $request, Promotions $promotion, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', $promotion);

        $em->remove($promotion);
        $em->flush();


        // On redirige
        return $this->redirectToRoute('admin_promo_index');
    }
}
