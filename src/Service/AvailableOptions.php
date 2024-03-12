<?php

namespace App\Service;

class AvailableOptions {

    static function getRolesUser() :array {
        /*
        ROLE_GESTION:     ROLE_USER
        ROLE_ADMIN:       ROLE_GESTION
        ROLE_SUPER_ADMIN: [ROLE_ADMIN]
        */
        /*
        return 
        [
            'ROLE_USER',
            'ROLE_STOCK',
            'ROLE_AFFECTATION',
            'ROLE_SUIVI_RETOUR',
            'ROLE_TRAITEMENT',
            'ROLE_ADMIN',
            'ROLE_SUPER_ADMIN',
        ];
        */
        return 
        [
            // 'ROLE_USER' => 'ROLE_USER',
            'STOCK' => 'ROLE_STOCK',
            'AFFECTATION' => 'ROLE_AFFECTATION',
            'SUIVI_RETOUR' => 'ROLE_SUIVI_RETOUR',
            'TRAITEMENT' => 'ROLE_TRAITEMENT',
            'COMMERCIAL' => 'ROLE_COMMERCIAL',
            'MANAGER' => 'ROLE_MANAGER',
            'ADMIN' => 'ROLE_ADMIN',
            'SUPER ADMIN' => 'ROLE_SUPER_ADMIN',
        ];
    }

    static function getStatutDemandesAffectation() :array {
        return 
        [
            'Affecter' => 'Affecter', // action à afficher => Affecter
                                            // on clique sur "affecter" alors affectation auto.
                                            // on met le statut à "Affecter OK"
                                            // une fois l'affectation terminée, on fait disparâitre le bouton.
                                     // si nombre de benne est plus que l'initial,
                                            // alors mettre le statut à "Affecter"
                                            // affecter uniquement la nouvelle benne,
                                    // créer un bon de sortie à chaque affections avec la liste des bennes.
            'Affecter OK' => 'Affecter OK', // action à afficher => on affiche rien
        ];
    }

    static function getStatutSitesAffectation() :array {
        return 
        [
            'Affecter' => 'Affecter', // action à afficher => Affecter
                                            // on clique sur "affecter" alors affectation auto.
                                            // on met le statut à "Affecter OK"
                                            // une fois l'affectation terminée, on fait disparâitre le bouton.
                                     // si nombre de benne est plus que l'initial,
                                            // alors mettre le statut à "Affecter"
                                            // affecter uniquement la nouvelle benne,
                                    // créer un bon de sortie à chaque affections avec la liste des bennes.
            'Affecter OK' => 'Affecter OK', // action à afficher => on affiche rien
        ];
    }

    static function getEtatBenne() :array {
        return 
        [
            'Libre' => 'Libre',
                // <=> Vue Affectation => 
                    // Etat => Point : Vert
                    // Actions => Bouton : Affecter 
                // <=> Vue Bon de sortie =>
                    // Etat => Point : Vert
                    // Actions => Vide (Ne rien afficher) 

            'En attente de validation' => 'En attende de validation',
                // <=> Vue Affectation =>
                    // Etat => Point : Orange
                    // Actions => Bouton : Modifier 
                // <=> Vue Bon de sortie =>
                    // Etat => Text : En attende de validation
                    // Actions => Bouton : Valider 

            'Bon de sortie Validé' => 'Bon de sortie Validé',
                // <=> Vue Affectation =>
                    // Etat => Point : Rouge
                    // Actions => Bouton : Modifier // Idéalement ne pas mettre l'action tant que la benne n'est pas revenu.  
                // <=> Vue Bon de sortie =>
                    // Etat => Point : Rouge
                    // Actions => Bouton : Imprimer bon de sortie
            
            'Suivi Retour Validé' => 'Suivi Retour Validé',

            'Traitement Validé' => 'Traitement Validé',
        ];
    }

    static function getStatutBonSortie() :array {
        return 
        [
            'En attente de validation' => 'En attente de validation',
            'Validé' => 'Validé',
        ];
    }

