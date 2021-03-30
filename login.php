<?php

require_once __DIR__ . '/bootstrap.php';
require_once __DIR__ . '/resource/login-form.php';

if ($_POST && $_POST['login']) {
    /** @var Doctrine\ORM\EntityManager $entityManager */
    $entityManager = \App\Container::get('entityManager');
    $userLogin = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
    $user = $entityManager->getRepository('App\Entity\User')->findOneBy(['name' => $userLogin]);

    if (!$user) {
        $user = new App\Entity\User();
        $user->setName($userLogin);
        $entityManager->persist($user);
        $entityManager->flush();
    }

    $_SESSION['logged_user'] = $user->getId();

    header('Location: /list.php');
}
