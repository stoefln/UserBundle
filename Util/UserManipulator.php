<?php

namespace FOS\UserBundle\Util;

use FOS\UserBundle\Model\UserManagerInterface;

/**
 * Executes some manipulations on the users
 */
class UserManipulator
{
    /**
     * User manager
     *
     * @var UserManagerInterface
     */
    private $userManager;

    public function __construct(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * Creates a user and returns it.
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @param Boolean $active
     * @param Boolean $superadmin
     * @return \FOS\UserBundle\Model\UserInterface
     */
    public function create($username, $password, $email, $active, $superadmin)
    {
        $user = $this->userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $user->setEnabled((Boolean)$active);
        $user->setSuperAdmin((Boolean)$superadmin);
        $this->userManager->updateUser($user);

        return $user;
    }

    /**
     * Activates the given user.
     *
     * @param string $username
     */
    public function activate($username)
    {
        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            throw new \InvalidArgumentException(sprintf('User identified by "%s" username does not exist.', $username));
        }
        $user->setEnabled(true);
        $this->userManager->updateUser($user);
    }

    /**
     * Deactivates the given user.
     *
     * @param string $username
     */
    public function deactivate($username)
    {
        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            throw new \InvalidArgumentException(sprintf('User identified by "%s" username does not exist.', $username));
        }
        $user->setEnabled(false);
        $this->userManager->updateUser($user);
    }

    /**
     * Changes the password for the given user.
     *
     * @param string $username
     * @param string $password
     */
    public function changePassword($username, $password)
    {
        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            throw new \InvalidArgumentException(sprintf('User identified by "%s" username does not exist.', $username));
        }
        $user->setPlainPassword($password);
        $this->userManager->updateUser($user);
    }

    /**
     * Promotes the given user.
     *
     * @param string $username
     */
    public function promote($username)
    {
        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            throw new \InvalidArgumentException(sprintf('User identified by "%s" username does not exist.', $username));
        }
        $user->setSuperAdmin(true);
        $this->userManager->updateUser($user);
    }

    /**
     * Demotes the given user.
     *
     * @param string $username
     */
    public function demote($username)
    {
        $user = $this->userManager->findUserByUsername($username);

        if (!$user) {
            throw new \InvalidArgumentException(sprintf('User identified by "%s" username does not exist.', $username));
        }
        $user->setSuperAdmin(false);
        $this->userManager->updateUser($user);
    }
}
