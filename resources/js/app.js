import './bootstrap';

import Alpine from 'alpinejs';

import 'flowbite';

//flatpickr setup with Indonesian locale
import flatpickr from 'flatpickr';
import { Indonesian } from 'flatpickr/dist/l10n/id.js';
window.flatpickr = flatpickr;
flatpickr.localize(Indonesian);
import TomSelect from 'tom-select';
window.TomSelect = TomSelect;


window.Alpine = Alpine;

Alpine.start();
