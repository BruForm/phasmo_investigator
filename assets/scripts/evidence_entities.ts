interface Entities {
    entityNames: string[]
}

function evidenceEntities(): void {
    this.classList.toggle('ev-checked');

    let i = 0;
    const data: object[] = [];
    for (const chk of document.querySelectorAll('.ev-checked')) {
        i++;
        const evSelected: string = chk.getAttribute('data-evidence-id');
        data.push({'id': evSelected});
    }
    console.log(data);
    //ICI>>>

    const url: string = '/investigation/evidenceEntities/' + JSON.stringify(data);
    fetch(url)
        .then(response => response.json() as Promise<Entities>)
        .then(function (data) {
                console.log(data);
            }
        )
    ;


    // const nbChecked: number = document.querySelectorAll('.ev-checked').length;
    // if (nbChecked > 0) {
    //     const evidenceSelected: string = this.getAttribute('data-evidence-id');
    //     if (evidenceSelected) {
    //         const data = {
    //             'id': evidenceSelected,
    //         }
    //         const url: string = '/investigation/evidenceEntities/' + JSON.stringify(data);
    //         fetch(url)
    //             .then(response => response.json() as Promise<Entities>)
    //             .then(function (data) {
    //                     for (const entityName of document.querySelectorAll<HTMLSpanElement>('.js-entity')) {
    //                         if (entityName) {
    //                             if (nbChecked > 1) {
    //                                 if (entityName.classList.contains('bloody')) {
    //                                     entityName.classList.remove('bloody')
    //                                     for (const name of data.entityNames) {
    //                                         if (name == entityName.innerText) {
    //                                             entityName.classList.add('bloody')
    //                                         }
    //                                     }
    //                                 }
    //                             } else {
    //                                 for (const name of data.entityNames) {
    //                                     if (name == entityName.innerText) {
    //                                         entityName.classList.add('bloody')
    //                                     }
    //                                 }
    //                             }
    //                         }
    //                     }
    //                 }
    //             )
    //         ;
    //     }
    // } else {
    //     for (const entityName of document.querySelectorAll<HTMLSpanElement>('.js-entity')) {
    //         entityName.classList.remove('bloody');
    //     }
    // }
}

function evidenceEntitiesReset(): string {
    let oldEntity: string = "";
    for (const entityName of document.querySelectorAll<HTMLSpanElement>('.js-entity')) {
        if (entityName.classList.contains('bloody')) {
            entityName.classList.remove('bloody');
            oldEntity = entityName.getAttribute('data-Entity-id');
            break;
        }
    }
    for (const evidenceName of document.querySelectorAll<HTMLSpanElement>('.evidence_name')) {
        if (evidenceName.classList.contains('bloody')) {
            evidenceName.classList.remove('bloody');
        }
    }
    return oldEntity;
}

window.addEventListener('load', () => {
    document.querySelectorAll('.js-evidence').forEach(checkbox => {
        checkbox.addEventListener("change", evidenceEntities);
    });
});