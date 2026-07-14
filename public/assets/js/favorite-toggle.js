/**
 * Favorite Toggle – AJAX heart button for stay cards
 * Requires: SweetAlert2 (Swal) loaded globally
 */
(function () {
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('.js-skoglar-card-heart');
    if (!btn) return;

    const stayId = btn.dataset.stayId;
    if (!stayId) return;

    e.preventDefault();
    e.stopPropagation();

    // Disable button and show loading
    btn.disabled = true;
    btn.style.opacity = '0.5';
    btn.style.pointerEvents = 'none';

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    fetch('/favourites/toggle/' + stayId, {
      method: 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': csrfToken,
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify({}),
    })
      .then(function (res) {
        if (res.status === 401) {
          // Not logged in
          return Promise.reject({ login: true });
        }
        if (res.status === 403) {
          return Promise.reject({ message: 'Only customers can add favorites.' });
        }
        
        const contentType = res.headers.get("content-type");
        if (!contentType || !contentType.includes("application/json")) {
           // Probably a redirect to login or an HTML error page
           if (res.redirected || res.status === 419 || res.status === 200) {
               return Promise.reject({ login: true });
           }
           return Promise.reject({ message: 'Unexpected HTML response from server.' });
        }

        if (!res.ok) {
          return res.json().then(function (d) { return Promise.reject(d); });
        }
        return res.json();
      })
      .then(function (data) {
        btn.disabled = false;
        btn.style.opacity = '';
        btn.style.pointerEvents = '';

        if (data.success) {
          const isFav = data.isFavorite;

          // Sync ALL heart buttons on the page with this stay ID (popup + listing cards)
          document.querySelectorAll('[data-stay-id="' + stayId + '"]').forEach(function (heartBtn) {
            const heartPath = heartBtn.querySelector('path');
            heartBtn.setAttribute('aria-pressed', isFav ? 'true' : 'false');
            if (isFav) {
              heartBtn.classList.remove('bg-black/20');
              // heartBtn.classList.add('bg-[#53635A]');
              if (heartPath) heartPath.setAttribute('fill', 'currentColor');
            } else {
              heartBtn.classList.remove('bg-[#53635A]');
              // heartBtn.classList.add('bg-black/20');
              if (heartPath) heartPath.setAttribute('fill', 'none');
            }
          });
        }
      })
      .catch(function (err) {
        btn.disabled = false;
        btn.style.opacity = '';
        btn.style.pointerEvents = '';

        if (err && err.login) {
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              icon: 'info',
              title: 'Login Required',
              text: 'Please log in to add stays to your favorites.',
              confirmButtonText: 'Log In',
              confirmButtonColor: '#53635A',
              showCancelButton: true,
            }).then(function (result) {
              if (result.isConfirmed) {
                window.location.href = '/login';
              }
            });
          } else {
            alert('Please log in to add stays to your favorites.');
          }
          return;
        }

        var msg = (err && err.message) ? err.message : 'Something went wrong. Please try again.';
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: msg,
            confirmButtonColor: '#53635A',
          });
        } else {
          alert(msg);
        }
      });
  });
})();
