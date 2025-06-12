export default function initFilePreview() {
    const fileInput = document.getElementById('files');
    const previewContainer = document.getElementById('file-preview');
    const allowedTypes = [
        'image/jpeg', 'image/png', 'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];
    const maxSize = 2 * 1024 * 1024; // 2MB

    if (fileInput) {
        fileInput.addEventListener('change', () => {
            previewContainer.innerHTML = '';

            Array.from(fileInput.files).forEach(file => {
                if (!allowedTypes.includes(file.type)) {
                    alert(`${file.name} is not an allowed file type.`);
                    return;
                }
                if (file.size > maxSize) {
                    alert(`${file.name} exceeds the 2MB size limit.`);
                    return;
                }

                const previewElement = file.type.startsWith('image/')
                    ? document.createElement('img')
                    : document.createElement('span');

                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        previewElement.src = e.target.result;
                        previewElement.className = 'img-thumbnail me-2 mb-2';
                        previewElement.style.maxWidth = '100px';
                        previewContainer.appendChild(previewElement);
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewElement.className = 'badge bg-secondary me-2 mb-2';
                    previewElement.textContent = file.name;
                    previewContainer.appendChild(previewElement);
                }
            });
        });
    }
}
