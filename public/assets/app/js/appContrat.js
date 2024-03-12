jQuery(document).ready(function () {

    // Add event listener on add_item_link to add an item embedded collection form.
    document.querySelectorAll('.add_item_link').forEach(btn => {
        btn.addEventListener("click", (e) => {
            const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
            const item = document.createElement('div');
            // item.classList.add("row");
            item.innerHTML = collectionHolder
                .dataset
                .prototype
                .replace(
                    /__name__/g,
                    collectionHolder.dataset.index
                );
            collectionHolder.appendChild(item);
            collectionHolder.dataset.index++;

            document.querySelectorAll('.item_cost_change').forEach((element) => {
                eventCalculTotalUnitaire(element);
            });

            addItemFormDeleteLink(item, collectionHolder.dataset.index);
        });
    });

    // Remove attached on prototype to an item embedded collection form.
    const addItemFormDeleteLink = (item) => {
        const div = document.createElement('div');
        div.style.width = "20px";
        div.classList.add("mb-3", "row-form", "col-md-2");
        const removeFormButton = document.createElement('a');
        removeFormButton.classList.add("form-control", "form-control-sm");
        removeFormButton.style.border = "none";
        removeFormButton.innerHTML = '<i class="bi bi-trash-fill" style="color: red;"></i>';
        const label = document.createElement('label');
        label.innerHTML = "&nbsp;";
        label.classList.add("form-label");
        div.appendChild(label);
        div.appendChild(removeFormButton);
        item.childNodes[0].append(div);
        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            item.remove();
            calculFacture();
        });
    }

    // Add Remove to an item embedded collection form
    document.querySelectorAll('.row-item').forEach((item) => {
        const div = document.createElement('div');
        div.style.width = "20px";
        div.classList.add("mb-3", "row-form", "col-md-1");
        const removeFormButton = document.createElement('a');
        removeFormButton.classList.add("form-control", "form-control-sm");
        removeFormButton.style.border = "none";
        removeFormButton.innerHTML = '<i class="bi bi-trash-fill" style="color: red;"></i>';
        const label = document.createElement('label');
        label.innerHTML = "&nbsp;";
        label.classList.add("form-label");
        div.appendChild(label);
        div.appendChild(removeFormButton);
        item.appendChild(div);
        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            item.remove();
            calculFacture();
        });
    });

    // Using Onchange event listener to calcul the total cost of an item embedded collection form
    document.querySelectorAll('.item_cost_change').forEach((item) => {
        eventCalculTotalUnitaire(item);
    });

    // Using OnChange event listener to calcul discount.
    document.querySelectorAll('#facture_remise').forEach((item) => {
        eventCalculFactureRemise(item);
    });

    function eventCalculTotalUnitaire(item)
    {
        //item.addEventListener('keyup', (e) => {
        item.addEventListener('change', (e) => {
            let itemId = e.target.id;
            if (itemId === "" || itemId === undefined) {
                return;
            }
            calculFactureUnitaireProduct(itemId);
        });
    }

    function initializationCalcul()
    {
        // Using Onchange event listener to calcul the total cost of an item embedded collection form
        document.querySelectorAll('.item_cost_anchor').forEach((item) => {
            calculFactureUnitaireProduct(item.id);
        });
    }

    function calculFactureUnitaireProduct(itemId) {
        let patternE1 = /_\d+_/gm;
        let patternE2 = /\d+/gm;
        let processInterm1 = itemId.match(patternE1);
        let processInterm2 = processInterm1[0].match(patternE2);
        let index = processInterm2[0];
        let quantiteId = "facture_factureDescriptions_" + index + "_quantite";
        let prixUnitaireId = "facture_factureDescriptions_" + index + "_prix_unitaire";
        let totalHtId = "facture_factureDescriptions_" + index + "_total_ht";
        let total_ht = null;
        try {
            // Unitaire Total Net HT
            total_ht = $("#" + quantiteId).val() * $("#" + prixUnitaireId).val();
            if (isNaN(total_ht)) {
                total_ht = "Corriger vos valeurs"
                return;
            }
            $("#" + totalHtId).val(total_ht);
            calculFacture();
        } catch (error) {
            alert("Erreur lors du calcul du Total HT.");
        }
    }

    function eventCalculFactureRemise(item) {
        item.addEventListener('change', (e) => {
            let itemId = e.target.id;
            if (itemId === "" || itemId === undefined) {
                return;
            }
            try {
                // Get Total Net HT
                let facture_total_net_ht = $("#facture_total_net_ht").val();
                if (isNaN(facture_total_net_ht)) {
                    // Return we can't calcul discount with a NaN entry on facture_total_net_ht.
                    return;
                }
                // Apply Discount on Total Net HT
                let facture_remise_calculee = 0;
                let facture_remise = $("#facture_remise").val();
                if (isNaN(facture_remise)) {
                    // Return we can't calcul discount with a NaN entry on facture_remise.
                    return;
                }
                facture_remise_calculee = (facture_total_net_ht * facture_remise) / 100;
                // Total TTC
                // let tva = 10;
                let tva = $("#facture_tva").val();
                let tva_calculee = (facture_total_net_ht * tva) / 100;
                let facture_total_ttc = 0;
                facture_total_ttc = (facture_total_net_ht - facture_remise_calculee + tva_calculee);
                $("#facture_total_ttc").val(facture_total_ttc);
            } catch (error) {
                alert("Erreur lors du calcul de la remise.");
            }
        });
    }

    function calculFacture() {
        // Total Net HT
        let facture_total_net_ht = 0;
        document.querySelectorAll('.item_cost_total').forEach((item) => {
            if (!isNaN(item.value) && item.value !="" && item.value != undefined && item.value != null) {
                facture_total_net_ht = facture_total_net_ht + parseFloat(item.value);
            }
        });
        $("#facture_total_net_ht").val(facture_total_net_ht);

        // Apply Discount on Total Net HT
        let facture_remise_calculee = 0;
        let facture_remise = $("#facture_remise").val();
        if (!isNaN(facture_remise) && facture_remise !="" && facture_remise != undefined && facture_remise != null) {
            facture_remise_calculee = (facture_total_net_ht * facture_remise) / 100;
        }
        
        $("#facture_total_net_ht").val(facture_total_net_ht);
        // Total TTC
        // let tva = 10;
        let tva = $("#facture_tva").val();
        let tva_calculee = (facture_total_net_ht * tva) / 100;
        let facture_total_ttc = 0;
        facture_total_ttc = (facture_total_net_ht - facture_remise_calculee + tva_calculee);
        $("#facture_total_ttc").val(facture_total_ttc);
    }

    initializationCalcul();
});