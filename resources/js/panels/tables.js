export default (() => {

  const tableSection = document.querySelector('.crud-table');

  document.addEventListener("refreshTable", event => {
    tableSection.innerHTML = event.detail.table;
  })

  tableSection?.addEventListener('click', async (event) => {

    if (event.target.closest('.edit-button')) {

      const editButton = event.target.closest('.edit-button')
      const endpoint = editButton.dataset.endpoint
      console.log("clicked")
      console.log(endpoint)
      try {
        
        const response = await fetch(endpoint, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
          },
          method: 'GET',
        })

        if (response.status === 500) {
          throw response
        }

        if (response.status === 200) {

          const json = await response.json()

          document.dispatchEvent(new CustomEvent('refreshForm', {
            detail: {
              form: json.form,
            }
          }))
        }
      } catch (error) {

        const json = await error.json();

        document.dispatchEvent(new CustomEvent('notification', {
          detail: {
            message: json.message,
            type: 'error'
          }
        }))
      }
    }

    if (event.target.closest('.delete-button')) {

      const deleteButton = event.target.closest('.delete-button')
      const endpoint = deleteButton.dataset.endpoint

      // document.dispatchEvent(new CustomEvent('openModalDestroy', {
      //   detail: {
      //     endpoint: endpoint,
      //   }
      // }))
      const response = await fetch(endpoint, {
        method: 'DELETE',
        headers: {
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'X-Requested-With': 'XMLHttpRequest',
        },
      })

      if (response.status === 500) {
        throw response
      }

      if (response.status === 200) {
        console.log("eliminado")
        const json = await response.json()

        document.dispatchEvent(new CustomEvent('refreshTable', {
          detail: {
            table: json.table,
          }
        }));
      }
    }

    if (event.target.closest('.table-page-buttons')) {

      const paginationButton = event.target.closest('.table-page-button');

      if (paginationButton.classList.contains('inactive')) {
        return
      }

      try {

        let endpoint = paginationButton.dataset.pagination;

        const response = await fetch(endpoint, {
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
          },
          method: 'GET',
        })

        if (response.status === 500) {
          throw response
        }

        const json = await response.json();

        document.dispatchEvent(new CustomEvent('refreshTable', {
          detail: {
            table: json.table,
          }
        }));

      } catch (error) {

        const json = await error.json();

        document.dispatchEvent(new CustomEvent('notification', {
          detail: {
            message: json.message,
            type: 'error'
          }
        }))
      }
    }
  });
})();