    static function getStatutSuiviRetour() :array {
        return 
        [
            'En attente de validation' => 'En attente de validation',
            'Validé' => 'Validé',
        ];
    }

    static function getStatutTraitement() :array {
        return 
        [
            'En attente de validation' => 'En attente de validation',
            'Validé' => 'Validé',
        ];
    }

    static function getConstTraitement() :array {
        return 
        [
            'expedition_nettoyage_non' => 'Non',
            'expedition_nettoyage_oui' => 'Oui',
            'expedition_retour_stock_non' => 'Non',
            'expedition_retour_stock_oui' => 'Oui',
        ];
    }
    
    static function getworkflow() {
        return 
        [
            'Libre : Logistique' => 'Libre : Logistique', // 1
            'Génération Bon de Sortie : Stock' => 'Génération Bon de Sortie : Stock', // 2
            'Bon de sortie Validé : Stock' => 'Bon de sortie Validé : Stock', // 3
            // 'Attente Benne : Suivi Retours' => 'Attente Benne : Suivi Retours',
            'Suivi Retour Validé : Suivi Retours' => 'Suivi Retour Validé : Suivi Retours',
            'Pesée en cours : Suivi Retours' => 'Pesée en cours : Suivi Retours', // 4
            'Terminé : Suivi Retours' => 'Terminé : Suivi Retours', // 5
            'Attente Benne : Traitement' => 'Attente Benne : Traitement', // 6
            'Traitement Validé : Traitement' => 'Traitement Validé : Traitement',
            'Traitement en cours : Traitement' => 'Traitement en cours : Traitement', // 7
            'Nettoyage : Traitement' => 'Nettoyage : Traitement', // 8
            'Retour Stock : Traitement' => 'Retour Stock : Traitement', // 9

            // NON
            'Fin Cycle : Stock / 1 - Libre : Logistique' => 'Fin Cycle : Stock / 1 - Libre : Logistique', // 9
        ];
    }

    static function getCapaciteUnite() :array {
        return 
        [
            'Litre (L)' => 'Litre (L)',
            // 'Mètre-cube (m3)' => 'Mètre-cube (m3)',
        ];
    }

    static function getStatutConfigurations() :array {
        return 
        [
            'A valider' => 'A valider',
            'Validé' => 'Validé',
            'A traiter' => 'A traiter',
            'En cours' => 'En cours',
            'Traité' => 'Traité',
            'Ne pas traiter' => 'Ne pas traiter',
        ];
    }

    static function getCapaciteBenne() :array {
        return 
        [
            240 => 240
        ];
    }

    /*
    static function getQuantiteConfiguration() :array {
        $maxQuantite = 100;
        $quantiteList = [];
        for ($i=0; $i < $maxQuantite ; $i++) { 
            $quantiteList[$i+1]=$i+1;
        }
        return $quantiteList;
    }
    */

    static function getStatutWorkflowBenne() :array {
        return 
        [
            'Libre' => 'Libre',
            'A valider' => 'A valider',
            'Validée' => 'Validée',
            'Affectée' => "Affectée",
            'Bon de sortie établie' => "Bon de sortie établie",
            "Suivi Retour Benne | Pesage" => "Suivi Retour Benne | Pesage",
            'Traitement Benne' => "Traitement Benne",
            'Fin du cycle' => 'Fin du cycle',
            'Rupture de stock' => 'Rupture de stock',
            // 'Affecter les bennes' => 'Affecter les bennes',
        ];
    }

    static function getActionAffectationBenne() :array {
        return 
        [
            'Affecter' => 'Affecter',
            'Modifier' => 'Modifier',
        ];
    }

    static function getActionBonSortieBenne() :array {
        return 
        [
            '' => NULL,
            'Valider' => 'Valider',
        ];
    }

