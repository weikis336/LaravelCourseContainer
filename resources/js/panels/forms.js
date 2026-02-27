export default (() => {
  const formSection = document.querySelector('.crud-form')

  // Reset del formulario
  document.addEventListener("refreshForm", event => {
    if (event.detail.form) {
      formSection.innerHTML = event.detail.form
    }
  })
  // Manejo de clics en botones
  formSection?.addEventListener('click', async (event) => {
    // Botón guardar (store-button)
    if (event.target.closest('.store-button')) {
      const storeButton = event.target.closest('.store-button')
      const endpoint = storeButton.dataset.endpoint
      const form = formSection.querySelector('form')
      const formData = new FormData(form)

      try {
        const response = await fetch(endpoint, {
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
          },
          method: 'POST',
          body: formData
        });

        if (response.status === 500 || response.status === 422) {
          throw response
        }

        if (response.status === 200) {
          const json = await response.json()

          // Actualiza todo el contenedor del formulario
          formSection.innerHTML = json.form;

          // Dispara eventos personalizados
          document.dispatchEvent(new CustomEvent('refreshTable', {
            detail: { table: json.table }
          }));

          document.dispatchEvent(new CustomEvent('notification', {
            detail: {
              message: json.message,
              type: 'success'
            }
          }))
        }
      } catch (error) {
        if (error.status === 422) {
          const json = await error.json();
          console.log(json)  
          const validationContainer = formSection.querySelector('.validation-errors');

          document.dispatchEvent(new CustomEvent('showformValidations', {
            detail: {
              formValidation: validationContainer,
              errors: json.errors
            }
          }));
        }

        if (error.status === 500) {
          const json = await error.json();
          document.dispatchEvent(new CustomEvent('notification', {
            detail: {
              message: json.message,
              type: 'error'
            }
          }));
        }
      }
    }

    // Botón reset/limpiar 
    if (event.target.closest('.reset-button')) {
      const resetButton = event.target.closest('.reset-button')
      const endpoint = resetButton.dataset.endpoint || '/admin/usuarios/create'

      try {
        const response = await fetch(endpoint, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
          },
          method: 'GET',
        })

        if (response.status === 500) {
          throw response;
        }

        if (response.status === 200) {
          const json = await response.json();

          document.dispatchEvent(new CustomEvent('reset-form', {
            detail: {
              form: json.form,
            }
          }))
        }
      } catch (error) {
        document.dispatchEvent(new CustomEvent('notification', {
          detail: {
            message: 'La acción no se pudo completar por un fallo en el servidor.',
            type: 'error'
          }
        }))
      }
    }
  })

  // Manejo de inputs range (si los tienes)
  formSection?.addEventListener('input', (event) => {
    if (event.target.matches('input[type="range"]')) {
      const inputRange = event.target;
      const rangeValue = inputRange.parentElement.querySelector('.range-value')

      if (rangeValue) {
        rangeValue.innerText = inputRange.value
      }
    }
  })
})()
