<?php

namespace App\Repository;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;






/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function trierNoms()
    {
        $users = $this->findAll();
        $noms = [];
        foreach ($users as $user) {
            $noms[] = $user->getNom(); // Ajoute le nom de chaque utilisateur à la liste des noms
        }
        sort($noms); // Trie les noms dans l'ordre alphabétique
        return $noms;
    }
 
    


    // public function updatePassword(Request $request, PasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    // {
    //     // Get the authenticated user
    //     $user = $this->getUser();

    //     // Retrieve the new password from the form submission
    //     $newPassword = $request->request->get('new_password');

    //     // Hash the new password
    //     $hashedPassword = $passwordEncoder->encodePassword($newPassword, null);

    //     // Set the hashed password for the user
    //     $user->setPassword($hashedPassword);

    //     // Persist and save the user entity
    //     $entityManager->persist($user);
    //     $entityManager->flush();

    //     // ...
    // }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }
}
//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
