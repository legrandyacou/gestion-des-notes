
    const loader = document.getElementById('loader');

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', () => {
            loader?.classList.add('is-visible');
        });
    });

    document.querySelectorAll('a[href]').forEach((link) => {
        link.addEventListener('click', (event) => {
            if (
                event.defaultPrevented ||
                event.ctrlKey ||
                event.metaKey ||
                link.target === '_blank' ||
                link.getAttribute('href').startsWith('#')
            ) {
                return;
            }

            loader?.classList.add('is-visible');
        });
    });

    window.addEventListener('pageshow', () => {
        loader?.classList.remove('is-visible');
    });
