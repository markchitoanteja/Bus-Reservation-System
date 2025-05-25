<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Panel – Prototype</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .construction-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }

        .card {
            max-width: 600px;
            margin: auto;
        }

        .card-title {
            font-size: 1.75rem;
            font-weight: 600;
        }

        .card-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
        }

        .icon-wrapper {
            font-size: 3rem;
            color: #0d6efd;
        }

        .logout-container {
            position: absolute;
            top: 1rem;
            right: 1.5rem;
        }
    </style>
</head>

<body>
    <!-- Logout Button -->
    <div class="logout-container">
        <form action="javascript:void(0)" id="logoutForm">
            <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
        </form>
    </div>

    <!-- Main Content -->
    <div class="container construction-container">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="icon-wrapper mb-3">
                    🔧
                </div>
                <h1 class="card-title">Admin Panel Prototype</h1>
                <p class="card-subtitle mb-4">This page is currently under construction and is part of an early-stage prototype.</p>
                <p class="text-muted">
                    We’re working hard to bring you a fully functional and polished experience. In the meantime, feel free to explore available features—or check back soon!
                </p>
                <hr />
                <small class="text-muted">Last updated: May 2025</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#logoutForm').on('submit', function(e) {
                $.ajax({
                    url: 'logout',
                    type: 'POST',
                    dataType: 'JSON',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        location.href = response.redirect_url || '<?= base_url() ?>';
                    },
                    error: function(_, _, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
</body>

</html>