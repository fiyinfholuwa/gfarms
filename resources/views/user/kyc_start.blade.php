<!DOCTYPE html>
<html>
<head>
    <title>KYC Verification</title>
    <script src="https://widget.dojah.io/widget.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Make widget responsive */
        
    </style>
</head>
<body>
<script>
    window.onload = function () {
        let kycCompleted = false;

        const options = {
            app_id: "{{ $appId }}",
            p_key: "{{ $publicKey }}",
            type: "verification",
            config: { widget_id: "{{ $widgetId }}" },
            user_data: {
                first_name: "{{ $user->first_name }}",
                last_name: "{{ $user->last_name }}",
                email: "{{ $user->email }}",
            },
            metadata: {
                user_id: "{{ $user->id }}",
                reference: "{{ $reference }}",
            },

            onSuccess: (response) => {
                console.log('KYC Success', response);
                kycCompleted = true;

                let countdown = 20; // seconds

                Swal.fire({
                    icon: 'info',
                    title: 'Verification Pending',
                    html: `
                        <p>Your KYC submission was successful and is now under review.<br>
                        Please wait a moment before confirming.</p>
                        <button id="confirmBtn" class="swal2-confirm swal2-styled" disabled>
                            Confirm (20s)
                        </button>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        const confirmBtn = Swal.getPopup().querySelector('#confirmBtn');

                        const timer = setInterval(() => {
                            countdown--;
                            confirmBtn.textContent = countdown > 0 ? `Confirm (${countdown}s)` : "Confirm";
                            
                            if (countdown <= 0) {
                                confirmBtn.disabled = false;
                                clearInterval(timer);
                            }
                        }, 1000);

                        confirmBtn.addEventListener('click', () => {
                            Swal.close();
                            window.location.href = "{{ route('kyc.complete') }}";
                        });
                    }
                });
            },

            onClose: () => {
                if (!kycCompleted) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'KYC Process Closed',
                        text: 'You closed the KYC verification. Click OK to return to the dashboard.',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('dashboard') }}";
                        }
                    });
                }
            },

            onError: (err) => {
                console.error('KYC Error', err);
                Swal.fire({
                    icon: 'error',
                    title: 'KYC Verification Failed',
                    text: 'An error occurred during the KYC process. Click OK to return to the dashboard.',
                    confirmButtonText: 'OK',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('dashboard') }}";
                    }
                });
            }
        };

        const connect = new window.Connect(options);
        connect.setup();
        connect.open();
    };
</script>
</body>
</html>
