<script>
      $(document).ready(function() {
            $(document).on('click', '.btn-delete', function(event) {
                  event.preventDefault();

                  // dialog open
                  Swal.fire({
                        title: "{{ __('app.are_you_sure_to_continue') }}",
                        icon: 'question',
                        iconHtml: '؟',
                        confirmButtonText: "{{ __('app.yes') }}",
                        cancelButtonText: "{{ __('app.no') }}",
                        showCancelButton: true,
                        showCloseButton: true
                  }).then((result) => {
                        if (result.isConfirmed) {
                              // url
                              const url = $(this).closest('form').attr('action');

                              // send some value to method
                              const csrf_token = $("meta[name='csrf-token']").attr(
                                    'content');
                            // remove
                            const row = $(this).closest('.tr');

                              // send ajax request
                              $.ajax({
                                    url: url,
                                    type: 'DELETE',
                                    data: {
                                          '_method': 'DELETE',
                                          '_token': csrf_token
                                    },
                                    success: function(data) {
                                          Swal.fire({
                                                    title: "{{ __('app.delete')}} !",
                                                    text: data.msg,
                                                    icon: "success",
                                                    timer: 1000,
                                                    showConfirmButton: true
                                            });
                                        console.log(data);
                                        row.remove();
                                    },
                                    error: function(error) {
                                          Swal.fire({
                                                title: "Ooops.. {{ __('app.error') }}",
                                                text: error.responseJSON.message,
                                                icon: "error"
                                          });
                                          console.log(error);
                                    }
                              });
                        }
                  })
            });
      });
</script>
