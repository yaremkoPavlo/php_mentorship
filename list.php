<?php

require_once __DIR__ . '/bootstrap.php';

use \App\Entity\Item;
use \App\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;

try {
    $user_id = $_SESSION['logged_user'];
    /** @var Doctrine\ORM\EntityManager $entityManager */
    $entityManager = \App\Container::get('entityManager');
    /** @var User $user */
    $user = $entityManager->find('App\Entity\User', $user_id);

    // Handle creating list item
    if ($_POST && isset($_POST['create']) && !empty($_POST['task'])) {
        $item = (new Item())->setTask($_POST['task'])->setUser($user);

        $entityManager->persist($item);
        $entityManager->flush();
    }

    // Handle editing list item
    if ($_POST && isset($_POST['update']) && !empty($_POST['task'])) {
        $itemId = filter_var($_POST['update'], FILTER_SANITIZE_NUMBER_INT);
        $task = filter_var($_POST['task'], FILTER_SANITIZE_STRING);
        $completed = filter_var($_POST['completed'] ?? false, FILTER_VALIDATE_BOOL);

        /** @var Item $item */
        $item = $entityManager->find('App\Entity\Item', $itemId);
        $item->setTask($task)->setCompleted($completed)->setUpdated(new DateTime('now'));

        $entityManager->persist($item);
        $entityManager->flush();
    }

    // Handle deleting list item
    if ($_POST && isset($_POST['delete'])) {
        $itemId = filter_var($_POST['delete'], FILTER_SANITIZE_NUMBER_INT);

        /** @var Item $item */
        $item = $entityManager->find('App\Entity\Item', $itemId);

        $entityManager->remove($item);
        $entityManager->flush();
    }

    // Sort and paginate
    // If enable sorting or pagination
    // Sorting and pagination could working together. Ex: /list.php?sort=task&order=ASC&per_page=5&page=2
    if ($_GET) {
        /** @var \Doctrine\ORM\QueryBuilder $query */
        $query = $entityManager->createQueryBuilder()
            ->select('i')
            ->from('App\Entity\Item', 'i')
            ->where('i.user=:user')
            ->setParameter('user', $user->getId());

        $props = $entityManager->getClassMetadata('App\Entity\Item')->getFieldNames();
        if (isset($_GET['sort']) && in_array($_GET['sort'], $props)) {
            $order = isset($_GET['order']) && $_GET['order'] === 'DESC' ? 'DESC' : 'ASC';

            $query->orderBy('i.' . $_GET['sort'], $order);
        }

        if (isset($_GET['per_page'])) {
            $perPage = filter_var($_GET['per_page'], FILTER_SANITIZE_NUMBER_INT);
            $perPage = $perPage > 0 ? $perPage : 1;

            $page = $_GET['page'] ?? 1;
            $page = filter_var($page, FILTER_SANITIZE_NUMBER_INT);

            $first = $page > 0 ? ($page - 1) * $perPage : 0;

            $query->setFirstResult($first)
                ->setMaxResults($perPage);
        }

        $items = new Paginator($query, $fetchJoinCollection = true);

        //@todo implement next and previously page
        $itemCount = $items->count();

        $items->getIterator()
            ->getArrayCopy();
    } else {
        // Fetch all items
        // Two ways get all items related to the same User
        /** @var Item[] $items */
        //$items = $entityManager->getRepository('App\Entity\Item')->findBy(array('user' => $user));
        $items = $user->getItems()->toArray();
    }

    require_once __DIR__ . '/resource/list.php';

} catch (Throwable $exception) {
    echo $exception->getMessage();
}