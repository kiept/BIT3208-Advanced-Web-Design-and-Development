document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    if (!form) return;

    form.addEventListener('submit', (event) => {
        const title = form.querySelector('input[name="title"]');
        if (title && title.value.trim() === '') {
            event.preventDefault();
            alert('Please add a game title before saving.');
        }
    });
});
