jQuery(document).ready(function () {
    function initializationCalcul()
    {
        // Custom value for label contrat-form-element to add an item embedded collection form.
        let count = 0;
        document.querySelectorAll('.contrat-form-element').forEach((item) => {
            if(count > 0) {
                let textLabel = item.innerText;
                let tabTextLabel = textLabel.split("|");
                item.innerText = "";
                let htmlLabel =     "<span style='font-weight: bold;'>N° : </span>\
                                    <span class='text-muted'>[contrat_numero]</span>\
                                    <span style='font-weight: bold;'> | </span>\
                                    \
                                    <span style='font-weight: bold;'>Client : </span>\
                                    <span class='text-dark'>[contrat_client]</span>\
                                    <span style='font-weight: bold;'> | </span>\
                                    \
                                    <span style='font-weight: bold;'>Date Début : </span>\
                                    <span class='text-dark'>[contrat_date_debut]</span>\
                                    <span style='font-weight: bold;'> | </span>\
                                    \
                                    <span style='font-weight: bold;'>Date Fin : </span>\
                                    <span class='text-dark'>[contrat_date_fin]</span>"
                ;
                
                htmlLabel = htmlLabel.replace('[contrat_numero]', tabTextLabel[0]);
                htmlLabel = htmlLabel.replace('[contrat_client]', tabTextLabel[1]);
                htmlLabel = htmlLabel.replace('[contrat_date_debut]', tabTextLabel[2]);
                htmlLabel = htmlLabel.replace('[contrat_date_fin]', tabTextLabel[3]);

                item.innerHTML = htmlLabel;
            }
            count++;
        });
    }

    initializationCalcul();
});