jQuery(document).ready(function () {
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
            
            addFactureDescriptionFormDeleteLink(item, collectionHolder.dataset.index);
        });
    });

    const addFactureDescriptionFormDeleteLink = (item, collectionHolderDatasetIndex) => {
        console.log(collectionHolderDatasetIndex);
        const div = document.createElement('div');
        div.style.width = "20px";
        div.classList.add("mb-3", "row-form", "col-md-2");
        // const removeFormButton = document.createElement('button');
        // removeFormButton.classList.add("btn", "btn-danger", "btn-sm");
        // removeFormButton.classList.add("bg-danger", "text-white", "form-control", "form-control-sm");
        // removeFormButton.innerHTML = '<i class="bi bi-trash-fill"></i> Supprimer';
        const removeFormButton = document.createElement('a');
        removeFormButton.classList.add("form-control", "form-control-sm");
        removeFormButton.style.border = "none";
        removeFormButton.innerHTML = '<i class="bi bi-trash-fill" style="color: red;"></i>';
        const label = document.createElement('label');
         label.innerHTML="&nbsp;";
        //label.innerText = "Actions"
        label.classList.add("form-label");
        div.appendChild(label);
        div.appendChild(removeFormButton);
        item.childNodes[0].append(div);
        // item.firstChild.appendChild(firstChild);
        // item.append(removeFormButton);
        // facture_factureDescriptions_0
        // console.log(item.childNodes[0]);
    
        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            // remove the li for the FactureDescription form
            item.remove();
        });
    }

});