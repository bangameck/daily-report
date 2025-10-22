import './bootstrap';

import 'flowbite';

//flatpickr setup with Indonesian locale
import flatpickr from 'flatpickr';
import { Indonesian } from 'flatpickr/dist/l10n/id.js';
window.flatpickr = flatpickr;
flatpickr.localize(Indonesian);

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
