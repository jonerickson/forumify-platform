<?php

declare(strict_types=1);

namespace Forumify\Cms\EventSubscriber;

use Forumify\Admin\Crud\Event\PostSaveCrudEvent;
use Forumify\Cms\Entity\Page;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;

class PageEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly Environment $twig,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            PostSaveCrudEvent::getName(Page::class) => 'postSavePage',
        ];
    }

    /**
     * @param PostSaveCrudEvent<Page> $event
     */
    public function postSavePage(PostSaveCrudEvent $event): void
    {
        $page = $event->getEntity();

        $name = $page->getUrlKey();
        $cls = $this->twig->getTemplateClass($name);
        $key = $this->twig->getCache(false)->generateKey($name, $cls);

        $fs = new Filesystem();
        if ($fs->exists($key)) {
            $fs->remove($key);
        }
    }
}
