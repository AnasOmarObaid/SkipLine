<script>
// Real-time preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('productForm');
    const inputs = form.querySelectorAll('input, textarea, select');

    // Add event listeners to all form inputs
    inputs.forEach(input => {
        input.addEventListener('input', updatePreview);
        input.addEventListener('change', updatePreview);
    });

    // Image upload handling
    const imageInput = document.getElementById('image');
    const imageUploadZone = document.querySelector('.image-upload-zone');

    imageInput.addEventListener('change', handleImageUpload);

    // Drag and drop functionality
    imageUploadZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        imageUploadZone.classList.add('dragover');
    });

    imageUploadZone.addEventListener('dragleave', () => {
        imageUploadZone.classList.remove('dragover');
    });

    imageUploadZone.addEventListener('drop', (e) => {
        e.preventDefault();
        imageUploadZone.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            handleImageUpload();
        }
    });

    // Initial preview update
    updatePreview();
});

function updatePreview() {
    // Get form values
    const nameEn = document.getElementById('name_en').value || '{{ __('app.product_name_placeholder') }}';
    const nameAr = document.getElementById('name_ar').value || 'اسم المنتج';
    const price = document.getElementById('price').value || '0.00';
    const salePrice = document.getElementById('sale_price').value;
    const stock = document.getElementById('stock').value || '0';
    const sku = document.getElementById('sku').value || '-';
    const unitEn = document.getElementById('unit_en').value || '-';
    const descriptionEn = document.getElementById('description_en').value || '{{ __('app.product_description_placeholder') }}';
    const rate = document.getElementById('rate').value || '3';
    const isActive = document.getElementById('is_active').checked;

    // Update preview elements
    document.getElementById('preview-name').textContent = nameEn;
    document.getElementById('preview-description').textContent = descriptionEn;
    document.getElementById('preview-sku').textContent = `{{ __('app.sku_label') }}: ${sku}`;
    document.getElementById('preview-stock').textContent = `{{ __('app.stock_label') }}: ${stock}`;
    document.getElementById('preview-unit').textContent = `{{ __('app.unit_label') }}: ${unitEn}`;

    // Update price display
    const priceElement = document.getElementById('preview-price');
    if (salePrice && parseFloat(salePrice) < parseFloat(price)) {
        priceElement.innerHTML = `$${salePrice} <small style="text-decoration: line-through; opacity: 0.7;">$${price}</small>`;
    } else {
        priceElement.textContent = `$${price}`;
    }

    // Update rating
    const ratingElement = document.getElementById('preview-rating');
    const stars = '⭐'.repeat(parseInt(rate));
    ratingElement.textContent = stars;

    // Update status
    const statusElement = document.getElementById('preview-status');
    if (isActive) {
        statusElement.innerHTML = '<span class="badge bg-success">Active</span>';
    } else {
        statusElement.innerHTML = '<span class="badge bg-danger">Inactive</span>';
    }

    // Add animation
    document.getElementById('product-preview').classList.add('fade-in');
}

function handleImageUpload() {
    const file = document.getElementById('image').files[0];
    const placeholder = document.getElementById('image-placeholder');
    const previewContainer = document.getElementById('image-preview-container');
    const previewImage = document.getElementById('image-preview');
    const previewImageElement = document.getElementById('preview-image');

    if (file) {
        // Validate file size (5MB limit)
        if (file.size > 5 * 1024 * 1024) {
            alert('{{ __('app.file_size_limit') }}');
            return;
        }

        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('{{ __('app.select_valid_image') }}');
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewImageElement.innerHTML = `<img src="${e.target.result}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 1rem;" alt="Product">`;
            placeholder.style.display = 'none';
            previewContainer.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function removeImage(event) {
    event.preventDefault();
    event.stopPropagation();

    document.getElementById('image').value = '';
    document.getElementById('image-placeholder').style.display = 'block';
    document.getElementById('image-preview-container').style.display = 'none';
    document.getElementById('preview-image').innerHTML = '<i class="bi bi-box-seam"></i>';
}

function generatePreview() {
    updatePreview();
    document.getElementById('product-preview').classList.add('pulse');
    setTimeout(() => {
        document.getElementById('product-preview').classList.remove('pulse');
    }, 1000);
}

// Form submission with loading state
document.getElementById('productForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>{{ __('app.creating_product') }}';

    // Add loading overlay
    const overlay = document.createElement('div');
    overlay.className = 'spinner-overlay';
    overlay.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
    document.querySelector('.form-section').appendChild(overlay);
});
</script>
