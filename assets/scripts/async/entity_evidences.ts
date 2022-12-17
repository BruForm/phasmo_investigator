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
            this.classList.add('selected_entity_temp')
            const url: string = '/investigation/entityEvidences/' + JSON.stringify(data);
            fetch(url)
                .then(response => response.json() as Promise<Evidences>)
                .then(function (data) {
                    for (const evidenceName of document.querySelectorAll<HTMLLabelElement>('.evidence_name')) {
                        if (evidenceName) {
                            for (const name of data.evidenceNames) {
                                if (evidenceName.getAttribute('data-evidence-name') == name) {
                                    evidenceName.classList.add('selected_entity_temp');
                                    evidenceName.querySelector('img').classList.add('selected_evidence_temp');
                                }
                                // OLD VERSION with text and checkboxes
                                // if (evidenceName.innerHTML == name) {
                                //     evidenceName.classList.toggle('selected_entity_temp')
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
        if (entityName.classList.contains('selected_entity_temp')) {
            // entityName.classList.remove('selected_entity_temp');
            oldEntity = entityName.getAttribute('data-entity-id');
            break;
        }
    }
    for (const evidenceName of document.querySelectorAll<HTMLLabelElement>('.evidence_name')) {
        if (evidenceName.classList.contains('selected_entity_temp') ) {
            evidenceName.classList.remove('selected_entity_temp');
            evidenceName.querySelector('img').classList.remove('selected_evidence_temp');
        }
    }
    document.querySelectorAll<HTMLElement>('.selected_entity_temp').forEach(element => {
        element.classList.remove('selected_entity_temp');
    });
    return oldEntity;
}

window.addEventListener('load', () => {
    document.querySelectorAll('.js-entity').forEach(entity => {
        entity.addEventListener('click', entityEvidences);
    });
});