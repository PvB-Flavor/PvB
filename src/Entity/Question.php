<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * The question
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     * @Assert\Type("string")
     */
    private $question;

    /**
     * Input type for the question
     * @ORM\Column(type="string")
     * @Assert\AtLeastOneOf({
     *     @Assert\EqualTo("text"),
     *     @Assert\EqualTo("select"),
     *     @Assert\EqualTo("email"),
     *     @Assert\EqualTo("date"),
     *     @Assert\EqualTo("number"),
     *     @Assert\EqualTo("checkboxes"),
     *     @Assert\EqualTo("radios")
     * })
     */
    private $inputType;

    /**
     * In case the inputType is a select, there need to be multiple options
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $options;

    /**
     * Whether the field should take the full width of the form.
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $fullWidth;

    /**
     * Whether the field should take the full width of the form.
     * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
     */
    private $required;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $question
     */
    public function setQuestion($question): void
    {
        $this->question = $question;
    }

    /**
     * @return mixed
     */
    public function getInputType()
    {
        return $this->inputType;
    }

    /**
     * @param mixed $inputType
     */
    public function setInputType($inputType): void
    {
        $this->inputType = $inputType;
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param mixed $options
     */
    public function setOptions($options): void
    {
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getFullWidth()
    {
        return $this->fullWidth;
    }

    /**
     * @param mixed $fullWidth
     */
    public function setFullWidth($fullWidth): void
    {
        $this->fullWidth = $fullWidth;
    }

    /**
     * @return mixed
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param mixed $required
     */
    public function setRequired($required): void
    {
        $this->required = $required;
    }


}
