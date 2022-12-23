import * as events from "events";

interface Entity_Infos {
    id: number,
    name: string,
    special_move: string,
    smAttack: string,
    speed: string,
    stunSmudge: string,
    timeAttack: string,
    timeAttackSmudge: string,
    skin_url: string,
}

// Récupération des informations d'une entité
/**
 *
 * @param data = {'id': entityId}
 */
export function getEntityInfos(data: object): void {
    const url: string = '/investigation/entityInfos/' + JSON.stringify(data);
    fetch(url)
        .then(response => response.json() as Promise<Entity_Infos>)
        .then(function (data) {
            // Change the picture
            document.querySelector<HTMLElement>('.entity_skin').style.backgroundImage =
                'url(build/assets/' + data.skin_url;
            // 'url(build/assets/images/skins_entities/skin' +
            // Math.floor(Math.random() * 11 + 1) +
            // '.webp)';

            const infos = document.querySelector<HTMLDivElement>('.entity_infos');
            infos.querySelector<HTMLTitleElement>('.js-name').setAttribute('data-current-entity-id', String(data.id));
            const nbChoice: number = document.querySelectorAll<HTMLSpanElement>('.js-possible').length;
            infos.querySelector<HTMLTitleElement>('.js-name').innerText = data.name + " /" + nbChoice;
            infos.querySelector<HTMLTableCellElement>('.js-spe-mov').innerText = data.special_move;
            infos.querySelector<HTMLTableCellElement>('.js-sm_attack').innerText = data.smAttack;
            infos.querySelector<HTMLTableCellElement>('.js-speed').innerText = data.speed;
            infos.querySelector<HTMLTableCellElement>('.js-stun-smudge').innerText = data.stunSmudge;
            infos.querySelector<HTMLTableCellElement>('.js-time-attack').innerText = data.timeAttack;
            infos.querySelector<HTMLTableCellElement>('.js-time-attack-smudge').innerText = data.timeAttackSmudge;

            labelingButtons(data.id);
        });
}

// Affectation du nom de l'entité aux bouttons suivante et précédente entité.
/**
 *
 * @param id = Entity.id
 */
function labelingButtons(id: number) {
    const tab_possible = document.querySelectorAll<HTMLSpanElement>('.js-possible');

    let prev_id: string;
    let prev_name: string;
    let next_id: string;
    let next_name: string;
    for (const key in tab_possible) {
        let ind: number = Number(key);
        if (Number(tab_possible[ind].getAttribute('data-entity-id')) === id) {
            prev_id = (ind === 0) ?
                tab_possible[tab_possible.length - 1].getAttribute('data-entity-id') :
                tab_possible[ind - 1].getAttribute('data-entity-id');
            prev_name = (ind === 0) ?
                tab_possible[tab_possible.length - 1].innerText :
                tab_possible[ind - 1].innerText;
            next_id = (ind === tab_possible.length - 1) ?
                tab_possible[0].getAttribute('data-entity-id') :
                tab_possible[ind + 1].getAttribute('data-entity-id');
            next_name = (ind === tab_possible.length - 1) ?
                tab_possible[0].innerText :
                tab_possible[ind + 1].innerText;
            break;
        }
    }

    if (Number(prev_id) != id && Number(prev_id) != Number(next_id)) {
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

// Affichage de la popup avec son message
/**
 *
 * @param message
 * @param cancelBtn => présence du bouton cancel
 */
export function displayPopup(message: string, cancelBtn: boolean = false) {
    const popup = document.querySelector<HTMLDialogElement>('.popup');
    if (!cancelBtn) {
        popup.querySelector<HTMLButtonElement>('.js-cancel').style.display = 'none';
    } else {
        popup.querySelector<HTMLButtonElement>('.js-cancel').style.display = 'block';
    }
    popup.querySelector<HTMLParagraphElement>('p').innerText = message;
    popup.setAttribute('open', '');

    // console.log(popup.getBoundingClientRect());
    // console.log(getOffset(popup).left);
    // console.log(getOffset(popup).top);

    // document.addEventListener('mousemove', e => {
    //     console.log(e.clientX + " : " + e.clientY);
    //     const x = e.clientX;
    //     const y = e.clientY;
    //
    //     if (x > popup.getBoundingClientRect().right) {
    //         console.log('error');
    //         document.addEventListener('click', () => {
    //             popupOk(document.querySelector<HTMLDivElement>('.popup'))
    //         });
    //     }
    // });
    popup.querySelector<HTMLButtonElement>('.js-ok').addEventListener('click', () => {
        popup.removeAttribute('open');
    })
    popup.querySelector<HTMLButtonElement>('.js-cancel').addEventListener('click', () => {
        popup.removeAttribute('open');
    })
}

// function popupOk(popup: HTMLDivElement) {
//     document.querySelector<HTMLDivElement>('.popup').classList.remove('visible');
// }

// function getOffset(el) {
//     const rect = el.getBoundingClientRect();
//     return {
//         left: rect.left + window.scrollX,
//         top: rect.top + window.scrollY
//     };
// }