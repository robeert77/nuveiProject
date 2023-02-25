<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <section class="container my-5">
        <form action="/<?php echo $formAction; ?>" method="POST">
            <?php if (isset($errors) && $errors) { ?>
                <div class="row">
                    <div class="alert alert-danger col-sm-8" role="alert">
                        <?php foreach ($errors as $field => $messages) {
                            echo '<h3 class="text-capitalize mt-1">' . $field . '</h3>';
                            foreach ($messages as $message) {
                                echo $message . '</br>';
                            }
                        } ?>
                    </div>
                </div>
            <?php } ?>

            <div class="row mb-3">
                <label for="username" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-6">
                    <input type="text"
                        class="form-control <?php echo $isInvalid ? (in_array('username', array_keys($errors)) ? 'is-invalid' : 'is_valid') : ''; ?>"
                        name="username"
                        value="<?php echo ($isInvalid && $oldValues['username'] ? $oldValues['username'] : ''); ?>"
                        id="username"
                        required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-6">
                    <input type="password"
                        class="form-control <?php echo $isInvalid ? (in_array('password', array_keys($errors)) ? 'is-invalid' : 'is_valid') : ''; ?>"
                        name="password"
                        value="<?php echo ($isInvalid && $oldValues['password'] ? $oldValues['password'] : ''); ?>"
                        id="password"
                        required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="confirmPassword" class="col-sm-2 col-form-label">Confirm password</label>
                <div class="col-sm-6">
                    <input type="password"
                        class="form-control <?php echo $isInvalid ? (in_array('confirmPassword', array_keys($errors)) ? 'is-invalid' : 'is_valid') : ''; ?>"
                        name="confirmPassword"
                        value="<?php echo ($isInvalid && $oldValues['confirmPassword'] ? $oldValues['confirmPassword'] : ''); ?>"
                        id="confirmPassword"
                        required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email"
                        class="form-control <?php echo $isInvalid ? (in_array('email', array_keys($errors)) ? 'is-invalid' : 'is_valid') : ''; ?>"
                        name="email"
                        value="<?php echo ($isInvalid && $oldValues['email'] ? $oldValues['email'] : ''); ?>"
                        id="email"
                        required>
                </div>
            </div>

            <div class="row mb-3">
                <label for="department" class="col-sm-2 col-form-label">Department</label>
                <div class="col-sm-6">
                    <select class="form-select" name="id_department" id="department">
                        <?php foreach ($departments as $id => $department) { ?>
                            <option value="<?php echo $id; ?>"
                                <?php echo ($isInvalid && $oldValues['id_department'] == $id ? 'selected' : ''); ?>>
                                    <?php echo $department; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <fieldset class="row mb-3">
                <legend class="col-form-label col-sm-2 pt-0">Category</legend>
                <div class="col-sm-6">
                    <?php foreach ($categories as $id => $category) { ?>
                        <div class="form-check-inline">
                            <input type="checkbox"
                                class="form-check-input"
                                name="id_category[]"
                                value="<?php echo $id; ?>"
                                id="category-<?php echo $id; ?>"
                                <?php echo ($isInvalid && in_array($id, $oldValues['id_category']) ? 'checked' : ''); ?> >
                            <label class="form-check-label" for="category-<?php echo $id; ?>"><?php echo $category; ?></label>
                        </div>
                    <?php } ?>
                </div>
            </fieldset>

            <fieldset class="row mb-3">
                <legend class="col-form-label col-sm-2 pt-0">Hobbies</legend>
                <div class="col-sm-6">
                    <?php foreach ($hobbies as $id => $hobby) { ?>
                        <div class="form-check-inline">
                            <input type="radio"
                                class="form-check-input"
                                name="id_hobby"
                                value="<?php echo $id; ?>"
                                id="hobby-<?php echo $id; ?>"
                                <?php echo ($isInvalid && $oldValues['id_hobby'] == $id ? 'checked' : ''); ?> >
                            <label class="form-check-label" for="hobby-<?php echo $id; ?>"><?php echo $hobby; ?></label>
                        </div>
                    <?php } ?>
                </div>
            </fieldset>

            <div class="row mb-3">
                <div class="col-sm-10">
                    <div class="form-check">
                        <input type="checkbox"
                            class="form-check-input <?php echo $isInvalid ? (in_array('termsConditions', array_keys($errors)) ? 'is-invalid' : 'is_valid') : ''; ?>"
                            name="termsConditions"
                            <?php echo ($isInvalid && $oldValues['termsConditions'] ? 'checked' : ''); ?>
                            id="termsConditions"
                            required>
                        <label class="form-check-label" for="termsConditions">I accept Terms & Conditions</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary text-center">Register</button>
        </form>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
