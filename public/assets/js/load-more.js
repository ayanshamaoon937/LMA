/**
 * Generic AJAX "Load More" handler for server-rendered paginated lists.
 * Guards against: double clicks, out-of-order responses (slow request
 * landing after a faster later one), and missing DOM nodes.
 */
function initLoadMore({ buttonId, containerId, wrapperId, onAppend }) {
    const btn = document.getElementById(buttonId);
    if (!btn) return;

    const container = document.getElementById(containerId);
    const wrapper = document.getElementById(wrapperId);
    let requestToken = 0;

    btn.addEventListener('click', async function () {
        if (btn.disabled) return;

        const page = btn.getAttribute('data-next-page');
        const search = btn.getAttribute('data-search') || '';
        const endpoint = btn.getAttribute('data-endpoint');
        const thisRequest = ++requestToken;

        btn.disabled = true;
        const originalText = btn.textContent;
        btn.textContent = 'Loading...';

        try {
            const params = new URLSearchParams({ page });
               if (search) params.append('search', search);
            const response = await fetch(`${endpoint}?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();

            // ignore stale responses if a newer request has since started
            if (thisRequest !== requestToken) return;

            if (data.html) {
                container.insertAdjacentHTML('beforeend', data.html);
                if (typeof onAppend === 'function') onAppend();
            }

            if (data.hasMore) {
                btn.setAttribute('data-next-page', data.nextPage);
                btn.disabled = false;
                btn.textContent = originalText;
            } else {
                wrapper.style.display = 'none';
            }
        } catch (error) {
            console.error(`Error loading more (${buttonId}):`, error);
            btn.disabled = false;
            btn.textContent = originalText;
        }
    });
}