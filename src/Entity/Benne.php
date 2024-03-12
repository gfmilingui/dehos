<?php

namespace App\Entity;

use App\Service\AvailableOptions;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\BenneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BenneRepository::class)]
#[ORM\HasLifecycleCallbacks()]
#[UniqueEntity(fields: ['numero_serie'], message: 'Une Benne existe déjà avec le numéro de série saisie. Changez le numéro de série.')]
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
    'id' => 'exact', 'numero_serie' => 'exact', 'etat' => 'exact', 'statut_workflow' => 'exact', 
    'label' => 'partial', 'capacite' => 'exact', 'capacite_unite' => 'exact'
])]
class Benne
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
    private ?string $numero_serie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $label = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_livraison = null;

    #[ORM\Column]
    private ?float $capacite = null;

    #[ORM\Column(length: 255)]
    private ?string $capacite_unite = null;

    #[ORM\Column(length: 255)]
    private ?string $statut_workflow = null;

    private ?array $badgeActionEtat = array(
        "vueAffectation" => array(
            "action" => "",
            "colorAction" => "",
            "colorTextAction" => "",
            "etat" => "",
            "colorEtat" => "",
            "colorTextEtat" => "",
        ),
        "vueBonSortie" => array(
            "action" => "",
            "colorAction" => "",
            "colorTextAction" => "",
            "etat" => "",
            "colorEtat" => "",
            "colorTextEtat" => "",
        ),
        "vueSuiviRetours" => array(
            "action" => "",
            "colorAction" => "",
            "colorTextAction" => "",
            "etat" => "",
            "colorEtat" => "",
            "colorTextEtat" => "",
        ),
        "vueTraitement" => array(
            "action" => "",
            "colorAction" => "",
            "colorTextAction" => "",
            "etat" => "",
            "colorEtat" => "",
            "colorTextEtat" => "",
        ),
    );

    #[ORM\ManyToOne(inversedBy: 'bennes')]
    private ?Site $site = null;

    #[ORM\ManyToMany(targetEntity: BonSortie::class, mappedBy: 'bennes')]
    private Collection $bonSorties;

    #[ORM\OneToMany(mappedBy: 'benne', targetEntity: SuiviRetour::class)]
    private Collection $suivis_retours;

    #[ORM\OneToMany(mappedBy: 'benne', targetEntity: Traitement::class)]
    private Collection $traitements;

    public function __construct()
    {
        $this->etat = $this->statut = AvailableOptions::getEtatBenne()["Libre"];
        $this->statut_workflow = $this->statut = AvailableOptions::getworkflow()["Libre : Logistique"];
        $this->date_livraison = null;
        $this->bonSorties = new ArrayCollection();
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

    public function getNumeroSerie(): ?string
    {
        return $this->numero_serie;
    }

    public function setNumeroSerie(string $numero_serie): self
    {
        $this->numero_serie = $numero_serie;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->date_livraison;
    }

    public function setDateLivraison(?\DateTimeInterface $date_livraison): self
    {
        $this->date_livraison = $date_livraison;

        return $this;
    }

    public function getCapacite(): ?float
    {
        return $this->capacite;
    }

    public function setCapacite(float $capacite): self
    {
        $this->capacite = $capacite;

        return $this;
    }

    public function getCapaciteUnite(): ?string
    {
        return $this->capacite_unite;
    }

    public function setCapaciteUnite(string $capacite_unite): self
    {
        $this->capacite_unite = $capacite_unite;

        return $this;
    }

    public function getStatutWorkflow(): ?string
    {
        return $this->statut_workflow;
    }

    public function setStatutWorkflow(string $statut_workflow): self
    {
        $this->statut_workflow = $statut_workflow;

        return $this;
    }

    /*
    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function updateGlobalState(): void
    {
        if( $this->getId() !== null && $this->getSite() === null) {
            $this->date_livraison = null;
            $this->setEtat("Libre");
            $this->setStatutWorkflow("Libre : Logistique");
        }
        if( $this->getId() !== null && $this->getSite() !== null && $this->getEtat() === "Libre") {
            $this->setEtat("En attente de validation");
            $this->setStatutWorkflow("Génération Bon de Sortie : Stock");
        }
    }
    */

    /**
     * WARNING : It's important that the function updateGlobalState() is correctly managed.
     */
    public function getBadgeActionEtat() : array
    {

        if( $this->getEtat() === "Libre") {
            // ETAT => Libre
            // vueAffectation
            $this->badgeActionEtat["vueAffectation"]["action"] = "Affecter";
            $this->badgeActionEtat["vueAffectation"]["colorAction"] = "success";
            $this->badgeActionEtat["vueAffectation"]["colorTextAction"] = "white";
            $this->badgeActionEtat["vueAffectation"]["etat"] = "PARENT"; // PARENT <=> l'état de la variable $this->etat. 
            $this->badgeActionEtat["vueAffectation"]["colorEtat"] = "success";
            $this->badgeActionEtat["vueAffectation"]["colorTextEtat"] = "white";
            // vueBonSortie
            $this->badgeActionEtat["vueBonSortie"]["action"] = null;
            $this->badgeActionEtat["vueBonSortie"]["colorAction"] = "info";
            $this->badgeActionEtat["vueBonSortie"]["colorTextAction"] = "white";
            $this->badgeActionEtat["vueBonSortie"]["etat"] = "PARENT"; // PARENT <=> l'état de la variable $this->etat. 
            $this->badgeActionEtat["vueBonSortie"]["colorEtat"] = "success";
            $this->badgeActionEtat["vueBonSortie"]["colorTextEtat"] = "white";
        }
        if( $this->getEtat() === "En attente de validation") {
            // ETAT => En attente de validation
            // vueAffectation
            $this->badgeActionEtat["vueAffectation"]["action"] = "Modifier";
            $this->badgeActionEtat["vueAffectation"]["colorAction"] = "warning";
            $this->badgeActionEtat["vueAffectation"]["colorTextAction"] = "dark";
            $this->badgeActionEtat["vueAffectation"]["etat"] = "PARENT"; // PARENT <=> l'état de la variable $this->etat. 
            $this->badgeActionEtat["vueAffectation"]["colorEtat"] = "warning";
            $this->badgeActionEtat["vueAffectation"]["colorTextEtat"] = "dark";
            // vueBonSortie
            $this->badgeActionEtat["vueBonSortie"]["action"] = "Valider";
            $this->badgeActionEtat["vueBonSortie"]["colorAction"] = "success";
            $this->badgeActionEtat["vueBonSortie"]["colorTextAction"] = "white";
            $this->badgeActionEtat["vueBonSortie"]["etat"] = "PARENT"; // PARENT <=> l'état de la variable $this->etat. 
            $this->badgeActionEtat["vueBonSortie"]["colorEtat"] = "warning";
            $this->badgeActionEtat["vueBonSortie"]["colorTextEtat"] = "dark";
        }
        if( $this->getEtat() === "Validé") {
            // ETAT => En attente de validation
            // vueAffectation
            $this->badgeActionEtat["vueAffectation"]["action"] = "Modifier";
            $this->badgeActionEtat["vueAffectation"]["colorAction"] = "warning";
            $this->badgeActionEtat["vueAffectation"]["colorTextAction"] = "dark";
            $this->badgeActionEtat["vueAffectation"]["etat"] = "PARENT"; // PARENT <=> l'état de la variable $this->etat. 
            $this->badgeActionEtat["vueAffectation"]["colorEtat"] = "danger";
            $this->badgeActionEtat["vueAffectation"]["colorTextEtat"] = "white";
            // vueBonSortie
            $this->badgeActionEtat["vueBonSortie"]["action"] = "Imprimer BS";
            $this->badgeActionEtat["vueBonSortie"]["colorAction"] = "info";
            $this->badgeActionEtat["vueBonSortie"]["colorTextAction"] = "white";
            $this->badgeActionEtat["vueBonSortie"]["etat"] = "PARENT"; // PARENT <=> l'état de la variable $this->etat. 
            $this->badgeActionEtat["vueBonSortie"]["colorEtat"] = "danger";
            $this->badgeActionEtat["vueBonSortie"]["colorTextEtat"] = "white";
        }
        return $this->badgeActionEtat;
    }

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Collection<int, BonSortie>
     */
    public function getBonSorties(): Collection
    {
        return $this->bonSorties;
    }

    public function addBonSortie(BonSortie $bonSorty): self
    {
        if (!$this->bonSorties->contains($bonSorty)) {
            $this->bonSorties[] = $bonSorty;
            $bonSorty->addBenne($this);
        }

        return $this;
    }

    public function removeBonSorty(BonSortie $bonSorty): self
    {
        if ($this->bonSorties->removeElement($bonSorty)) {
            $bonSorty->removeBenne($this);
        }

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
            $suivisRetour->setBenne($this);
        }

        return $this;
    }

    public function removeSuivisRetour(SuiviRetour $suivisRetour): self
    {
        if ($this->suivis_retours->removeElement($suivisRetour)) {
            // set the owning side to null (unless already changed)
            if ($suivisRetour->getBenne() === $this) {
                $suivisRetour->setBenne(null);
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
            $traitement->setBenne($this);
        }

        return $this;
    }

    public function removeTraitement(Traitement $traitement): self
    {
        if ($this->traitements->removeElement($traitement)) {
            // set the owning side to null (unless already changed)
            if ($traitement->getBenne() === $this) {
                $traitement->setBenne(null);
            }
        }

        return $this;
    }
}