<?php

declare(strict_types=1);

namespace Forumify\Forum\Repository;

use Forumify\Core\Repository\AbstractRepository;
use Forumify\Forum\Entity\Topic;

class TopicRepository extends AbstractRepository
{
    public static function getEntityClass(): string
    {
        return Topic::class;
    }
}