    static function getStatutFacture() :array {
        return 
        [
            'A Valider' => 'A Valider',
            'Validé' => 'Validé',
            'En cours' => 'En cours',
            'Payé' => 'Payé',
            'Ne pas traiter' => 'Ne pas traiter',
        ];
    }
    static function getStatutAffectation(): array {
        return 
        [
            'A Valider' => 'A Valider',
            'Validé' => 'Validé',
            'A traiter' => 'A traiter',
            'En cours' => 'En cours',
            'Traité' => 'Traité',
            'Ne pas traiter' => 'Ne pas traiter',
        ];
    }

    static function getStatutStock(): array {
        return 
        [
            'A Valider' => 'A Valider',
            'Validé' => 'Validé',
            'A traiter' => 'A traiter',
            'En cours' => 'En cours',
            'Traité' => 'Traité',
            'Ne pas traiter' => 'Ne pas traiter',
        ];
    }

    static function getStatutSuiviRetours(): array {
        return 
        [
            'A Valider' => 'A Valider',
            'Validé' => 'Validé',
            'A traiter' => 'A traiter',
            'En cours' => 'En cours',
            'Traité' => 'Traité',
            'Ne pas traiter' => 'Ne pas traiter',
        ];
    }

    /*
    static function getStatutTraitement(): array {
        return 
        [
            'A Valider' => 'A Valider',
            'Validé' => 'Validé',
            'A traiter' => 'A traiter',
            'En cours' => 'En cours',
            'Traité' => 'Traité',
            'Ne pas traiter' => 'Ne pas traiter',
        ];
    }
    */

    static function getStatutWorkflow(): array {
        return 
        [
            'Créer le client' => 'Créer le client',
            'Créer le site' => 'Créer le site',
            'Créer les bennes' => 'Créer les bennes',
            'Créer les configurations' => 'Créer les configurations',
            'Créer la factures' => 'Créer la factures',
            'Affecter les bennes' => 'Affecter les bennes',
            'Créer le bon de sortie' => 'Gérer les stocks', // 'Gérer les stocks' => 'Gérer les stocks',
            'Suivi des retours Bennes | Contrôle des pesées' => 'Suivi des retours Bennes | Contrôle des pesées',
            'Traitement des bennes' => 'Traitement des bennes',
            'Fin du cycle' => 'Fin du cycle',
        ];
    }

