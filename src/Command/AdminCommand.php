<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:admin-create',
    description: 'Initial setup of the application and default values pesistance',
)]
class AdminCommand extends Command
{
    public function __construct(protected EntityManagerInterface $entityManager, protected UserPasswordHasherInterface $passwordHasher)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('password', InputArgument::OPTIONAL, 'Set password for admin')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('password');

        if (!$arg1) {
            $io->note(sprintf('You must pass argument, like: app:admin XXXX'));
            return Command::FAILURE;
        }

        $result = $this->addAdminUser($arg1);
        $io->success(['Success. ', $result]);

        return Command::SUCCESS;
    }

    protected function addAdminUser(string $password): string
    {
        // Create a new User instance
        $user = new User();
        $user->setUsername('admin');
        $user->setFirstName('admin');
        $user->setLastName('admin');
        $user->setEmail('admin@test.com');
        $user->setRoles([User::ROLE_ADMIN]);
        $user->setIsActive(true);
        $user->setIsVerified(true);

        // Encode the password before setting it
        $encodedPassword = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($encodedPassword);

        // Persist and flush to save the user to the database
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return sprintf("User ID: %s, username: %s, email: %s", $user->getUuid(), $user->getUsername(), $user->getEmail());
    }
}
