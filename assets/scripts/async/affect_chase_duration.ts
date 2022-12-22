
interface ChaseDuration {
    chaseDuration: string,
    chaseDurationCursed: string
}

function affectChaseDuration(): void {
    const levelElement: HTMLSelectElement = document.querySelector('.js-sel-level');
    const mapElement: HTMLSelectElement = document.querySelector('.js-sel-map');
    if (levelElement && mapElement) {
        const data = {
            levelId: levelElement.value,
            mapId: mapElement.value
        }
        const url: string = '/investigation/chaseDuration/' + JSON.stringify(data);
        // axios.get(url).then(function (response) {
        //     document.querySelector('.js-durations').innerHTML =
        //         response.data['chaseDuration'] +
        //         ' [' + response.data['chaseDurationCursed'] + ']';
        // });
        fetch(url)
        .then(response => response.json() as Promise<ChaseDuration>)
        .then(function (data) {
            const spanDuration: HTMLSpanElement = document.querySelector('.js-durations');
            if (spanDuration) {
                spanDuration.innerHTML = data.chaseDuration + ' [' + data.chaseDurationCursed + ']';
            }
        });
    }
}

window.addEventListener('load', () => {
    affectChaseDuration();
    document.querySelectorAll('.js-select').forEach(selected => {
        selected.addEventListener('change', () => {
            affectChaseDuration();
        });
    });
});