import {color} from './variables';

const chronoHuntElement = document.querySelector<HTMLDivElement>('.chrono_hunt');
const chronoSmudgeElement = document.querySelector<HTMLDivElement>('.chrono_smudge');
const btPause = chronoHunt.querySelector<HTMLButtonElement>('#pause');
const btStart = chronoHunt.querySelector<HTMLButtonElement>('#start');
const btReset = chronoHunt.querySelector<HTMLButtonElement>('#reset');
const chronoHuntShape = chronoHunt.querySelector<HTMLElement>('.display');
const min = chronoHunt.querySelector<HTMLSpanElement>('#min');
const sec = chronoHunt.querySelector<HTMLSpanElement>('#sec');
const ms = chronoHunt.querySelector<HTMLSpanElement>('#ms');
let pause: boolean = false;
let start: boolean = false;
// let d: Date;
// let d0: Date;
// let time: number;
// let msX: number;
// let minSecX: number;
// let minX: number;
// let secX: number;
let go;
let blink1;
let blink2;

// CHRONO ----------------------------------------------------------------------------------
function Chrono(chronoElement: HTMLDivElement, d0: Date) {
    this.chronoElement = chronoElement;
    this.d0 = d0;

    let d: Date = new Date();
    let time: number = d.valueOf() - this.d0.valueOf();
    let msX: number = Number(time
        .toString()
        .substring(time.toString().length - 3, time.toString().length));
    let minSecX: number= Number(time
        .toString()
        .substring(0, time.toString().length - 3));

    const ms = this.chronoElement.querySelector('#ms');
    if (msX === 0) {
        ms.innerText = '000';
    } else {
        if (msX < 10) {
            ms.innerText = '00' + msX;
        } else if (msX < 100) {
            ms.innerText = '0' + msX;
        } else {
            ms.innerText = msX.toString();
        }
    }

    let secX: number = minSecX % 60;
    let minX: number = Math.floor(minSecX / 60) % 60;

    const sec = this.chronoElement.querySelector('#sec');
    if (secX === 0) {
        sec.innerText = '00';
    } else {
        if (secX < 10) {
            sec.innerText = '0' + secX;
        } else {
            sec.innerText = secX.toString();
        }
    }

    const min = this.chronoElement.querySelector('#min');
    if (minX === 0) {
        min.innerText = '00';
    } else {
        if (minX < 10) {
            min.innerText = '0' + minX;
        } else {
            min.innerText = minX.toString();
        }
    }
}


// START/STOP ----------------------------------------------------------------------------------
function chronoStartStop(choice: HTMLDivElement) {

    const btPause = choice.querySelector<HTMLButtonElement>('#pause');
    const btStart = choice.querySelector<HTMLButtonElement>('#start');
    const chronoHuntShape = choice.querySelector<HTMLElement>('.display');
    const min = choice.querySelector<HTMLSpanElement>('#min');
    const sec = choice.querySelector<HTMLSpanElement>('#sec');
    const ms = choice.querySelector<HTMLSpanElement>('#ms');

    let d0: Date;
    if (!start) {
        d0 = new Date();
        go = setInterval(chrono, 1, d0);
        btStart.innerText = 'STOP';
        start = true;
    } else {
        //stop
        clearInterval(go);
        btStart.innerText = 'START';
        if (pause) {
            clearInterval(blink1);
            clearInterval(blink2);
            btPause.style.color = color.light;
            chronoHuntShape.style.color = color.light;
            pause = false;
        }
        start = false;
        // appel chrono() pour afficher le temps final
        if (d0) chrono(d0);
    }
}

// START/STOP SUR "FLECHE HAUTE"
document.addEventListener('keydown', function (event) {
    if (event.key === 'ArrowUp') {
        const chronoHunt = new Chrono(chronoHuntElement, new Date);
        chronoHunt.chronoStartStop();
    }
    if (event.key === 'ArrowDown') {
        const chronoSmudge = new Chrono(chronoSmudgeElement, new Date);
        chronoSmudge.chronoStartStop();

    }
});
// START/STOP SUR BOUTON
btStart.onclick = function () {
    chronoStartStop(chronoHunt)
};
// START/STOP SUR CHRONO
chronoHuntShape.onclick = function () {
    chronoStartStop(chronoHunt)
};

// PAUSE ----------------------------------------------------------------------------------
function chronoPause() {
    if (start) {
        if (!pause) {
            clearInterval(go);
            blink1 = setInterval(function () {
                btPause.style.color = color.blood;
                chronoHuntShape.style.color = color.blood;
            }, 500);
            blink2 = setInterval(function () {
                btPause.style.color = color.light;
                chronoHuntShape.style.color = color.light;
            }, 1000);
            pause = true;
        } else {
            go = setInterval(chrono, 1);
            clearInterval(blink1);
            clearInterval(blink2);
            btPause.style.color = color.light;
            chronoHuntShape.style.color = color.light;
            pause = false;
        }
    }
}

// PAUSE SUR "FLECHE DROITE"
document.addEventListener('keydown', function (event) {
    if (event.key === 'ArrowRight') {
        chronoPause();
        // event.preventDefault();
    }
});
// PAUSE SUR BOUTON
btPause.onclick = function () {
    chronoPause();
};

// RESET ----------------------------------------------------------------------------------
function chronoReset() {
    clearInterval(go);
    btStart.innerText = 'START';
    if (pause) {
        clearInterval(blink1);
        clearInterval(blink2);
        btPause.style.color = color.light;
    }
    ms.innerText = '000';
    sec.innerText = '00';
    min.innerText = '00';
    start = false;
    pause = false;
}

// RESET SUR BOUTON
btReset.onclick = function () {
    chronoReset();
};

// ----------------------------------------------------------------------------------