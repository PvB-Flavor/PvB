<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * The senders firstname
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(
     *  min = 2,
     *  max = 20,
     *  minMessage = "Voornaam moet minstens {{ limit }} karakters lang zijn",
     *  maxMessage = "Voornaam mag niet langer zijn dan {{ limit }} karakters"
     * )
     */
    private $firstname;

    /**
     * The senders lastname
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(
     *  min = 2,
     *  max = 30,
     *  minMessage = "Achternaam moet minstens {{ limit }} karakters lang zijn",
     *  maxMessage = "Achternaam mag niet langer zijn dan {{ limit }} karakters"
     * )
     */
    private $lastname;

    /**
     * The senders email
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Email(
     *     message = "Opgegeven email is niet correct"
     * )
     */
    private $email;

    /**
     * The senders contact message
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(
     *  min = 10,
     *  max = 200,
     *  minMessage = "Bericht moet minstens {{ limit }} karakters lang zijn",
     *  maxMessage = "Bericht mag niet langer zijn dan {{ limit }} karakters"
     * )
     */
    private $message;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstname
     */
    public function setFirstname($firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }
}
