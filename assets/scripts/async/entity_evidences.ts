interface Evidences {
    evidenceNames: string[]
}

function entityEvidences(): void {
    const oldSelected: string = entityEvidencesReset();

    const entitySelected: string = this.getAttribute('data-entity-id');

    if (entitySelected != oldSelected) {
        if (entitySelected) {
            const data = {
                'id': entitySelected,
            }
            this.classList.toggle('selectEntTemp')
            const url: string = '/investigation/entityEvidences/' + JSON.stringify(data);
            fetch(url)
                .then(response => response.json() as Promise<Evidences>)
                .then(function (data) {
                    for (const evidenceName of document.querySelectorAll<HTMLLabelElement>('.evidence_name')) {
                        if (evidenceName) {
                            for (const name of data.evidenceNames) {
                                if (evidenceName.getAttribute('data-evidence-name') == name) {
                                    evidenceName.classList.toggle('selectEntTemp');
                                    evidenceName.querySelector('img').classList.toggle('selectEvTemp');
                                }
                                // OLD VERSION with text and checkboxes
                                // if (evidenceName.innerHTML == name) {
                                //     evidenceName.classList.toggle('selectEntTemp')
                                // }
                            }
                        }
                    }
                });
        }
    }
}

function entityEvidencesReset(): string {
    let oldEntity: string = "";
    for (const entityName of document.querySelectorAll<HTMLSpanElement>('.js-entity')) {
        if (entityName.classList.contains('selectEntTemp')) {
            entityName.classList.remove('selectEntTemp');
            oldEntity = entityName.getAttribute('data-entity-id');
            break;
        }
    }
    for (const evidenceName of document.querySelectorAll<HTMLLabelElement>('.evidence_name')) {
        if (evidenceName.classList.contains('selectEntTemp') || evidenceName.classList.contains('selectEvTemp')) {
            evidenceName.classList.remove('selectEntTemp');
            evidenceName.querySelector('img').classList.toggle('selectEvTemp');
        }
    }
    return oldEntity;
}

window.addEventListener('load', () => {

    document.querySelectorAll('.js-entity').forEach(selected => {
        selected.addEventListener('click', entityEvidences);
        // selected.addEventListener('mouseout', entityEvidencesReset);
    });
});