import {getEntityInfos} from "./shared_functions";

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

    if (i) {
        const url: string = '/investigation/evidenceEntities/' + JSON.stringify(data);
        fetch(url)
            .then(response => response.json() as Promise<Entities>)
            .then(function (data) {
                    for (const entityName of document.querySelectorAll<HTMLSpanElement>('.js-entity')) {
                        if (entityName) {
                            entityName.classList.add('bloody')
                            entityName.classList.remove('js-possible')
                            for (const name of data.entityNames) {
                                if (name == entityName.innerText) {
                                    entityName.classList.remove('bloody');
                                    entityName.classList.add('js-possible');

                                }
                            }
                        }
                    }
                    // Reload of center entity information
                    try {
                        const current_id: number = Number(document.querySelector('.js-possible').getAttribute('data-entity-id'));
                        entityInfos(current_id);
                    } catch (e) {
                        const popup = document.querySelector<HTMLDivElement>('.popup');
                        popup.querySelector<HTMLParagraphElement>('p').innerText = 'Attention ! Aucune Entité possible avec ces choix.';
                        popup.classList.add('visible');
                        popup.querySelector('.js-popup-ok').addEventListener('click', () => {
                            document.querySelector<HTMLDivElement>('.popup').classList.remove('visible');
                        })
                    }
                }
            )
        ;
    } else {
        for (const entityName of document.querySelectorAll<HTMLSpanElement>('.js-entity')) {
            entityName.classList.remove('bloody');
            entityName.classList.add('js-possible');
        }
        // Reload of center entity information
        const current_id: number = Number(document.querySelector('.js-possible').getAttribute('data-entity-id'));
        entityInfos(current_id);
    }
}

function entityInfos(entityId: number): void {
    const data = {
        'id': entityId,
    }
    getEntityInfos(data);
}

window.addEventListener('load', () => {
    document.querySelectorAll('.js-evidence').forEach(checkbox => {
        checkbox.addEventListener("change", evidenceEntities);
    });
});