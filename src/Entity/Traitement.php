<?php

namespace App\Entity;

use App\Service\AvailableOptions;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\TraitementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TraitementRepository::class)]
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
#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact', 'statut' => 'exact', 'expedition_nettoyage' => 'exact', 'expedition_retour_stock' => 'exact', 
    'date_reception' => 'exact', 'date_mise_traitement' => 'exact', 'date_fin_traitement' => 'exact'
])]
class Traitement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 255)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_reception = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_mise_traitement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fin_traitement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $expedition_nettoyage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $expedition_retour_stock = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarques = null;

    #[ORM\ManyToOne(inversedBy: 'traitements')]
    private ?BonSortie $bonSortie = null;

    #[ORM\ManyToOne(inversedBy: 'traitements')]
    private ?Benne $benne = null;

    public function __construct()
    {
        $this->statut = AvailableOptions::getStatutTraitement()['En attente de validation'];
        $this->expedition_nettoyage = AvailableOptions::getConstTraitement()['expedition_nettoyage_non'];
        $this->expedition_retour_stock = AvailableOptions::getConstTraitement()['expedition_retour_stock_non']; 
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

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateReception(): ?\DateTimeInterface
    {
        return $this->date_reception;
    }

    public function setDateReception(?\DateTimeInterface $date_reception): self
    {
        $this->date_reception = $date_reception;

        return $this;
    }

    public function getDateMiseTraitement(): ?\DateTimeInterface
    {
        return $this->date_mise_traitement;
    }

    public function setDateMiseTraitement(?\DateTimeInterface $date_mise_traitement): self
    {
        $this->date_mise_traitement = $date_mise_traitement;

        return $this;
    }

    public function getDateFinTraitement(): ?\DateTimeInterface
    {
        return $this->date_fin_traitement;
    }

    public function setDateFinTraitement(?\DateTimeInterface $date_fin_traitement): self
    {
        $this->date_fin_traitement = $date_fin_traitement;

        return $this;
    }

    public function getExpeditionNettoyage(): ?string
    {
        return $this->expedition_nettoyage;
    }

    public function setExpeditionNettoyage(?string $expedition_nettoyage): self
    {
        $this->expedition_nettoyage = $expedition_nettoyage;

        return $this;
    }

    public function getExpeditionRetourStock(): ?string
    {
        return $this->expedition_retour_stock;
    }

    public function setExpeditionRetourStock(string $expedition_retour_stock): self
    {
        $this->expedition_retour_stock = $expedition_retour_stock;

        return $this;
    }

    public function getRemarques(): ?string
    {
        return $this->remarques;
    }

    public function setRemarques(?string $remarques): self
    {
        $this->remarques = $remarques;

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
