// Confirmación de eliminación
document.addEventListener('DOMContentLoaded', function () {
    // Confirmación para enlaces de eliminación
    const deleteLinks = document.querySelectorAll('.delete-link');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            if (!confirm('¿Está seguro de que desea eliminar este registro?')) {
                e.preventDefault();
            }
        });
    });

    // Auto-ocultar alertas después de 5 segundos
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Validación en tiempo real para notas
    const notaInput = document.getElementById('valor');
    if (notaInput) {
        notaInput.addEventListener('input', function () {
            const valor = parseFloat(this.value);

            // Eliminar cualquier mensaje de error existente primero
            const existingFeedback = this.parentNode.querySelector('.invalid-feedback');
            if (existingFeedback) {
                existingFeedback.remove();
            }

            if (isNaN(valor) || valor < 0 || valor > 10) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');

                // Crear nuevo mensaje de error
                const div = document.createElement('div');
                div.className = 'invalid-feedback';
                div.textContent = 'La nota debe estar entre 0 y 10';
                this.parentNode.appendChild(div);
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    }

    // Animación de fade-in para elementos
    const fadeElements = document.querySelectorAll('.card, .table');
    fadeElements.forEach(element => {
        element.classList.add('fade-in');
    });
});

// Función para mostrar spinner de carga
function showLoading() {
    const spinner = document.createElement('div');
    spinner.className = 'spinner-overlay';
    spinner.innerHTML = '<div class="spinner-border text-light" role="status"><span class="visually-hidden">Cargando...</span></div>';
    document.body.appendChild(spinner);
}

// Función para ocultar spinner de carga
function hideLoading() {
    const spinner = document.querySelector('.spinner-overlay');
    if (spinner) {
        spinner.remove();
    }
}
