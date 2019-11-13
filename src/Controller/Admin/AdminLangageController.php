<?php

namespace App\Controller\Admin;

use App\Entity\Langage;
use App\Form\LangageType;
use App\Repository\LangageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/langage")
 */
class AdminLangageController extends AbstractController
{
    /**
     * @Route("/", name="admin.langage.index", methods={"GET"})
     */
    public function index(LangageRepository $langageRepository): Response
    {
        return $this->render('admin/langage/index.html.twig', [
            'langages' => $langageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin.langage.new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $langage = new Langage();
        $form = $this->createForm(LangageType::class, $langage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($langage);
            $entityManager->flush();

            return $this->redirectToRoute('admin.langage.index');
        }

        return $this->render('admin/langage/new.html.twig', [
            'langage' => $langage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin.langage.edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Langage $langage): Response
    {
        $form = $this->createForm(LangageType::class, $langage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.langage.index');
        }

        return $this->render('admin/langage/edit.html.twig', [
            'langage' => $langage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin.langage.delete", methods={"DELETE"})
     */
    public function delete(Request $request, Langage $langage): Response
    {
        if ($this->isCsrfTokenValid('admin/delete'.$langage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($langage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.langage.index');
    }
}
