const $selectPeriodInput = document.querySelector('.select-period-input');

$selectPeriodInput.addEventListener('change', () => {
    const UrlParams = new URLSearchParams(location.search);
    UrlParams.set('routeParams[period]', $selectPeriodInput.value);
    location.search = UrlParams.toString()
});