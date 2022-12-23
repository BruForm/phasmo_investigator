import {color} from '../variables';

export class Timer {

    private btPause: HTMLButtonElement;
    private btStart: HTMLButtonElement;
    private timerHuntShape: HTMLElement;

    private min: HTMLSpanElement;
    private sec: HTMLSpanElement;
    private ms: HTMLSpanElement;

    private d0: Date;
    private pause: boolean = false;
    private start: boolean = false;
    private loop: NodeJS.Timer;
    private blink: NodeJS.Timer;

    constructor(private timerElement: HTMLDivElement) {

        this.btPause = this.timerElement.querySelector<HTMLButtonElement>('#pause');
        this.btStart = this.timerElement.querySelector<HTMLButtonElement>('#start');
        this.timerHuntShape = this.timerElement.querySelector<HTMLElement>('.display');

        this.min = this.timerElement.querySelector<HTMLSpanElement>('#min');
        this.sec = this.timerElement.querySelector<HTMLSpanElement>('#sec');
        this.ms = this.timerElement.querySelector<HTMLSpanElement>('#ms');
    }

    // DISPLAY ----------------------------------------------------------------------------------
    private display() {
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

        if (!this.start) {
            this.d0 = new Date;
            // this.loop = setInterval(this.display.bind(this), 1);
            // NB : Ci dessus besoin du .bind(this) pour fonctionner alors que pas avec la fonction fléchée ci dessous!!!
            this.loop = setInterval(() => {
                this.display()
            }, 1);
            this.btStart.innerText = 'STOP';
            this.start = true;
        } else {
            //stop
            clearInterval(this.loop);
            this.btStart.innerText = 'START';
            if (this.pause) {
                clearInterval(this.blink);
                this.btPause.style.color = color.light;
                this.timerHuntShape.style.color = color.light;
                this.pause = false;
            }
            this.start = false;
            // appel display() pour afficher le temps final
            this.display();
        }
    }

    // PAUSE ----------------------------------------------------------------------------------
    public timerPause() {
        if (this.start) {
            if (!this.pause) {
                clearInterval(this.loop);
                this.btPause.style.color = color.blood;
                this.timerHuntShape.style.color = color.blood;
                let $i: boolean = false;
                this.blink = setInterval(() => {
                    if ($i) {
                        this.btPause.style.color = color.blood;
                        this.timerHuntShape.style.color = color.blood;
                    } else {
                        this.btPause.style.color = color.light;
                        this.timerHuntShape.style.color = color.light;
                    }
                    $i = !$i;
                }, 500);
                this.pause = true;
            } else {
                this.loop = setInterval(() => {
                    this.display();
                }, 1);
                clearInterval(this.blink);
                this.btPause.style.color = color.light;
                this.timerHuntShape.style.color = color.light;
                this.pause = false;
            }
        }
    }

    // RESET ----------------------------------------------------------------------------------
    public timerReset() {
        clearInterval(this.loop);
        this.btStart.innerText = 'START';
        if (this.pause) {
            clearInterval(this.blink);
            this.btPause.style.color = color.light;
        }
        this.ms.innerText = '000';
        this.sec.innerText = '00';
        this.min.innerText = '00';
        this.start = false;
        this.pause = false;
    }
}
