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

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-menu-toggle]').forEach((toggle) => {
        toggle.addEventListener('click', () => {
            const menu = document.querySelector(toggle.dataset.menuToggle);

            if (!menu) {
                return;
            }

            const isOpen = menu.classList.toggle('show');
            toggle.setAttribute('aria-expanded', String(isOpen));
        });
    });

    const menuItems = document.querySelectorAll('.app-menu-item');
    const panels = document.querySelectorAll('.app-panel-content');
    const title = document.getElementById('app-panel-title');

    const panelTitles = {
        home: 'Home',
        livros: 'Livros',
        autores: 'Autores',
        assuntos: 'Assuntos',
        relatorios: 'Relatórios'
    };

    menuItems.forEach((item) => {
        item.addEventListener('click', () => {
            const target = item.dataset.target;

            menuItems.forEach((button) => button.classList.toggle('active', button === item));
            panels.forEach((panel) => panel.classList.toggle('active', panel.dataset.panel === target));

            if (title && panelTitles[target]) {
                title.textContent = panelTitles[target];
            }
        });
    });
});
