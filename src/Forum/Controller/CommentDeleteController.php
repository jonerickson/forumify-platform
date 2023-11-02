<?php

declare(strict_types=1);

namespace Forumify\Forum\Controller;

use Forumify\Core\Security\VoterAttribute;
use Forumify\Forum\Entity\Comment;
use Forumify\Forum\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentDeleteController extends AbstractController
{
    public function __construct(private readonly CommentRepository $commentRepository)
    {
    }

    #[Route('/comment/{id}/delete', 'comment_delete')]
    public function __invoke(Comment $comment): Response
    {
        $this->denyAccessUnlessGranted(VoterAttribute::CommentDelete->value, $comment);

        $this->commentRepository->remove($comment);

        $this->addFlash('success', 'flashes.comment_removed');
        return $this->redirectToRoute('forumify_forum_topic', ['slug' => $comment->getTopic()->getSlug()]);
    }
}
