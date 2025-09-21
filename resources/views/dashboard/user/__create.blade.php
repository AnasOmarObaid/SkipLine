<script>
    // Real-time preview functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('userForm');
    const inputs = form.querySelectorAll('input, textarea, select');

    // Add event listeners to all form inputs
    inputs.forEach(input => {
        input.addEventListener('input', updatePreview);
        input.addEventListener('change', updatePreview);
    });

    // Image upload handling
    const imageInput = document.getElementById('user_image');
    const imageUploadZone = document.getElementById('imageUploadZone');

    imageInput.addEventListener('change', handleImageUpload);

    // Password strength indicator
    document.getElementById('password').addEventListener('input', checkPasswordStrength);

    // Initial preview update
    updatePreview();
});

function updatePreview() {
    // Get form values
    const name = document.getElementById('name').value || '{{ __('app.name') }}';
    const email = document.getElementById('email').value || '{{ __('app.user_example_email') }}';
    const password = document.getElementById('password').value;
    const phone = document.getElementById('phone').value || '-';
    const address = document.getElementById('address').value || '-';
    const isEmailValid = document.getElementById('validEmail').checked;

    // Update preview elements
    document.getElementById('name_preview').textContent = name;
    document.getElementById('email_preview').textContent = email;
    document.getElementById('password_preview').textContent = password ? '•'.repeat(password.length) : '••••••••';
    document.getElementById('phone_preview').textContent = phone;
    document.getElementById('address_preview').textContent = address;

    // Update email verification status
    const statusElement = document.getElementById('previewStatus');
    if (isEmailValid) {
        statusElement.textContent = '{{ __('app.verify_email') }}';
        statusElement.className = 'status-badge';
    } else {
        statusElement.textContent = '{{ __('app.unverified') }}';
        statusElement.className = 'status-badge';
        statusElement.style.background = 'rgba(220,53,69,0.2)';
    }

    // Add animation
    document.getElementById('user-preview').classList.add('fade-in');
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
            alert('{{ __('app.user_file_size_limit') }}');
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
            avatarPreview.src = e.target.result;
            placeholder.style.display = 'none';
            previewContainer.style.display = 'block';
            uploadZone.classList.add('has-image');
        };
        reader.readAsDataURL(file);
    }
}

function removeImage(event) {
    event.preventDefault();
    event.stopPropagation();

    document.getElementById('user_image').value = '';
    document.getElementById('image-placeholder').style.display = 'block';
    document.getElementById('image-preview-container').style.display = 'none';
    document.getElementById('previewImage').src = 'https://placehold.co/120x120/0d6efd/ffffff?text=👤';
    document.getElementById('imageUploadZone').classList.remove('has-image');
}

function checkPasswordStrength() {
    const password = document.getElementById('password').value;
    const strengthElement = document.getElementById('passwordStrength');

    let strength = 0;

    // Check password criteria
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[^\w\s]/.test(password)) strength++;

    // Update strength indicator
    strengthElement.className = 'password-strength';
    if (strength <= 1) {
        strengthElement.classList.add('weak');
    } else if (strength <= 2) {
        strengthElement.classList.add('fair');
    } else if (strength <= 3) {
        strengthElement.classList.add('good');
    } else {
        strengthElement.classList.add('strong');
    }
}

// Password toggle functionality
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('passwordToggleIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.className = 'bi bi-eye-slash';
    } else {
        passwordInput.type = 'password';
        toggleIcon.className = 'bi bi-eye';
    }
}

// Form submission with loading state
document.getElementById('userForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>{{ __('app.creating_user') }}...';

    // Add loading overlay
    const overlay = document.createElement('div');
    overlay.className = 'spinner-overlay';
    overlay.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">{{ __('app.loading') }}...</span></div>';
    document.querySelector('.form-section').appendChild(overlay);
});

</script>
