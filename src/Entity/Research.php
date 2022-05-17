<?php

namespace App\Entity;

use App\Repository\ResearchRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ResearchRepository::class)
 */
class Research
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * The title of the research
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $title;

    /**
     * If the research is still ongoing
     * @ORM\Column(type="boolean")
     * @Assert\NotBlank
     * @Assert\Type("bool")
     */
    private $ongoing;

    /**
     * The link to the form
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $formLink;

    /**
     * The path to research image
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $pathToImage;

    /**
     * The path to the company image
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $pathToCompanyImage;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getOngoing()
    {
        return $this->ongoing;
    }

    /**
     * @param mixed $ongoing
     */
    public function setOngoing($ongoing): void
    {
        $this->ongoing = $ongoing;
    }

    /**
     * @return mixed
     */
    public function getFormLink()
    {
        return $this->formLink;
    }

    /**
     * @param mixed $formLink
     */
    public function setFormLink($formLink): void
    {
        $this->formLink = $formLink;
    }

    /**
     * @return mixed
     */
    public function getPathToImage()
    {
        return $this->pathToImage;
    }

    /**
     * @param mixed $pathToImage
     */
    public function setPathToImage($pathToImage): void
    {
        $this->pathToImage = $pathToImage;
    }

    /**
     * @return mixed
     */
    public function getPathToCompanyImage()
    {
        return $this->pathToCompanyImage;
    }

    /**
     * @param mixed $pathToCompanyImage
     */
    public function setPathToCompanyImage($pathToCompanyImage): void
    {
        $this->pathToCompanyImage = $pathToCompanyImage;
    }
}
