document.addEventListener('DOMContentLoaded', function() {
    var downloadButton = document.querySelector('.wp-block-button__link');

    if (downloadButton) {
        downloadButton.setAttribute('href', siteData.pdfUrl);
        downloadButton.setAttribute('download', '');
    }
});

