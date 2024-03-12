<?php

namespace App\Entity;

use Symfony\Component\Uid\Uuid;
use App\Service\AvailableOptions;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\BonSortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BonSortieRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[UniqueEntity(fields: ['reference'], message: 'Une Bon de Sortie existe déjà avec la référence saisie. Changez de référence.')]
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
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'reference' => 'exact', 'statut' => 'exact', 'nom_fourgon_chauffeur' => 'partial'])]
class BonSortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_fourgon_chauffeur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $remarque = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_sortie = null;

    #[ORM\ManyToMany(targetEntity: Benne::class, inversedBy: 'bonSorties')]
    private Collection $bennes;

    #[ORM\OneToMany(mappedBy: 'bonSortie', targetEntity: SuiviRetour::class)]
    private Collection $suivis_retours;

    #[ORM\OneToMany(mappedBy: 'bonSortie', targetEntity: Traitement::class)]
    private Collection $traitements;

    #[ORM\OneToOne(mappedBy: 'bon_sortie', cascade: ['persist', 'remove'])]
    private ?Demande $demande = null;

    public function __construct()
    {
        $uuid = Uuid::v4();
        $this->reference = $uuid->__toString();
        $this->statut = AvailableOptions::getStatutBonSortie()['En attente de validation'];
        $this->bennes = new ArrayCollection();
        $this->suivis_retours = new ArrayCollection();
        $this->traitements = new ArrayCollection();
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getNomFourgonChauffeur(): ?string
    {
        return $this->nom_fourgon_chauffeur;
    }

    public function setNomFourgonChauffeur(string $nom_fourgon_chauffeur): self
    {
        $this->nom_fourgon_chauffeur = $nom_fourgon_chauffeur;

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

    public function getRemarque(): ?string
    {
        return $this->remarque;
    }

    public function setRemarque(?string $remarque): self
    {
        $this->remarque = $remarque;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->date_sortie;
    }

    public function setDateSortie(?\DateTimeInterface $date_sortie): self
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }

    /**
     * @return Collection<int, Benne>
     */
    public function getBennes(): Collection
    {
        return $this->bennes;
    }

    public function addBenne(Benne $benne): self
    {
        if (!$this->bennes->contains($benne)) {
            $this->bennes[] = $benne;
        }

        return $this;
    }

    public function removeBenne(Benne $benne): self
    {
        $this->bennes->removeElement($benne);

        return $this;
    }

    /**
     * @return Collection<int, SuiviRetour>
     */
    public function getSuivisRetours(): Collection
    {
        return $this->suivis_retours;
    }

    public function addSuivisRetour(SuiviRetour $suivisRetour): self
    {
        if (!$this->suivis_retours->contains($suivisRetour)) {
            $this->suivis_retours[] = $suivisRetour;
            $suivisRetour->setBonSortie($this);
        }

        return $this;
    }

    public function removeSuivisRetour(SuiviRetour $suivisRetour): self
    {
        if ($this->suivis_retours->removeElement($suivisRetour)) {
            // set the owning side to null (unless already changed)
            if ($suivisRetour->getBonSortie() === $this) {
                $suivisRetour->setBonSortie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Traitement>
     */
    public function getTraitements(): Collection
    {
        return $this->traitements;
    }

    public function addTraitement(Traitement $traitement): self
    {
        if (!$this->traitements->contains($traitement)) {
            $this->traitements[] = $traitement;
            $traitement->setBonSortie($this);
        }

        return $this;
    }

    public function removeTraitement(Traitement $traitement): self
    {
        if ($this->traitements->removeElement($traitement)) {
            // set the owning side to null (unless already changed)
            if ($traitement->getBonSortie() === $this) {
                $traitement->setBonSortie(null);
            }
        }

        return $this;
    }

    public function getDemande(): ?Demande
    {
        return $this->demande;
    }

    public function setDemande(?Demande $demande): self
    {
        // unset the owning side of the relation if necessary
        if ($demande === null && $this->demande !== null) {
            $this->demande->setBonSortie(null);
        }

        // set the owning side of the relation if necessary
        if ($demande !== null && $demande->getBonSortie() !== $this) {
            $demande->setBonSortie($this);
        }

        $this->demande = $demande;

        return $this;
    }
}
