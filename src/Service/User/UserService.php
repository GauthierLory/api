<?php

namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    /** @var UserRepository  */
    private $userRepository;

    /** @var EntityManagerInterface  */
    private $entityManager;

    /**
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return User[]
     */
    public function findAll(): array
    {
        return $this->userRepository->findAll();
    }

    /**
     * @param User $user
     */
    public function editOrCreate(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}