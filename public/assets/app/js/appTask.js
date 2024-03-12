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
        label.innerHTML="&nbsp;";
        label.classList.add("form-label");
        div.appendChild(label);
        div.appendChild(removeFormButton);
        item.childNodes[0].append(div);
        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            item.remove();
        });
    }

    // Add Remove to an item embedded collection form
    document.querySelectorAll('.row-item').forEach((item) => {
        const div = document.createElement('div');
        div.style.width = "20px";
        div.classList.add("mb-3", "row-form", "col-md-2");
        const removeFormButton = document.createElement('a');
        removeFormButton.classList.add("form-control", "form-control-sm");
        removeFormButton.style.border = "none";
        removeFormButton.innerHTML = '<i class="bi bi-trash-fill" style="color: red;"></i>';
        const label = document.createElement('label');
        label.innerHTML="&nbsp;";
        label.classList.add("form-label");
        div.appendChild(label);
        div.appendChild(removeFormButton);
        item.appendChild(div);
        removeFormButton.addEventListener('click', (e) => {
            e.preventDefault();
            item.remove();
        });
    });

});