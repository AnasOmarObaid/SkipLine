<script>
// Define constants with server data
const USER_DATA = {
    name: @json($user->name ?? ''),
    email: @json($user->email ?? ''),
    phone: @json($user->phone ?? ''),
    address: @json($user->address ?? ''),
    emailVerified: {{ $user->email_verified_at ? 'true' : 'false' }},
    imagePath: @json($user->image ? asset($user->getImagePath()) : ''),
    placeholderImage: 'https://placehold.co/120x120/0d6efd/ffffff?text=User'
};

const TRANSLATIONS = {
    verifyEmail: @json(__('app.verify_email')),
    unverified: @json(__('app.unverified')),
    updatingUser: @json(__('app.updating_user')),
    loading: @json(__('app.loading')),
    fileSizeLimit: @json(__('app.user_file_size_limit')),
    selectValidImage: @json(__('app.select_valid_image'))
};

// Real-time preview functionality for Edit User
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, setting up event listeners');

    const form = document.getElementById('userForm');
    if (!form) {
        console.error('Form not found!');
        return;
    }

    // Add event listeners to specific inputs
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const addressInput = document.getElementById('address');
    const validEmailInput = document.getElementById('validEmail');

    // Add event listeners
    if (nameInput) {
        nameInput.addEventListener('input', updatePreview);
        nameInput.addEventListener('keyup', updatePreview);
    }

    if (emailInput) {
        emailInput.addEventListener('input', updatePreview);
        emailInput.addEventListener('keyup', updatePreview);
    }

    if (phoneInput) {
        phoneInput.addEventListener('input', updatePreview);
        phoneInput.addEventListener('keyup', updatePreview);
    }

    if (addressInput) {
        addressInput.addEventListener('input', updatePreview);
        addressInput.addEventListener('keyup', updatePreview);
    }

    if (validEmailInput) {
        validEmailInput.addEventListener('change', updatePreview);
    }

    // Image upload handling
    const imageInput = document.getElementById('user_image');
    if (imageInput) {
        imageInput.addEventListener('change', handleImageUpload);
    }

    // Set initial state for image upload zone
    const existingImage = document.getElementById('image-preview');
    const uploadZone = document.getElementById('imageUploadZone');
    if (existingImage && existingImage.src && existingImage.src !== '' && !existingImage.src.includes('placehold.co')) {
        if (uploadZone) uploadZone.classList.add('has-image');
    }

    // Form submission with loading state
    if (form) {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>' + TRANSLATIONS.updatingUser + '...';

                // Add loading overlay
                const formSection = document.querySelector('.form-section');
                if (formSection) {
                    const overlay = document.createElement('div');
                    overlay.className = 'spinner-overlay';
                    overlay.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">' + TRANSLATIONS.loading + '...</span></div>';
                    formSection.appendChild(overlay);
                }
            }
        });
    }

    // Initial preview update
    setTimeout(updatePreview, 100);
});

function updatePreview() {
    console.log('updatePreview called');

    // Get form values
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const addressInput = document.getElementById('address');
    const validEmailInput = document.getElementById('validEmail');

    // Get current values or fallback to existing data
    const name = nameInput ? (nameInput.value || USER_DATA.name) : USER_DATA.name;
    const email = emailInput ? (emailInput.value || USER_DATA.email) : USER_DATA.email;
    const phone = phoneInput ? (phoneInput.value || USER_DATA.phone || '-') : (USER_DATA.phone || '-');
    const address = addressInput ? (addressInput.value || USER_DATA.address || '-') : (USER_DATA.address || '-');
    const isEmailValid = validEmailInput ? validEmailInput.checked : USER_DATA.emailVerified;

    console.log('Values:', { name, email, phone, address, isEmailValid });

    // Update preview elements
    const namePreview = document.getElementById('name_preview');
    const emailPreview = document.getElementById('email_preview');
    const phonePreview = document.getElementById('phone_preview');
    const addressPreview = document.getElementById('address_preview');
    const statusElement = document.getElementById('previewStatus');

    if (namePreview) {
        namePreview.textContent = name;
    }
    if (emailPreview) {
        emailPreview.textContent = email;
    }
    if (phonePreview) {
        phonePreview.textContent = phone;
    }
    if (addressPreview) {
        addressPreview.textContent = address;
    }

    // Update email verification status
    if (statusElement) {
        if (isEmailValid) {
            statusElement.textContent = TRANSLATIONS.verifyEmail;
            statusElement.className = 'status-badge';
            statusElement.style.background = 'rgba(255,255,255,0.2)';
        } else {
            statusElement.textContent = TRANSLATIONS.unverified;
            statusElement.className = 'status-badge';
            statusElement.style.background = 'rgba(220,53,69,0.2)';
        }
    }
}

function handleImageUpload() {
    const file = document.getElementById('user_image').files[0];
    const placeholder = document.getElementById('image-placeholder');
    const previewContainer = document.getElementById('image-preview-container');
    const previewImage = document.getElementById('image-preview');
    const avatarPreview = document.getElementById('previewImage');
    const uploadZone = document.getElementById('imageUploadZone');

    if (file) {
        // Validate file size (2MB limit)
        if (file.size > 2 * 1024 * 1024) {
            alert(TRANSLATIONS.fileSizeLimit);
            return;
        }

        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert(TRANSLATIONS.selectValidImage);
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            if (previewImage) previewImage.src = e.target.result;
            if (avatarPreview) avatarPreview.src = e.target.result;
            if (placeholder) placeholder.style.display = 'none';
            if (previewContainer) previewContainer.style.display = 'block';
            if (uploadZone) uploadZone.classList.add('has-image');
        };
        reader.readAsDataURL(file);
    }
}

function removeImage(event) {
    event.preventDefault();
    event.stopPropagation();

    const imageInput = document.getElementById('user_image');
    const placeholder = document.getElementById('image-placeholder');
    const previewContainer = document.getElementById('image-preview-container');
    const previewImage = document.getElementById('previewImage');
    const uploadZone = document.getElementById('imageUploadZone');

    if (imageInput) imageInput.value = '';
    if (placeholder) placeholder.style.display = 'block';
    if (previewContainer) previewContainer.style.display = 'none';
    if (uploadZone) uploadZone.classList.remove('has-image');

    // Reset to original image or placeholder
    if (previewImage) {
        const originalImage = USER_DATA.imagePath || USER_DATA.placeholderImage;
        previewImage.src = originalImage;
    }
}
</script>
