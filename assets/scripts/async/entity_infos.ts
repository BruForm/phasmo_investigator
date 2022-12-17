import {getEntityInfos} from "./shared_functions";

function displayEntity(): void {
    if ((this.classList.contains('js-possible')
        && !this.classList.contains('selected_entity_temp'))
        || this.classList.contains('js-btn-disp')) {
        const data = {
            'id': this.getAttribute('data-entity-id'),
        }
        getEntityInfos(data);
    }
}

if (document.location.pathname === '/investigation') {
    window.addEventListener('load', () => {
        // Load of center entity information
        const current_id: number = Number(document.querySelector('.js-possible').getAttribute('data-entity-id'))
        getEntityInfos({'id': current_id});

        // Load of center entity information on prev/next button click
        document.querySelectorAll('.js-btn-disp').forEach(button => {
            button.addEventListener("click", displayEntity);
        })

        // Load of center entity information on possible entity click
        document.querySelectorAll('.js-entity').forEach(entity => {
            entity.addEventListener("click", displayEntity);
        })
    });
}