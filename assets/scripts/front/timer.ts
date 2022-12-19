import {Timer} from './Models/Timer';

const timerHuntElement = document.querySelector<HTMLDivElement>('.timer_hunt');
const timerSmudgeElement = document.querySelector<HTMLDivElement>('.timer_smudge');

if (timerHuntElement && timerSmudgeElement) {
    const timerHunt = new Timer(timerHuntElement);
    const timerSmudge = new Timer(timerSmudgeElement);

// START/STOP SUR "FLECHE HAUTE" "FLECHE BASSE"
    document.addEventListener('keydown', function (event) {
        if (event.key === 'ArrowUp') {
            timerHunt.timerStartStop();
        }
        if (event.key === 'ArrowDown') {
            timerSmudge.timerStartStop();
        }
    });
// START/STOP SUR BOUTON
    if (timerHuntElement && timerSmudgeElement) {
        timerHuntElement.querySelector<HTMLButtonElement>('#start').onclick = function () {
            timerHunt.timerStartStop()
        };
        timerSmudgeElement.querySelector<HTMLButtonElement>('#start').onclick = function () {
            timerSmudge.timerStartStop()
        };
// START/STOP SUR CHRONO
        timerHuntElement.querySelector<HTMLElement>('.display').onclick = function () {
            timerHunt.timerStartStop()
        };
        timerSmudgeElement.querySelector<HTMLElement>('.display').onclick = function () {
            timerSmudge.timerStartStop()
        };
    }
// PAUSE SUR "FLECHE DROITE" "FLECHE GAUCHE"
    document.addEventListener('keydown', function (event) {
        if (event.key === 'ArrowRight') {
            timerHunt.timerPause();
            // event.preventDefault();
        }
        if (event.key === 'ArrowLeft') {
            timerSmudge.timerPause();
            // event.preventDefault();
        }
    });
// PAUSE SUR BOUTON
    timerHuntElement.querySelector<HTMLButtonElement>('#pause').onclick = function () {
        timerHunt.timerPause();
    };
    timerSmudgeElement.querySelector<HTMLButtonElement>('#pause').onclick = function () {
        timerSmudge.timerPause();
    };

// RESET SUR BOUTON
    timerHuntElement.querySelector<HTMLButtonElement>('#reset').onclick = function () {
        timerHunt.timerReset();
    };
    timerSmudgeElement.querySelector<HTMLButtonElement>('#reset').onclick = function () {
        timerSmudge.timerReset();
    };
}
// ----------------------------------------------------------------------------------


// ---------------------------------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------
// VERSION SANS L'OBJET Timer ------------------------------------------------------------------------------------
// ---------------------------------------------------------------------------------------------------------------

// const chronoHunt = document.querySelector<HTMLDivElement>('.chrono_hunt');
// const btPause = chronoHunt.querySelector<HTMLButtonElement>('#pause');
// const btStart = chronoHunt.querySelector<HTMLButtonElement>('#start');
// const btReset = chronoHunt.querySelector<HTMLButtonElement>('#reset');
// const chronoHuntShape = chronoHunt.querySelector<HTMLElement>('.display');
// const min = chronoHunt.querySelector<HTMLSpanElement>('#min');
// const sec = chronoHunt.querySelector<HTMLSpanElement>('#sec');
// const ms = chronoHunt.querySelector<HTMLSpanElement>('#ms');
// let pause: boolean = false;
// let start: boolean = false;
// let d: Date;
// let d0: Date;
// let time: number;
// let msX: number;
// let minSecX: number;
// let minX: number;
// let secX: number;
// let go;
// let blink1;
// let blink2;
//
// function dateStart() {
//     d0 = new Date();
// }
//
// // CHRONO ----------------------------------------------------------------------------------
// function chrono() {
//     d = new Date();
//     time = d.valueOf() - d0.valueOf();
//     msX = Number(time
//         .toString()
//         .substring(time.toString().length - 3, time.toString().length));
//     minSecX = Number(time
//         .toString()
//         .substring(0, time.toString().length - 3));
//
//     if (msX === 0) {
//         ms.innerText = '000';
//     } else {
//         if (msX < 10) {
//             ms.innerText = '00' + msX;
//         } else if (msX < 100) {
//             ms.innerText = '0' + msX;
//         } else {
//             ms.innerText = msX.toString();
//         }
//     }
//
//     secX = minSecX % 60;
//     minX = Math.floor(minSecX / 60) % 60;
//     if (secX === 0) {
//         sec.innerText = '00';
//     } else {
//         if (secX < 10) {
//             sec.innerText = '0' + secX;
//         } else {
//             sec.innerText = secX.toString();
//         }
//     }
//     if (minX === 0) {
//         min.innerText = '00';
//     } else {
//         if (minX < 10) {
//             min.innerText = '0' + minX;
//         } else {
//             min.innerText = minX.toString();
//         }
//     }
// }
//
// // START/STOP ----------------------------------------------------------------------------------
// function chronoStartStop() {
//
//     if (!start) {
//         dateStart();
//         go = setInterval(chrono, 1);
//         chrono();
//         btStart.innerText = 'STOP';
//         start = true;
//     } else {
//         //stop
//         clearInterval(go);
//         btStart.innerText = 'START';
//         if (pause) {
//             clearInterval(blink1);
//             clearInterval(blink2);
//             btPause.style.color = color.light;
//             chronoHuntShape.style.color = color.light;
//             pause = false;
//         }
//         start = false;
//         // appel chrono() pour afficher le temps final
//         chrono();
//     }
// }
//
// // START/STOP SUR "FLECHE HAUTE"
// document.addEventListener('keydown', function (event) {
//     if (event.key === 'ArrowUp') {
//         chronoStartStop();
//         // event.preventDefault();
//     }
// });
// // START/STOP SUR BOUTON
// btStart.onclick = function () {
//     chronoStartStop()
// };
// // START/STOP SUR CHRONO
// chronoHuntShape.onclick = function () {
//     chronoStartStop()
// };
//
// // PAUSE ----------------------------------------------------------------------------------
// function chronoPause() {
//     if (start) {
//         if (!pause) {
//             clearInterval(go);
//             blink1 = setInterval(function () {
//                 btPause.style.color = color.blood;
//                 chronoHuntShape.style.color = color.blood;
//             }, 500);
//             blink2 = setInterval(function () {
//                 btPause.style.color = color.light;
//                 chronoHuntShape.style.color = color.light;
//             }, 1000);
//             pause = true;
//         } else {
//             go = setInterval(chrono, 1);
//             clearInterval(blink1);
//             clearInterval(blink2);
//             btPause.style.color = color.light;
//             chronoHuntShape.style.color = color.light;
//             pause = false;
//         }
//     }
// }
//
// // PAUSE SUR "FLECHE DROITE"
// document.addEventListener('keydown', function (event) {
//     if (event.key === 'ArrowRight') {
//         chronoPause();
//         // event.preventDefault();
//     }
// });
// // PAUSE SUR BOUTON
// btPause.onclick = function () {
//     chronoPause();
// };
//
// // RESET ----------------------------------------------------------------------------------
// function chronoReset() {
//     clearInterval(go);
//     btStart.innerText = 'START';
//     if (pause) {
//         clearInterval(blink1);
//         clearInterval(blink2);
//         btPause.style.color = color.light;
//     }
//     ms.innerText = '000';
//     sec.innerText = '00';
//     min.innerText = '00';
//     start = false;
//     pause = false;
// }
//
// // RESET SUR BOUTON
// btReset.onclick = function () {
//     chronoReset();
// };
//
// ----------------------------------------------------------------------------------