import './bootstrap';

import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowUp' || e.key === 'ArrowDown') {
                e.preventDefault();
                const step = e.key === 'ArrowUp' ? 1 : -1;
                const newValue = parseInt(this.value) + step;
                
                if (newValue >= parseInt(this.min) && 
                    newValue <= parseInt(this.max)) {
                    this.value = newValue;
                    this.dispatchEvent(new Event('input'));
                }
            }
        });
    });
});