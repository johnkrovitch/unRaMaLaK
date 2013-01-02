<?php

namespace Krovitch\KrovitchBundle\DataFixtures;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Krovitch\KrovitchBundle\Entity\Race;
use Krovitch\KrovitchBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\ContainerInterface;

class KrovitchFixtures implements FixtureInterface, ContainerAwareInterface
{
    protected $container;
    protected $manager;

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        if (!$this->manager) {
            throw new InvalidArgumentException('Object manager is not valid');
        }
        $this->loadUsers();
        $this->loadRaces();

        $manager->flush();
    }

    public function loadUsers()
    {
        $users = array(
            array('username' => 'johnkrovitch', 'password' => 'krovitch', 'email' => 'arnaudfrezet@gmail.com', 'roles' => array('ROLE_ADMIN')),
            array('username' => 'frankgrozaloumek', 'password' => 'krovitch', 'email' => 'test@gmail.com', 'roles' => array('ROLE_USER')),
        );
        foreach ($users as $data) {
            $user = new User();
            $user->setUsername($data['username']);
            $user->setRoles($data['roles']);
            $user->setEmail($data['email']);
            $user->setEnabled(true);
            // encode password before insertion
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($user);
            $user->setPassword($encoder->encodePassword($data['password'], $user->getSalt()));


            $this->manager->persist($user);
        }
    }

    public function loadRaces()
    {
        $races = array(
            array('name' => 'Zaloumeks'),
            array('name' => 'Humains'),
            array('name' => 'Pirates'),
            array('name' => 'Bioptères'),
            array('name' => 'Aqualytes'),
            array('name' => 'Robots'),
        );
        foreach ($races as $data) {
            $race = new Race();
            $race->setName($data['name']);

            $this->manager->persist($race);
        }
    }

    /**
     * Sets the Container.
     *
     * @param ContainerInterface $container A ContainerInterface instance
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     * @return void
     */
    public function setContainer(ContainerInterface $container = null)
    {
        if (!$container) {
            throw new InvalidArgumentException('Container is not valid');
        }
        $this->container = $container;
    }
}