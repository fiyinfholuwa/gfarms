<!DOCTYPE html>
<html>
<head>
    <title>KYC Verification</title>
    <script src="https://widget.dojah.io/widget.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* ✅ Larger container - full viewport approach */
        #dojah-container {
            margin: 0 auto;
            width: 100vw;
            height: 100vh;
            min-height: 600px; /* Ensures minimum height */
        }

        /* Alternative: Fixed larger dimensions */
        /*
        #dojah-container {
            margin: 0 auto;
            width: 1200px;
            height: 800px;
            max-width: 95vw;
            max-height: 90vh;
        }
        */

        /* For smaller screens, maintain responsiveness */
        @media (max-width: 768px) {
            #dojah-container {
                width: 100vw;
                height: 100vh;
                min-height: 500px;
            }
        }

        /* Optional: Add some padding for very large screens */
        @media (min-width: 1400px) {
            #dojah-container {
                width: 90vw;
                height: 90vh;
                margin: 5vh auto;
                border-radius: 8px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            }
        }
    </style>
</head>
<body>

<!-- ✅ Container where Dojah will embed -->
<div id="dojah-container"></div>

<script>
window.onload = function () {
    let kycCompleted = false;

    const options = {
        app_id: "{{ $appId }}",
        p_key: "{{ $publicKey }}",
        type: "verification",
        config: { 
            widget_id: "{{ $widgetId }}",
            type: "custom",              // ✅ force embed mode
            container: "#dojah-container" // ✅ render inside this div
        },
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
            kycCompleted = true;
            window.location.href = "{{ route('kyc.complete') }}";
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
                }).then(() => {
                    window.location.href = "{{ route('dashboard') }}";
                });
            }
        },
        onError: (err) => {
            Swal.fire({
                icon: 'error',
                title: 'KYC Verification Failed',
                text: 'An error occurred during the KYC process. Click OK to return to the dashboard.',
                confirmButtonText: 'OK',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(() => {
                window.location.href = "{{ route('dashboard') }}";
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