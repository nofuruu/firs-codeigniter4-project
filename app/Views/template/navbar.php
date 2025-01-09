<nav class="navbar navbar-expand-lg bg-body-tertiary " data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#" id="navbrand">crudtest</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>



            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active d-flex" aria-current="page" href="<?= base_url('userController') ?>" id="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active d-flex" aria-current="page" href="<?= base_url('masterController') ?>" id="nav-link">User</a>
                </li>
            </ul>
        </div>
    </div>



<style>
     #nav-link {
            font-size: 1rem;
            text-transform: uppercase;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        #nav-link:hover{
            color: #a2c25a;
            font-weight: bold;
            transform: scale(1.1);
        }

        
        #navbrand {
            text-transform: uppercase;
            font-weight: bold;
            font-size: 2rem;
            color: #a2c25a;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }



</style>