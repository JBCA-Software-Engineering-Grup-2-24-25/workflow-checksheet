import './bootstrap';

import Alpine from 'alpinejs';
import Choices from "choices.js";
import collapse from "@alpinejs/collapse";
import collect from "collect.js";
import Precognition from 'laravel-precognition-alpine';
import tippy from "tippy.js";

Alpine.plugin(Precognition);
Alpine.plugin(collapse);

window.Alpine = Alpine;
window.Choices = Choices;
window.collect = collect;
window.tippy = tippy;
window.debounce = (func, delay) => {
    let debounceTimer
    return function () {
        const context = this
        const args = arguments
        clearTimeout(debounceTimer)
        debounceTimer
            = setTimeout(() => func.apply(context, args), delay)
    }
};

Alpine.start();
