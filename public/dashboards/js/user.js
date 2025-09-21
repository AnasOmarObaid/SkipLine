$(document).ready(function () {
    // live image preview
    $("#user_image").on("change", function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $("#previewImage").attr("src", e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // live name preview
    $("#name").on("input", function () {
        $("#name_preview").text($(this).val() || "");
    });

    // live email preview
    $("#email").on("input", function () {
        $("#email_preview").text($(this).val() || "");
    });

    // live password preview
    $("#password").on("input", function () {
        $("#password_preview").text($(this).val() || "");
    });

    // Password toggle functionality
    $("#togglePassword").on("click", function () {
        const passwordField = $("#password");
        const eyeIcon = $("#eyeIcon");

        if (passwordField.attr("type") === "password") {
            passwordField.attr("type", "text");
            eyeIcon.removeClass("bi-eye").addClass("bi-eye-slash");
        } else {
            passwordField.attr("type", "password");
            eyeIcon.removeClass("bi-eye-slash").addClass("bi-eye");
        }
    });

    // phone number preview
    $("#phone").on("input", function () {
        $("#phone_preview").text($(this).val() || "");
    });

    // phone number preview
    $("#address").on("input", function () {
        $("#address_preview").text($(this).val() || "");
    });

    // Status checkbox
    $('input[name="email_verified_at"]').on("change", function () {
        // Toggle the checkbox value
        $(this).data("value", $(this).is(":checked") ? "1" : "0");

        // Update the preview status class to set or remove bg-success or bg-danger
        if ($(this).data("value") == "1") {
            $("#previewStatus").text("Verify Email");
            $("#previewStatus").removeClass("bg-danger").addClass("bg-success");
        } else {
            $("#previewStatus").text("Not verify email");
            $("#previewStatus").removeClass("bg-success").addClass("bg-danger");
        }
    });

    // Enhanced user table with modern features
    const userTable = $("#userTable")
        .DataTable({
            responsive: true,
            processing: true,
            pageLength: 15,
            lengthMenu: [[10, 15, 25, 50, 100], [10, 15, 25, 50, 100]],
            order: [[0, 'desc']],
            columnDefs: [
                {
                    targets: "no-sort",
                    orderable: false,
                },
                {
                    targets: 0, // ID column
                    width: "80px"
                },
                {
                    targets: 1, // User column
                    width: "250px"
                },
                {
                    targets: -1, // Actions column
                    width: "150px",
                    className: "text-center"
                }
            ],
            buttons: [
                {
                    extend: 'copy',
                    text: '<i class="bi bi-clipboard me-1"></i>Copy',
                    className: 'btn btn-sm buttons-copy',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'excel',
                    text: '<i class="bi bi-file-earmark-excel me-1"></i>Excel',
                    className: 'btn btn-sm buttons-excel',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    },
                    title: 'Users List'
                },
                {
                    extend: 'pdf',
                    text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                    className: 'btn btn-sm buttons-pdf',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    },
                    title: 'Users List',
                    orientation: 'landscape',
                    pageSize: 'A4'
                },
                {
                    extend: 'csv',
                    text: '<i class="bi bi-file-earmark-text me-1"></i>CSV',
                    className: 'btn btn-sm buttons-csv',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="bi bi-printer me-1"></i>Print',
                    className: 'btn btn-sm buttons-print',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    },
                    title: 'Users List'
                },
                {
                    extend: 'colvis',
                    text: '<i class="bi bi-eye me-1"></i>Columns',
                    className: 'btn btn-sm buttons-colvis'
                }
            ],
            dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"B>>rtip',
            language: {
                search: '',
                searchPlaceholder: 'Search users...',
                lengthMenu: '_MENU_ users per page',
                info: 'Showing _START_ to _END_ of _TOTAL_ users',
                infoEmpty: 'No users found',
                infoFiltered: '(filtered from _MAX_ total users)',
                zeroRecords: '<div class="text-center py-4"><i class="bi bi-people fs-1 text-muted"></i><h5 class="mt-3 text-muted">No users found</h5><p class="text-muted">Try adjusting your search or filter criteria</p></div>',
                paginate: {
                    first: '<i class="bi bi-chevron-double-left"></i>',
                    last: '<i class="bi bi-chevron-double-right"></i>',
                    next: '<i class="bi bi-chevron-right"></i>',
                    previous: '<i class="bi bi-chevron-left"></i>'
                }
            },
            initComplete: function () {
                // Move buttons to designated area
                $(this.api().buttons().container()).appendTo('#userTable_wrapperButton');
                
                // Hide default search (we'll use custom search)
                $('.dataTables_filter').hide();
                
                // Style pagination
                $('.dataTables_paginate').addClass('d-flex justify-content-center');
                
                // Add loading animation class
                $('#userTable tbody tr').addClass('animate__animated animate__fadeInUp');
            },
            drawCallback: function () {
                // Re-initialize tooltips after draw
                $('[title]').tooltip({
                    placement: 'top',
                    trigger: 'hover'
                });
                
                // Add stagger animation to rows
                $('#userTable tbody tr').each(function(index) {
                    $(this).css({
                        'animation-delay': (index * 0.05) + 's'
                    });
                });
            }
        });

    // Custom search functionality
    $('#globalSearch').on('input', function() {
        const searchValue = this.value;
        userTable.search(searchValue).draw();
        
        // Add search highlight animation
        if (searchValue) {
            $('#userTable tbody tr:visible').addClass('animate__animated animate__pulse');
            setTimeout(() => {
                $('#userTable tbody tr').removeClass('animate__pulse');
            }, 1000);
        }
    });

    // Custom status filter
    $('#statusFilter').on('change', function() {
        const filterValue = this.value;
        
        if (filterValue === '') {
            userTable.column(3).search('').draw();
        } else if (filterValue === 'verified') {
            userTable.column(3).search('Verified').draw();
        } else if (filterValue === 'unverified') {
            userTable.column(3).search('Unverified').draw();
        }
        
        // Add filter animation
        $('#userTable tbody tr:visible').addClass('animate__animated animate__fadeInLeft');
        setTimeout(() => {
            $('#userTable tbody tr').removeClass('animate__fadeInLeft');
        }, 800);
    });

    // Enhanced delete confirmation with SweetAlert
    $(document).on('click', '.btn-delete-confirm', function(e) {
        e.preventDefault();
        
        const form = $(this).closest('form');
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'This user will be permanently deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait while we delete the user.',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                form.submit();
            }
        });
    });

    // Add hover effects to stat cards
    $('.stat-card').hover(
        function() {
            $(this).addClass('animate__animated animate__pulse');
        },
        function() {
            $(this).removeClass('animate__pulse');
        }
    );

    // Add click animation to action buttons
    $('.btn-action').on('click', function() {
        $(this).addClass('animate__animated animate__heartBeat');
        setTimeout(() => {
            $(this).removeClass('animate__heartBeat');
        }, 1000);
    });

    // Handle view user button clicks for orders modal
    $(document).on('click', '.view-user-btn', function (e) {
        e.preventDefault();
        
        const userId = $(this).data('user-id');
        const url = $(this).data('url');
        
        if (!userId || !url) {
            console.error('User ID or URL not found');
            return;
        }
        
        viewUserOrders(userId, url);
    });

    // Function to view user orders
    async function viewUserOrders(userId, url) {
        try {
            // Show loading state
            $('#userPreviewContent').html(`
                <div class="text-center p-5">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 text-muted">Loading user orders...</p>
                </div>
            `);
            
            // Update modal title
            $('#userPreviewModalLabel').html('<i class="bi bi-person-circle me-2"></i>User Orders');
            
            // Show the modal
            const modal = new bootstrap.Modal(document.getElementById('userPreviewModal'));
            modal.show();
            
            // Fetch user orders
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const html = await response.text();
            
            // Update modal content
            $('#userPreviewContent').html(html);
            
            // Add smooth animations to order cards
            $('.order-card').each(function(index) {
                $(this).css({
                    'opacity': '0',
                    'transform': 'translateY(20px)'
                }).delay(index * 100).animate({
                    'opacity': '1'
                }, 300, function() {
                    $(this).css('transform', 'translateY(0)');
                });
            });
            
        } catch (error) {
            console.error('Error loading user orders:', error);
            $('#userPreviewContent').html(`
                <div class="alert alert-danger text-center">
                    <i class="bi bi-exclamation-triangle fs-1 d-block mb-3"></i>
                    <h5>Error Loading User Orders</h5>
                    <p class="mb-0">Unable to load user orders. Please try again later.</p>
                </div>
            `);
        }
    }

    // Handle modal close event
    $('#userPreviewModal').on('hidden.bs.modal', function () {
        // Clear modal content
        $('#userPreviewContent').html('');
        
        // Reset modal title
        $('#userPreviewModalLabel').html('User Details');
    });

    // Handle image loading errors in the modal
    $(document).on('error', '.user-avatar, .product-image', function() {
        const $img = $(this);
        if ($img.hasClass('user-avatar')) {
            // Replace with initials placeholder for user avatar
            const userName = $img.attr('alt') || 'User';
            const initials = userName.split(' ').map(name => name[0]).join('').toUpperCase();
            $img.replaceWith(`
                <div class="user-avatar d-flex align-items-center justify-content-center" 
                     style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-weight: 600; font-size: 1.5rem;">
                    ${initials}
                </div>
            `);
        } else if ($img.hasClass('product-image')) {
            // Replace with product placeholder
            $img.replaceWith(`
                <div class="product-placeholder">
                    <i class="bi bi-box"></i>
                </div>
            `);
        }
    });

});

