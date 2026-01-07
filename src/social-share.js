/**
 * Social Share Buttons Handler
 * Handles click events for social sharing buttons in the footer
 */

export default function handleSocialShare() {
  const shareButtons = document.querySelectorAll('[data-share]');

  if (!shareButtons.length) return;

  const pageUrl = encodeURIComponent(window.location.href);
  const pageTitle = encodeURIComponent(document.title);

  shareButtons.forEach((btn) => {
    btn.addEventListener('click', (e) => {
      const shareType = btn.dataset.share;
      let shareUrl = '';

      switch (shareType) {
        case 'facebook':
          shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${pageUrl}`;
          break;

        case 'messenger':
          shareUrl = `https://www.facebook.com/dialog/send?link=${pageUrl}&app_id=291494419107518&redirect_uri=${pageUrl}`;
          break;

        case 'twitter':
          shareUrl = `https://twitter.com/intent/tweet?url=${pageUrl}&text=${pageTitle}`;
          break;

        case 'email':
          shareUrl = `mailto:?subject=${pageTitle}&body=Sprawdź tę stronę: ${decodeURIComponent(pageUrl)}`;
          window.location.href = shareUrl;
          return;

        case 'copy':
          e.preventDefault();
          navigator.clipboard
            .writeText(window.location.href)
            .then(() => {
              btn.classList.add('copied');
              const originalText = btn.querySelector('span');
              const originalContent = originalText.textContent;
              originalText.textContent = 'Skopiowano!';

              setTimeout(() => {
                btn.classList.remove('copied');
                originalText.textContent = originalContent;
              }, 2000);
            })
            .catch((err) => {
              console.error('Failed to copy: ', err);
            });
          return;

        default:
          return;
      }

      // Prevent default link behavior for social shares
      if (shareType !== 'email') {
        e.preventDefault();
        // Open in a centered popup window
        const width = 600;
        const height = 400;
        const left = (window.innerWidth - width) / 2 + window.screenX;
        const top = (window.innerHeight - height) / 2 + window.screenY;

        window.open(
          shareUrl,
          'share',
          `width=${width},height=${height},left=${left},top=${top},menubar=no,toolbar=no,resizable=yes,scrollbars=yes`
        );
      }
    });
  });
}

