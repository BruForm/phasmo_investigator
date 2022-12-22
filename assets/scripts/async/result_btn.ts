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

function investigationSuccess(): void {
    if (checkSelection()) {
        const entity_selected = document.querySelector<HTMLSpanElement>('.js-entity.selected_entity_temp');

        document.querySelector<HTMLDivElement>('.entity_information_zone').style.display = 'none';

        const endGameZone = document.querySelector<HTMLDivElement>('.end_game_zone');
        endGameZone.style.display = 'flex';

        endGameZone.querySelector<HTMLParagraphElement>('.selected_entity p').innerText = entity_selected.innerText;

        endGameZone.querySelectorAll<HTMLOptionElement>('option').forEach(option => {
            if (option.value === entity_selected.getAttribute('data-entity-id')) {
                option.selected = true;
            }
        });

        endGameZone.querySelector('.buttons .js-ok').addEventListener('click', () => {
            const data = {
                result: 'success',
                player: document.querySelector<HTMLSpanElement>('.userName').innerText,
                mapId: document.querySelector<HTMLOptionElement>('.js-sel-map option:checked').value,
                levelId: document.querySelector<HTMLOptionElement>('.js-sel-level option:checked').value,
                entityId: endGameZone.querySelector<HTMLOptionElement>('option:checked').value,
                chosenEntityId: entity_selected.getAttribute('data-entity-id'),
            }
            const url: string = '/investigation/endGame/' + JSON.stringify(data);
            fetch(url)
                .then(response => response.json() as Promise<EndGame>)
                .then(function (data) {
                    if (data.status === 1) {
                        displayPopup(data.message);
                    }
                });
        });

    }
}

function investigationFail(): void {
    console.log('FAIL');
}

if (document.location.pathname === '/investigation') {
    const result_btn = document.querySelector<HTMLDivElement>('.result_btn_zone');
    const btn_ok = result_btn.querySelector('.btn_ok');
    const btn_ko = result_btn.querySelector('.btn_ko');

    btn_ok.addEventListener('click', investigationSuccess);

    btn_ko.addEventListener('click', investigationFail);
}