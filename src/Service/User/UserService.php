<?php

namespace App\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    private const DEFAULT_PWD = '1234';

    /** @var UserRepository  */
    protected $userRepository;

    /** @var EntityManagerInterface  */
    protected $entityManager;

    /** @var UserPasswordEncoderInterface  */
    protected $passwordEncoder;

    /**
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
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
        if (empty($user->getPassword())) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, static::DEFAULT_PWD));
        }
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param User $user
     */
    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}