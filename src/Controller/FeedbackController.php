<?php

namespace ItkDev\TidyFeedbackBundle\Controller;

use Doctrine\Common\Collections\Order;
use ItkDev\TidyFeedbackBundle\Entity\FeedbackItem;
use ItkDev\TidyFeedbackBundle\Repository\FeedbackItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FeedbackController extends AbstractController
{
    public function index(FeedbackItemRepository $itemRepository): Response
    {
        $items = $itemRepository->findBy([], orderBy: ['createdAt' => Order::Descending->value]);

        return $this->render('@TidyFeedback/default/index.html.twig', [
            'items' => $items,
        ]);
    }

    public function create(Request $request, FeedbackItemRepository $itemRepository): Response
    {
        $item = (new FeedbackItem())
            ->setSubject(__METHOD__);
        $itemRepository->persist($item, flush: true);

        return $this->json(['item' => $item]);
    }

    public function show(FeedbackItem $item): Response
    {
        return $this->render('@TidyFeedback/default/show.html.twig', [
            'item' => $item,
        ]);
    }
}
