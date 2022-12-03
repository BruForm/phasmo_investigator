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
            this.classList.toggle('bloody')
            const url: string = '/investigation/entityEvidences/' + JSON.stringify(data);
            fetch(url)
                .then(response => response.json() as Promise<Evidences>)
                .then(function (data) {
                    for (const evidenceName of document.querySelectorAll<HTMLSpanElement>('.evidence_name')) {
                        if (evidenceName) {
                            for (const name of data.evidenceNames) {
                                if (evidenceName.innerHTML == name) {
                                    evidenceName.classList.toggle('bloody')
                                }
                            }
                        }
                    }
                });
        }
    }
}

function entityEvidencesReset(): string {
    let oldEntity: string = "";
    for (const entityName of document.querySelectorAll<HTMLSpanElement>('.js-entity-id')) {
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

    document.querySelectorAll('.js-entity-id').forEach(selected => {
        selected.addEventListener('click', entityEvidences);
        // selected.addEventListener('mouseout', entityEvidencesReset);
    });
});