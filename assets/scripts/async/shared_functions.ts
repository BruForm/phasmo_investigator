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

export function getEntityInfos(data: object): void {
    const url: string = '/investigation/entityInfos/' + JSON.stringify(data);
    fetch(url)
        .then(response => response.json() as Promise<Entity_Infos>)
        .then(function (data) {
            // Change the picture
            document.querySelector<HTMLElement>('.entity_skin').style.backgroundImage =
                'url(build/assets/images/skins_entities/skin' +
                Math.floor(Math.random() * 11 + 1) +
                '.webp)';

            const infos = document.querySelector<HTMLDivElement>('.entity_infos');
            infos.querySelector<HTMLTitleElement>('.js-name').setAttribute('data-current-entity-id', String(data.id));
            infos.querySelector<HTMLTitleElement>('.js-name').innerText = data.name;
            infos.querySelector<HTMLTableCellElement>('.js-spe-mov').innerText = data.special_move;
            infos.querySelector<HTMLTableCellElement>('.js-sm_attack').innerText = data.smAttack;
            infos.querySelector<HTMLTableCellElement>('.js-speed').innerText = data.speed;
            infos.querySelector<HTMLTableCellElement>('.js-stun-smudge').innerText = data.stunSmudge;
            infos.querySelector<HTMLTableCellElement>('.js-time-attack').innerText = data.timeAttack;
            infos.querySelector<HTMLTableCellElement>('.js-time-attack-smudge').innerText = data.timeAttackSmudge;

            labelingButtons(data.id);
        });
}

function labelingButtons(id: number) {
    const tab_nav = document.querySelectorAll<HTMLSpanElement>('.js-possible');
    let tab_id = [];
    document.querySelectorAll<HTMLSpanElement>('.js-possible').forEach(entity => {
        tab_id.push(entity.getAttribute('data-entity-id'));
        entity.innerText
    });

    let prev_id: string;
    let prev_name: string;
    let next_id: string;
    let next_name: string;
    for (const key in tab_id) {
        let ind: number = Number(key);
        if (Number(tab_id[ind]) === id) {
            prev_id = (ind === 0) ? tab_id[tab_id.length - 1] : tab_id[ind - 1];
            prev_name = (ind === 0) ? tab_nav[tab_id.length - 1].innerText : tab_nav[ind - 1].innerText;
            next_id = (ind === tab_id.length - 1) ? tab_id[0] : tab_id[ind + 1];
            next_name = (ind === tab_id.length - 1) ? tab_nav[0].innerText : tab_nav[ind + 1].innerText;
            break;
        }
    }
    if (Number(prev_id) != id) {
        document.querySelector<HTMLButtonElement>('.js-btn-prev').style.display = 'inline';
        document.querySelector<HTMLButtonElement>('.js-btn-prev').innerText = '< ' + prev_name;
        document.querySelector<HTMLButtonElement>('.js-btn-prev').setAttribute('data-entity-id', prev_id);
    } else {
        document.querySelector<HTMLButtonElement>('.js-btn-prev').style.display = 'none';
    }

    if (Number(next_id) != id) {
        document.querySelector<HTMLButtonElement>('.js-btn-next').style.display = 'inline';
        document.querySelector<HTMLButtonElement>('.js-btn-next').innerText = next_name + ' >';
        document.querySelector<HTMLButtonElement>('.js-btn-next').setAttribute('data-entity-id', next_id);
    } else {
        document.querySelector<HTMLButtonElement>('.js-btn-next').style.display = 'none';
    }
}
