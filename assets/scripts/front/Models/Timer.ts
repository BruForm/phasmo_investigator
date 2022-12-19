import {color} from '../variables';

export class Timer {

    // btPause: HTMLButtonElement;
    // btStart: HTMLButtonElement;
    // timerHuntShape: HTMLElement;

    private min: HTMLSpanElement;
    private sec: HTMLSpanElement;
    private ms: HTMLSpanElement;

    private d0: Date;
    private pause: boolean = false;
    private start: boolean = false;
    private loop: NodeJS.Timer;
    private blink1: NodeJS.Timer;
    private blink2: NodeJS.Timer;

    constructor(private timerElement: HTMLDivElement) {

        // this.btPause = this.timerElement.querySelector<HTMLButtonElement>('#pause');
        // this.btStart = this.timerElement.querySelector<HTMLButtonElement>('#start');
        // this.timerHuntShape = this.timerElement.querySelector<HTMLElement>('.display');

        this.min = this.timerElement.querySelector<HTMLSpanElement>('#min');
        this.sec = this.timerElement.querySelector<HTMLSpanElement>('#sec');
        this.ms = this.timerElement.querySelector<HTMLSpanElement>('#ms');
    }

    // DISPLAY ----------------------------------------------------------------------------------
    private display() {
        // const min = this.timerElement.querySelector<HTMLSpanElement>('#min');
        // const sec = this.timerElement.querySelector<HTMLSpanElement>('#sec');
        // const ms = this.timerElement.querySelector<HTMLSpanElement>('#ms');
        let d: Date;
        let time: number;
        let msX: number;
        let minSecX: number;
        let minX: number;
        let secX: number;

        d = new Date();
        time = d.valueOf() - this.d0.valueOf();
        msX = Number(time
            .toString()
            .substring(time.toString().length - 3, time.toString().length));
        minSecX = Number(time
            .toString()
            .substring(0, time.toString().length - 3));

        if (msX === 0) {
            this.ms.innerText = '000';
        } else {
            if (msX < 10) {
                this.ms.innerText = '00' + msX;
            } else if (msX < 100) {
                this.ms.innerText = '0' + msX;
            } else {
                this.ms.innerText = msX.toString();
            }
        }

        secX = minSecX % 60;
        minX = Math.floor(minSecX / 60) % 60;

        if (secX === 0) {
            this.sec.innerText = '00';
        } else {
            if (secX < 10) {
                this.sec.innerText = '0' + secX;
            } else {
                this.sec.innerText = secX.toString();
            }
        }

        if (minX === 0) {
            this.min.innerText = '00';
        } else {
            if (minX < 10) {
                this.min.innerText = '0' + minX;
            } else {
                this.min.innerText = minX.toString();
            }
        }
    }

    // START/STOP ----------------------------------------------------------------------------------
    public timerStartStop() {

        const btPause = this.timerElement.querySelector<HTMLButtonElement>('#pause');
        const btStart = this.timerElement.querySelector<HTMLButtonElement>('#start');
        const timerHuntShape = this.timerElement.querySelector<HTMLElement>('.display');

        if (!this.start) {
            this.d0 = new Date;
            this.loop = setInterval(this.display.bind(this), 100);
            btStart.innerText = 'STOP';
            this.start = true;
        } else {
            //stop
            clearInterval(this.loop);
            btStart.innerText = 'START';
            if (this.pause) {
                clearInterval(this.blink1);
                clearInterval(this.blink2);
                btPause.style.color = color.light;
                timerHuntShape.style.color = color.light;
                this.pause = false;
            }
            this.start = false;
            // appel display() pour afficher le temps final
            this.display();
        }
    }

    // PAUSE ----------------------------------------------------------------------------------
    public timerPause() {
        const btPause = this.timerElement.querySelector<HTMLButtonElement>('#pause');
        const timerHuntShape = this.timerElement.querySelector<HTMLElement>('.display');

        if (this.start) {
            if (!this.pause) {
                clearInterval(this.loop);
                this.blink1 = setInterval(function () {
                    btPause.style.color = color.blood;
                    timerHuntShape.style.color = color.blood;
                }, 500);
                this.blink2 = setInterval(function () {
                    btPause.style.color = color.light;
                    timerHuntShape.style.color = color.light;
                }, 1000);
                this.pause = true;
            } else {
                this.loop = setInterval(this.display.bind(this), 1);
                clearInterval(this.blink1);
                clearInterval(this.blink2);
                btPause.style.color = color.light;
                timerHuntShape.style.color = color.light;
                this.pause = false;
            }
        }
    }

    // RESET ----------------------------------------------------------------------------------
    public timerReset() {
        const btPause = this.timerElement.querySelector<HTMLButtonElement>('#pause');
        const btStart = this.timerElement.querySelector<HTMLButtonElement>('#start');
        // const min = this.timerElement.querySelector<HTMLSpanElement>('#min');
        // const sec = this.timerElement.querySelector<HTMLSpanElement>('#sec');
        // const ms = this.timerElement.querySelector<HTMLSpanElement>('#ms');

        clearInterval(this.loop);
        btStart.innerText = 'START';
        if (this.pause) {
            clearInterval(this.blink1);
            clearInterval(this.blink2);
            btPause.style.color = color.light;
        }
        this.ms.innerText = '000';
        this.sec.innerText = '00';
        this.min.innerText = '00';
        this.start = false;
        this.pause = false;
    }
}
