import './stimulus_bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

const formatCurrencyInput = (input) => {
    const digits = input.value.replace(/\D/g, '');

    if (!digits) {
        input.value = '';
        return;
    }

    const cents = digits.padStart(3, '0');
    const integerPart = cents.slice(0, -2);
    const decimalPart = cents.slice(-2);
    const formattedInteger = Number(integerPart).toLocaleString('pt-BR');

    input.value = `${formattedInteger},${decimalPart}`;
};

document.addEventListener('input', (event) => {
    if (event.target instanceof HTMLInputElement && event.target.matches('[data-currency-mask]')) {
        formatCurrencyInput(event.target);
    }
});
