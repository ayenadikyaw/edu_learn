<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Verify Your Email Address</div>
                    <div class="card-body">
                        <!-- Success message if session contains 'resent' -->
                        <?php if (session('resent')): ?>
                            <div class="alert alert-success" role="alert">
                                A fresh verification link has been sent to your email address.
                            </div>
                        <?php endif; ?>

                        <p>Before proceeding, please check your email for a verification link.</p>
                        <p>If you did not receive the email,</p>
                        
                        <!-- Resend verification link form -->
                        <form class="d-inline" method="POST" action="/email/verification-notification">
                            <input type="hidden" name="_token" value="<?= csrf_token(); ?>">
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">
                                click here to request another
                            </button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
