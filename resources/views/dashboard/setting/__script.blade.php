<script>
    // Color picker preview
    document.getElementById('primary_color').addEventListener('input', function() {
        document.getElementById('primary_preview').style.backgroundColor = this.value;
    });

    document.getElementById('secondary_color').addEventListener('input', function() {
        document.getElementById('secondary_preview').style.backgroundColor = this.value;
    });

    // Initialize color previews
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('primary_preview').style.backgroundColor = document.getElementById('primary_color').value;
        document.getElementById('secondary_preview').style.backgroundColor = document.getElementById('secondary_color').value;
    });

    // File upload handling
    const fileUploadZone = document.querySelector('.file-upload-zone');
    const logoInput = document.getElementById('logo_upload');

    fileUploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });

    fileUploadZone.addEventListener('dragleave', function() {
        this.classList.remove('dragover');
    });

    fileUploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            logoInput.files = files;
        }
    });

    // Form submission with loading state
    document.getElementById('settingsForm').addEventListener('submit', function() {
        const submitBtn = this.querySelector('.save-button');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>{{ __('app.saving_settings') ?: 'Saving Settings...' }}';
    });
</script>
