<?php

namespace App\Entity;

use App\Service\AvailableOptions;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\SuiviRetourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuiviRetourRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'security' => "is_granted('ROLE_USER')",
            'security_message' => "Action non autorisée",
        ]
    ],
    itemOperations: [
        'get' => [
            'security' => "is_granted('ROLE_SUPER_ADMIN')",
            'security_message' => "Action non autorisée",
        ],
    ],
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'statut' => 'exact', 'date_retour_benne' => 'exact'])]
class SuiviRetour
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_retour_benne = null;

    #[ORM\Column(nullable: true)]
    private ?float $pesee_agent = null;

    #[ORM\Column(nullable: true)]
    private ?float $pesee_client = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarques = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'suivis_retours')]
    private ?BonSortie $bonSortie = null;

    #[ORM\ManyToOne(inversedBy: 'suivis_retours')]
    private ?Benne $benne = null;

    public function __construct()
    {
        $this->statut = AvailableOptions::getStatutSuiviRetour()['En attente de validation'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateTimestamps(): void
    {
        $now = new \DateTimeImmutable();
        $this->setUpdatedAt($now);
        if ($this->getId() === null) {
            $this->setCreatedAt($now);
        }
    }

    public function getDateRetourBenne(): ?\DateTimeInterface
    {
        return $this->date_retour_benne;
    }

    public function setDateRetourBenne(?\DateTimeInterface $date_retour_benne): self
    {
        $this->date_retour_benne = $date_retour_benne;

        return $this;
    }

    public function getPeseeAgent(): ?float
    {
        return $this->pesee_agent;
    }

    public function setPeseeAgent(?float $pesee_agent): self
    {
        $this->pesee_agent = $pesee_agent;

        return $this;
    }

    public function getPeseeClient(): ?float
    {
        return $this->pesee_client;
    }

    public function setPeseeClient(?float $pesee_client): self
    {
        $this->pesee_client = $pesee_client;

        return $this;
    }

    public function getRemarques(): ?string
    {
        return $this->remarques;
    }

    public function setRemarques(string $remarques): self
    {
        $this->remarques = $remarques;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getBonSortie(): ?BonSortie
    {
        return $this->bonSortie;
    }

    public function setBonSortie(?BonSortie $bonSortie): self
    {
        $this->bonSortie = $bonSortie;

        return $this;
    }

    public function getBenne(): ?Benne
    {
        return $this->benne;
    }

    public function setBenne(?Benne $benne): self
    {
        $this->benne = $benne;

        return $this;
    }
}