    static function getPaysConventionned() {
        return $citizenships = array (
            "AFG" => array( "pays" => "Afghanistan",                                        "nationalite" => "Afghane"),
            "ALB" => array( "pays" => "Albanie",                                            "nationalite" => "Albanaise"),
            "DZA" => array( "pays" => "Algérie",                                            "nationalite" => "Algérienne"),
            "DEU" => array( "pays" => "Allemagne",                                          "nationalite" => "Allemande"),
            "USA" => array( "pays" => "États-Unis",                                         "nationalite" => "Américaine"),
            "AND" => array( "pays" => "Andorre",                                            "nationalite" => "Andorrane"),
            "AGO" => array( "pays" => "Angola",                                             "nationalite" => "Angolaise"),
            "ATG" => array( "pays" => "Antigua-et-Barbuda",                                 "nationalite" => "Antiguaise-et-Barbudienne"),
            "ARG" => array( "pays" => "Argentine",                                          "nationalite" => "Argentine"),
            "ARM" => array( "pays" => "Arménie",                                            "nationalite" => "Arménienne"),
            "AUS" => array( "pays" => "Australie",                                          "nationalite" => "Australienne"),
            "AUT" => array( "pays" => "Autriche",                                           "nationalite" => "Autrichienne"),
            "AZE" => array( "pays" => "Azerbaïdjan",                                        "nationalite" => "Azerbaïdjanaise"),
            "BHS" => array( "pays" => "Bahamas",                                            "nationalite" => "Bahamienne"),
            "BHR" => array( "pays" => "Bahreïn",                                            "nationalite" => "Bahreinienne"),
            "BGD" => array( "pays" => "Bangladesh",                                         "nationalite" => "Bangladaise"),
            "BRB" => array( "pays" => "Barbade",                                            "nationalite" => "Barbadienne"),
            "BEL" => array( "pays" => "Belgique",                                           "nationalite" => "Belge"),
            "BLZ" => array( "pays" => "Belize",                                             "nationalite" => "Belizienne"),
            "BEN" => array( "pays" => "Bénin",                                              "nationalite" => "Béninoise"),
            "BTN" => array( "pays" => "Bhoutan",                                            "nationalite" => "Bhoutanaise"),
            "BLR" => array( "pays" => "Biélorussie",                                        "nationalite" => "Biélorusse"),
            "MMR" => array( "pays" => "Birmanie",                                           "nationalite" => "Birmane"),
            "GNB" => array( "pays" => "Guinée-Bissau",                                      "nationalite" => "Bissau-Guinéenne"),
            "BOL" => array( "pays" => "Bolivie",                                            "nationalite" => "Bolivienne"),
            "BIH" => array( "pays" => "Bosnie-Herzégovine",                                 "nationalite" => "Bosnienne"),
            "BWA" => array( "pays" => "Botswana",                                           "nationalite" => "Botswanaise"),
            "BRA" => array( "pays" => "Brésil",                                             "nationalite" => "Brésilienne"),
            "GBR" => array( "pays" => "Royaume-Uni",                                        "nationalite" => "Britannique"),
            "BRN" => array( "pays" => "Brunéi",                                             "nationalite" => "Brunéienne"),
            "BGR" => array( "pays" => "Bulgarie",                                           "nationalite" => "Bulgare"),
            "BFA" => array( "pays" => "Burkina",                                            "nationalite" => "Burkinabée"),
            "BDI" => array( "pays" => "Burundi",                                            "nationalite" => "Burundaise"),
            "KHM" => array( "pays" => "Cambodge",                                           "nationalite" => "Cambodgienne"),
            "CMR" => array( "pays" => "Cameroun",                                           "nationalite" => "Camerounaise"),
            "CAN" => array( "pays" => "Canada",                                             "nationalite" => "Canadienne"),
            "CPV" => array( "pays" => "Cap-Vert",                                           "nationalite" => "Cap-verdienne"),
            "CAF" => array( "pays" => "Centrafrique",                                       "nationalite" => "Centrafricaine"),
            "CHL" => array( "pays" => "Chili",                                              "nationalite" => "Chilienne"),
            "CHN" => array( "pays" => "Chine",                                              "nationalite" => "Chinoise"),
            "CYP" => array( "pays" => "Chypre",                                             "nationalite" => "Chypriote"),
            "COL" => array( "pays" => "Colombie",                                           "nationalite" => "Colombienne"),
            "COM" => array( "pays" => "Comores",                                            "nationalite" => "Comorienne"),
            "COD" => array( "pays" => "Congo-Kinshasa",                                     "nationalite" => "Congolaise"),
            "COG" => array( "pays" => "Congo-Brazzaville",                                  "nationalite" => "Congolaise"),
            "COK" => array( "pays" => "Îles Cook",                                          "nationalite" => "Cookienne"),
            "CRI" => array( "pays" => "Costa Rica",                                         "nationalite" => "Costaricaine"),
            "HRV" => array( "pays" => "Croatie",                                            "nationalite" => "Croate"),
            "CUB" => array( "pays" => "Cuba",                                               "nationalite" => "Cubaine"),
            "DNK" => array( "pays" => "Danemark",                                           "nationalite" => "Danoise"),
            "DJI" => array( "pays" => "Djibouti",                                           "nationalite" => "Djiboutienne"),
            "DOM" => array( "pays" => "République dominicaine",                             "nationalite" => "Dominicaine"),
            "DMA" => array( "pays" => "Dominique",                                          "nationalite" => "Dominiquaise"),
            "EGY" => array( "pays" => "Égypte",                                             "nationalite" => "Égyptienne"),
            "ARE" => array( "pays" => "Émirats arabes unis",                                "nationalite" => "Émirienne"),
            "GNQ" => array( "pays" => "Guinée équatoriale",                                 "nationalite" => "Équato-guineenne"),
            "ECU" => array( "pays" => "Équateur",                                           "nationalite" => "Équatorienne"),
            "ERI" => array( "pays" => "Érythrée",                                           "nationalite" => "Érythréenne"),
            "ESP" => array( "pays" => "Espagne",                                            "nationalite" => "Espagnole"),
            "TLS" => array( "pays" => "Timor-Leste",                                        "nationalite" => "Est-timoraise"),
            "EST" => array( "pays" => "Estonie",                                            "nationalite" => "Estonienne"),
            "ETH" => array( "pays" => "Éthiopie",                                           "nationalite" => "Éthiopienne"),
            "FJI" => array( "pays" => "Fidji",                                              "nationalite" => "Fidjienne"),
            "FIN" => array( "pays" => "Finlande",                                           "nationalite" => "Finlandaise"),
            "FRA" => array( "pays" => "France",                                             "nationalite" => "Française"),
            "GAB" => array( "pays" => "Gabon",                                              "nationalite" => "Gabonaise"),
            "GMB" => array( "pays" => "Gambie",                                             "nationalite" => "Gambienne"),
            "GEO" => array( "pays" => "Géorgie",                                            "nationalite" => "Georgienne"),
            "GHA" => array( "pays" => "Ghana",                                              "nationalite" => "Ghanéenne"),
            "GRD" => array( "pays" => "Grenade",                                            "nationalite" => "Grenadienne"),
            "GTM" => array( "pays" => "Guatemala",                                          "nationalite" => "Guatémaltèque"),
            "GIN" => array( "pays" => "Guinée",                                             "nationalite" => "Guinéenne"),
            "GUY" => array( "pays" => "Guyana",                                             "nationalite" => "Guyanienne"),
            "HTI" => array( "pays" => "Haïti",                                              "nationalite" => "Haïtienne"),
            "GRC" => array( "pays" => "Grèce",                                              "nationalite" => "Hellénique"),
            "HND" => array( "pays" => "Honduras",                                           "nationalite" => "Hondurienne"),
            "HUN" => array( "pays" => "Hongrie",                                            "nationalite" => "Hongroise"),
            "IND" => array( "pays" => "Inde",                                               "nationalite" => "Indienne"),
            "IDN" => array( "pays" => "Indonésie",                                          "nationalite" => "Indonésienne"),
            "IRQ" => array( "pays" => "Iraq",                                               "nationalite" => "Irakienne"),
            "IRN" => array( "pays" => "Iran",                                               "nationalite" => "Iranienne"),
            "IRL" => array( "pays" => "Irlande",                                            "nationalite" => "Irlandaise"),
            "ISL" => array( "pays" => "Islande",                                            "nationalite" => "Islandaise"),
            "ISR" => array( "pays" => "Israël",                                             "nationalite" => "Israélienne"),
            "ITA" => array( "pays" => "Italie",                                             "nationalite" => "Italienne"),
            "CIV" => array( "pays" => "Côte d'Ivoire",                                      "nationalite" => "Ivoirienne"),
            "JAM" => array( "pays" => "Jamaïque",                                           "nationalite" => "Jamaïcaine"),
            "JPN" => array( "pays" => "Japon",                                              "nationalite" => "Japonaise"),
            "JOR" => array( "pays" => "Jordanie",                                           "nationalite" => "Jordanienne"),
            "KAZ" => array( "pays" => "Kazakhstan",                                         "nationalite" => "Kazakhstanaise"),
            "KEN" => array( "pays" => "Kenya",                                              "nationalite" => "Kenyane"),
            "KGZ" => array( "pays" => "Kirghizistan",                                       "nationalite" => "Kirghize"),
            "KIR" => array( "pays" => "Kiribati",                                           "nationalite" => "Kiribatienne"),
            "KNA" => array( "pays" => "Saint-Christophe-et-Niévès",                         "nationalite" => "Kittitienne et Névicienne"),
            "KWT" => array( "pays" => "Koweït",                                             "nationalite" => "Koweïtienne"),
            "LAO" => array( "pays" => "Laos",                                               "nationalite" => "Laotienne"),
            "LSO" => array( "pays" => "Lesotho",                                            "nationalite" => "Lesothane"),
            "LVA" => array( "pays" => "Lettonie",                                           "nationalite" => "Lettone"),
            "LBN" => array( "pays" => "Liban",                                              "nationalite" => "Libanaise"),
            "LBR" => array( "pays" => "Libéria",                                            "nationalite" => "Libérienne"),
            "LBY" => array( "pays" => "Libye",                                              "nationalite" => "Libyenne"),
            "LIE" => array( "pays" => "Liechtenstein",                                      "nationalite" => "Liechtensteinoise"),
            "LTU" => array( "pays" => "Lituanie",                                           "nationalite" => "Lituanienne"),
            "LUX" => array( "pays" => "Luxembourg",                                         "nationalite" => "Luxembourgeoise"),
            "MKD" => array( "pays" => "Macédoine",                                          "nationalite" => "Macédonienne"),
            "MYS" => array( "pays" => "Malaisie",                                           "nationalite" => "Malaisienne"),
            "MWI" => array( "pays" => "Malawi",                                             "nationalite" => "Malawienne"),
            "MDV" => array( "pays" => "Maldives",                                           "nationalite" => "Maldivienne"),
            "MDG" => array( "pays" => "Madagascar",                                         "nationalite" => "Malgache"),
            "MLI" => array( "pays" => "Mali",                                               "nationalite" => "Maliennes"),
            "MLT" => array( "pays" => "Malte",                                              "nationalite" => "Maltaise"),
            "MAR" => array( "pays" => "Maroc",                                              "nationalite" => "Marocaine"),
            "MHL" => array( "pays" => "Îles Marshall",                                      "nationalite" => "Marshallaise"),
            "MUS" => array( "pays" => "Maurice",                                            "nationalite" => "Mauricienne"),
            "MRT" => array( "pays" => "Mauritanie",                                         "nationalite" => "Mauritanienne"),
            "MEX" => array( "pays" => "Mexique",                                            "nationalite" => "Mexicaine"),
            "FSM" => array( "pays" => "Micronésie",                                         "nationalite" => "Micronésienne"),
            "MDA" => array( "pays" => "Moldovie",                                           "nationalite" => "Moldave"),
            "MCO" => array( "pays" => "Monaco",                                             "nationalite" => "Monegasque"),
            "MNG" => array( "pays" => "Mongolie",                                           "nationalite" => "Mongole"),
            "MNE" => array( "pays" => "Monténégro",                                         "nationalite" => "Monténégrine"),
            "MOZ" => array( "pays" => "Mozambique",                                         "nationalite" => "Mozambicaine"),
            "NAM" => array( "pays" => "Namibie",                                            "nationalite" => "Namibienne"),
            "NRU" => array( "pays" => "Nauru",                                              "nationalite" => "Nauruane"),
            "NLD" => array( "pays" => "Pays-Bas",                                           "nationalite" => "Néerlandaise"),
            "NZL" => array( "pays" => "Nouvelle-Zélande",                                   "nationalite" => "Néo-Zélandaise"),
            "NPL" => array( "pays" => "Népal",                                              "nationalite" => "Népalaise"),
            "NIC" => array( "pays" => "Nicaragua",                                          "nationalite" => "Nicaraguayenne"),
            "NGA" => array( "pays" => "Nigéria",                                            "nationalite" => "Nigériane"),
            "NER" => array( "pays" => "Niger",                                              "nationalite" => "Nigérienne"),
            "NIU" => array( "pays" => "Niue",                                               "nationalite" => "Niuéenne"),
            "PRK" => array( "pays" => "Corée du Nord",                                      "nationalite" => "Nord-coréenne"),
            "NOR" => array( "pays" => "Norvège",                                            "nationalite" => "Norvégienne"),
            "OMN" => array( "pays" => "Oman",                                               "nationalite" => "Omanaise"),
            "UGA" => array( "pays" => "Ouganda",                                            "nationalite" => "Ougandaise"),
            "UZB" => array( "pays" => "Ouzbékistan",                                        "nationalite" => "Ouzbéke"),
            "PAK" => array( "pays" => "Pakistan",                                           "nationalite" => "Pakistanaise"),
            "PLW" => array( "pays" => "Palaos",                                             "nationalite" => "Palaosienne"),
            "PSE" => array( "pays" => "Palestine",                                          "nationalite" => "Palestinienne"),
            "PAN" => array( "pays" => "Panama",                                             "nationalite" => "Panaméenne"),
            "PNG" => array( "pays" => "Papouasie-Nouvelle-Guinée",                          "nationalite" => "Papouane-Néo-Guinéenne"),
            "PRY" => array( "pays" => "Paraguay",                                           "nationalite" => "Paraguayenne"),
            "PER" => array( "pays" => "Pérou",                                              "nationalite" => "Péruvienne"),
            "PHL" => array( "pays" => "Philippines",                                        "nationalite" => "Philippine"),
            "POL" => array( "pays" => "Pologne",                                            "nationalite" => "Polonaise"),
            "PRT" => array( "pays" => "Portugal",                                           "nationalite" => "Portugaise"),
            "QAT" => array( "pays" => "Qatar",                                              "nationalite" => "Qatarienne"),
            "ROU" => array( "pays" => "Roumanie",                                           "nationalite" => "Roumaine"),
            "RUS" => array( "pays" => "Russie",                                             "nationalite" => "Russe"),
            "RWA" => array( "pays" => "Rwanda",                                             "nationalite" => "Rwandaise"),
            "LCA" => array( "pays" => "Sainte-Lucie",                                       "nationalite" => "Saint-Lucienne"),
            "SMR" => array( "pays" => "Saint-Marin",                                        "nationalite" => "Saint-Marinaise"),
            "VCT" => array( "pays" => "Saint-Vincent-et-les Grenadines",                    "nationalite" => "Saint-Vincentaise et Grenadine"),
            "SLB" => array( "pays" => "Îles Salomon",                                       "nationalite" => "Salomonaise"),
            "SLV" => array( "pays" => "Salvador",                                           "nationalite" => "Salvadorienne"),
            "WSM" => array( "pays" => "Samoa",                                              "nationalite" => "Samoane"),
            "STP" => array( "pays" => "Sao Tomé-et-Principe",                               "nationalite" => "Santoméenne"),
            "SAU" => array( "pays" => "Arabie saoudite",                                    "nationalite" => "Saoudienne"),
            "SEN" => array( "pays" => "Sénégal",                                            "nationalite" => "Sénégalaise"),
            "SRB" => array( "pays" => "Serbie",                                             "nationalite" => "Serbe"),
            "SYC" => array( "pays" => "Seychelles",                                         "nationalite" => "Seychelloise"),
            "SLE" => array( "pays" => "Sierra Leone",                                       "nationalite" => "Sierra-Léonaise"),
            "SGP" => array( "pays" => "Singapour",                                          "nationalite" => "Singapourienne"),
            "SVK" => array( "pays" => "Slovaquie",                                          "nationalite" => "Slovaque"),
            "SVN" => array( "pays" => "Slovénie",                                           "nationalite" => "Slovène"),
            "SOM" => array( "pays" => "Somalie",                                            "nationalite" => "Somalienne"),
            "SDN" => array( "pays" => "Soudan",                                             "nationalite" => "Soudanaise"),
            "LKA" => array( "pays" => "Sri Lanka",                                          "nationalite" => "Sri-Lankaise"),
            "ZAF" => array( "pays" => "Afrique du Sud",                                     "nationalite" => "Sud-Africaine"),
            "KOR" => array( "pays" => "Corée du Sud",                                       "nationalite" => "Sud-Coréenne"),
            "SSD" => array( "pays" => "Soudan du Sud",                                      "nationalite" => "Sud-Soudanaise"),
            "SWE" => array( "pays" => "Suède",                                              "nationalite" => "Suédoise"),
            "CHE" => array( "pays" => "Suisse",                                             "nationalite" => "Suisse"),
            "SUR" => array( "pays" => "Suriname",                                           "nationalite" => "Surinamaise"),
            "SWZ" => array( "pays" => "Swaziland",                                          "nationalite" => "Swazie"),
            "SYR" => array( "pays" => "Syrie",                                              "nationalite" => "Syrienne"),
            "TJK" => array( "pays" => "Tadjikistan",                                        "nationalite" => "Tadjike"),
            "TZA" => array( "pays" => "Tanzanie",                                           "nationalite" => "Tanzanienne"),
            "TCD" => array( "pays" => "Tchad",                                              "nationalite" => "Tchadienne"),
            "CZE" => array( "pays" => "Tchéquie",                                           "nationalite" => "Tchèque"),
            "THA" => array( "pays" => "Thaïlande",                                          "nationalite" => "Thaïlandaise"),
            "TGO" => array( "pays" => "Togo",                                               "nationalite" => "Togolaise"),
            "TON" => array( "pays" => "Tonga",                                              "nationalite" => "Tonguienne"),
            "TTO" => array( "pays" => "Trinité-et-Tobago",                                  "nationalite" => "Trinidadienne"),
            "TUN" => array( "pays" => "Tunisie",                                            "nationalite" => "Tunisienne"),
            "TKM" => array( "pays" => "Turkménistan",                                       "nationalite" => "Turkmène"),
            "TUR" => array( "pays" => "Turquie",                                            "nationalite" => "Turque"),
            "TUV" => array( "pays" => "Tuvalu",                                             "nationalite" => "Tuvaluane"),
            "UKR" => array( "pays" => "Ukraine",                                            "nationalite" => "Ukrainienne"),
            "URY" => array( "pays" => "Uruguay",                                            "nationalite" => "Uruguayenne"),
            "VUT" => array( "pays" => "Vanuatu",                                            "nationalite" => "Vanuatuane"),
            "VAT" => array( "pays" => "Vatican",                                            "nationalite" => "Vaticane"),
            "VEN" => array( "pays" => "Venezuela",                                          "nationalite" => "Vénézuélienne"),
            "VNM" => array( "pays" => "Viêt Nam",                                           "nationalite" => "Vietnamienne"),
            "YEM" => array( "pays" => "Yémen",                                              "nationalite" => "Yéménite"),
            "ZMB" => array( "pays" => "Zambie",                                             "nationalite" => "Zambienne"),
            "ZWE" => array( "pays" => "Zimbabwe",                                           "nationalite" => "Zimbabwéenne")
        );    
    }

    static function getPays(): array {
        $paysConventionned = self::getPaysConventionned();
        $listPays = [];
        foreach ($paysConventionned as $key => $value) {
            $pays = $value["pays"];
            $listPays[$pays] = $pays;
        }
        return $listPays;
    }

    static function getStatutTache(): array {
        return
        [
            'Non commencée' => 'Non commencée',
            'En cours' => 'En cours',
            'Terminée' => 'Terminée',
        ];
    }

    static function getStatutSousTache(): array {
        return
        [
            'Non commencée' => 'Non commencée',
            'En cours' => 'En cours',
            'Terminée' => 'Terminée',
        ];
    }

    static function getConfigFacturesDevise(): array {
        return
        [
            'XAF' => 'XAF',
            'FCFA' => 'FCFA',
            'EUR' => 'EUR',
        ];
    }
}