export default function handleNewsletterForm() { 
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form.newsletter-form');
        if (!form) return;
    
        form.addEventListener('submit', function (e) {
            e.preventDefault();
    
            const formData = new FormData(form);
            const messageBox = form.querySelector('.newsletter-message') || document.createElement('div');
            messageBox.className = 'newsletter-message';
            messageBox.textContent = 'Wysyłanie...';
            form.appendChild(messageBox);
    
            fetch(ajaxurl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams([...formData, ['action', 'newsletter_subscribe']])
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    messageBox.textContent = data.data.message;
                    form.reset();
                } else {
                    messageBox.textContent = data.data.message;
                }
            })
            .catch(() => {
                messageBox.textContent = 'Wystąpił błąd. Spróbuj ponownie.';
            });
        });
    }); 
}

