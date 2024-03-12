jQuery(document).ready(function () {
    // Init Sites
    var sites = [];
    // Using Onchange event listener to get and load site regarding client selected.
    $("#demande_client").change(function () {
        let site_id = $(this).find('option:selected').val(); // let site_id = $('#demande_site option:selected').val();
        if(site_id === "")
        {
            $("#demande_site")
                .empty()
                .append('<option value="">Choisir</option>')
            ;
            $("#demande_nombre_bennes_libre").val("");
            $("#demande_nombre_bennes_allouees").val("");
            $("#demande_nombre_bennes_affectee").val("");
            return;
        }   
        var settings = {
            // "url": "localhost:81/api/sites?id=" + site_id,
            "url": "/client/" + site_id + "/ajax",
            "method": "GET",
            "timeout": 0,
            "headers": {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
        };
        $.ajax(settings).done(function (response) {
            sites = JSON.parse(response);
            $("#demande_site")
                .empty()
                .append('<option value="">Choisir</option>')
            ;
            sites.forEach(site => {
                let option = '<option value="'+site.id+'">'+site.nom+'</option>';
                $("#demande_site")
                .append(option)
                ;
            });
        });
    });

    // Using Onchange event listener in site.
    $("#demande_site").change(function () {
        let site_id = $(this).find('option:selected').val(); // let site_id = $('#demande_site option:selected').val();
        if(site_id !== "")
        {
            sites.forEach(site => {
                let id = site.id;
                if (id == site_id)
                {
                    let nombre_bennes_libre = site.nombre_bennes_libre;
                    let nombre_bennes = site.nombre_bennes;
                    let nombre_bennes_affectee = site.nombre_bennes_affectee;
                    $("#demande_nombre_bennes_libre").val(nombre_bennes_libre);
                    $("#demande_nombre_bennes_allouees").val(nombre_bennes);
                    $("#demande_nombre_bennes_affectee").val(nombre_bennes_affectee);
                    return;
                }
            });
            return;
        }
    });
});