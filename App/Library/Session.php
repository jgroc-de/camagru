<?php

declare(strict_types=1);

namespace App\Library;

class Session
{
    /** @var string */
    private $pseudo;

    /** @var int */
    private $id;

    /** @var bool */
    private $alert;

    /** @var string */
    private $email;

    public function __construct($user = null)
    {
        if ($user) {
            $this->setSession($user);
        }
    }

    public function updateSession(): void
    {
        $_SESSION['id'] = $this->id;
        $_SESSION['user'] = [
            'pseudo' => $this->pseudo,
            'id' => $this->id,
            'alert' => $this->alert,
            'email' => $this->email,
        ];
    }

    public function setSession(array $user): void
    {
        $_SESSION['id'] = $user['id'];
        $_SESSION['user'] = [
            'pseudo' => $user['pseudo'],
            'id' => $user['id'],
            'alert' => $user['alert'],
            'email' => $user['email'],
        ];
    }

    public function getSession(): ?array
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        return null;
    }

    public function setUserFromPostData(): void
    {
        $this->pseudo = $_POST['pseudo'];
        $this->email = $_POST['email'];
        $this->alert = isset($_POST['alert']) ? true : false;
        $this->id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getAlert(): bool
    {
        return $this->alert;
    }

    public function setAlert(bool $alert): void
    {
        $this->alert = $alert;
    }
}
