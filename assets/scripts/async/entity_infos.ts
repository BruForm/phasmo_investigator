interface Entity_Infos {
    id: number,
    name: string,
    special_move: string,
    smAttack: string,
    speed: string,
    stunSmudge: string,
    timeAttack: string,
    timeAttackSmudge: string,
}

function entityInfos(entityId: number): void {
    const data = {
        'id': entityId,
    }
    const url: string = '/investigation/entityInfos/' + JSON.stringify(data);
    fetch(url)
        .then(response => response.json() as Promise<Entity_Infos>)
        .then(function (data) {
            const infos = document.querySelector<HTMLDivElement>('.entity_infos');
            infos.querySelector<HTMLTitleElement>('.js-name').setAttribute('data-current-entity-id', String(data.id));
            infos.querySelector<HTMLTitleElement>('.js-name').innerText = data.name;
            infos.querySelector<HTMLTableCellElement>('.js-spe-mov').innerText = data.special_move;
            infos.querySelector<HTMLTableCellElement>('.js-sm_attack').innerText = data.smAttack;
            infos.querySelector<HTMLTableCellElement>('.js-speed').innerText = data.speed;
            infos.querySelector<HTMLTableCellElement>('.js-stun-smudge').innerText = data.stunSmudge;
            infos.querySelector<HTMLTableCellElement>('.js-time-attack').innerText = data.timeAttack;
            infos.querySelector<HTMLTableCellElement>('.js-time-attack-smudge').innerText = data.timeAttackSmudge;

        });

}

function labelingButtons(current_id: number) {
    let tab_nav = document.querySelectorAll<HTMLSpanElement>('.js-possible');
    let first_id: string = tab_nav[0].getAttribute('data-entity-id');
    let first_name: string = tab_nav[0].innerText;
    let last_id: string = tab_nav[tab_nav.length - 1].getAttribute('data-entity-id');
    let last_name: string = tab_nav[tab_nav.length - 1].innerText;

    let current = document.querySelector<HTMLSpanElement>('.js-possible[data-entity-id="'+ current_id +'"]');
    let next_id: string;
    let next_name: string;
    if (current.nextElementSibling) {
        next_id = current.nextElementSibling.getAttribute('data-entity-id');
        next_name = document.querySelector<HTMLSpanElement>('.js-possible[data-entity-id="' + next_id + '"]').innerText;
    } else {
        next_id = first_id;
        next_name = first_name;
    }
    document.querySelector<HTMLButtonElement>('.btn-next').innerText = next_name;
    document.querySelector<HTMLButtonElement>('.btn-next').setAttribute('data-next-id', next_id);

    let prev_id: string;
    let prev_name: string;
    if (current.previousElementSibling) {
        prev_id = current.previousElementSibling.getAttribute('data-entity-id');
        prev_name = document.querySelector<HTMLSpanElement>('.js-possible[data-entity-id="' + prev_id + '"]').innerText;
    } else {
        prev_id = last_id;
        prev_name = last_name;
    }
    document.querySelector<HTMLButtonElement>('.btn-prev').innerText = prev_name;
    document.querySelector<HTMLButtonElement>('.btn-prev').setAttribute('data-prev-id', next_id);
    document.querySelector<HTMLButtonElement>('.btn-next').innerText = next_name;
    document.querySelector<HTMLButtonElement>('.btn-next').setAttribute('data-next-id', prev_id);
}

window.addEventListener('load', () => {
    if (document.querySelector('.js-possible')) {
        let current_id: number = Number(document.querySelector('.js-possible').getAttribute('data-entity-id'));
        entityInfos(current_id);
        labelingButtons(current_id);

        // document.querySelectorAll('.js-evidence').forEach(evidence => {
        //         evidence.addEventListener("change", () => {
        //                 console.log(document.querySelector('.js-possible'));
        //                 current_id = Number(document.querySelector('.js-possible').getAttribute('data-entity-id'));
        //                 console.log(current_id);
        //                 entityInfos(current_id);
        //                 labelingButtons(current_id);
        //             }
        //         );
        //     }
        // )
    }

});

document.querySelectorAll('.js-evidence').forEach(evidence => {
        evidence.addEventListener("change", () => {
                console.log(document.querySelector('.js-possible'));
                let current_id = Number(document.querySelector('.js-possible').getAttribute('data-entity-id'));
                console.log(current_id);
                entityInfos(current_id);
                labelingButtons(current_id);
            }
        );
    }
);