<?php

namespace ItkDev\TidyFeedbackBundle\Controller;

use Doctrine\Common\Collections\Order;
use Doctrine\ORM\EntityManager;
use ItkDev\TidyFeedbackBundle\Entity\FeedbackItem;
use ItkDev\TidyFeedbackBundle\Form\FeedbackForm;
use ItkDev\TidyFeedbackBundle\Repository\FeedbackItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FeedbackController extends AbstractController
{
    private EntityManager $entityManager;

    public function __construct()
    {
    }

    public function index(FeedbackItemRepository $itemRepository): Response
    {
        $items = $itemRepository->findBy([], orderBy: ['createdAt' => Order::Descending->value]);

        return $this->render('@TidyFeedback/default/index.html.twig', [
            'items' => $items,
        ]);
    }

    public function new(Request $request, FeedbackItemRepository $itemRepository): Response {
        $item = (new FeedbackItem())
            ->setData(['name' => 'Mikkel']);
        $form = $this->createForm(FeedbackForm::class, $item);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var FeedbackItem $item */
            $item = $form->getData();
            $itemRepository->persist($item, flush: true);

            return $this->redirectToRoute('tidy_feedback_show', ['item' => $item->getId()]);
        }


        return $this->render('@TidyFeedback/default/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function create(Request $request, FeedbackItemRepository $itemRepository): Response
    {
        $data = $request->toArray();
        try {
            if ($user = $this->getUser()) {
                $data['user'] = [
                    'identifier' => $user->getUserIdentifier(),
                    'roles' => $user->getRoles(),
                ];
            }
        } catch (\LogicException) {
            // The security bundle may not be loaded.
        }

        $item = (new FeedbackItem())
            ->setSubject($data['subject'] ?? __METHOD__)
            ->setData($data);
        $itemRepository->persist($item, flush: true);

        return $this->json(['item' => $item]);
    }

    public function show(FeedbackItem $item): Response
    {
        return $this->render('@TidyFeedback/default/show.html.twig', [
            'item' => $item,
        ]);
    }

    public function widget(): Response
    {
        return (new Response('alert(123)', headers:  ['content-type' => 'application/javascript; charset=utf-8']));
    }
}
