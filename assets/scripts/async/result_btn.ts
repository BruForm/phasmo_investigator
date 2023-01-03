import {displayPopup} from "./shared_functions";

//status : 1 OK, 2 KO, 3 warning
interface EndGame {
    status: number,
    message: string,
}

function checkSelection(): boolean {
    const entity_selected = document.querySelector<HTMLSpanElement>('.js-entity.selected_entity_temp');

    let $message: string;
    if (entity_selected == null) {
        $message = "Attention ! Vous n'avez pas selectionné d'Entité.";
        displayPopup($message);
        return false;
    } else {
        if (!entity_selected.classList.contains('js-possible')) {
            $message = "Attention ! L'Entité sélectionnée n'est pas compatible avec les preuves sélectionnées.";
            displayPopup($message);
            return false;
        }
        return true;
    }
}

function investigationResult(): void {
    if (checkSelection()) {
        const endGameZone = document.querySelector<HTMLDivElement>('.end_game_zone');

        // Affichage de la popup de validation
        endGameZone.setAttribute('open', '');

        const entity_selected = document.querySelector<HTMLSpanElement>('.js-entity.selected_entity_temp');
        endGameZone.querySelector<HTMLSpanElement>('.selected_entity span').innerText = entity_selected.innerText;
        endGameZone.querySelectorAll<HTMLOptionElement>('option').forEach(option => {
            if (option.value === entity_selected.getAttribute('data-entity-id')) {
                option.setAttribute('selected', '');
            }
        });

        endGameZone.querySelector('.buttons .js-ok').addEventListener('click', () => {

            const entityId: string = endGameZone.querySelector<HTMLOptionElement>('option:checked').value;
            const chosenEntityId: string = entity_selected.getAttribute('data-entity-id');
            const result: string = (entityId === chosenEntityId) ? 'success' : 'fail';

            const data = {
                result,
                'player': document.querySelector<HTMLSpanElement>('.userName').innerText,
                'mapId': document.querySelector<HTMLOptionElement>('.js-sel-map option:checked').value,
                'levelId': document.querySelector<HTMLOptionElement>('.js-sel-level option:checked').value,
                entityId,
                chosenEntityId,
            }
            const url: string = '/investigation/endGame/' + JSON.stringify(data);
            fetch(url)
                .then(response => response.json() as Promise<EndGame>)
                .then(function (data) {
                    if (data.status === 1) {
                        endGameZone.removeAttribute('open');
                        // location.assign('/');
                        displayPopup(data.message);
                    }
                });
        }, {once: true});

        endGameZone.querySelector('.buttons .js-cancel').addEventListener('click', () => {
            // Masquage de la popup de validation
            endGameZone.removeAttribute('open');
        }, {once: true});
    }
}

if (document.location.pathname === '/investigation') {
    const result_btn = document.querySelector<HTMLDivElement>('.result_btn_zone');

    result_btn.addEventListener('click', investigationResult);
}