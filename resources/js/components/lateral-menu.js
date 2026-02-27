document.addEventListener('DOMContentLoaded', () => {
  const btnNav = document.getElementById('btn-nav');
  const sidebar = document.querySelector('.sidebar');

  if (btnNav && sidebar) {
    btnNav.addEventListener('change', function () {
      if (this.checked) {
        sidebar.classList.add('active');
      } else {
        sidebar.classList.remove('active');
      }
    });
  }
});
