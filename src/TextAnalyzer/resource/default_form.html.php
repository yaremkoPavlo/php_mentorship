<?php $options = $options ?? [] ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php echo $options['encoding'] ?? 'UTF-8'; ?>">
    <title>Metoring 2021</title>
    <style>
        form textarea {
            width: 600px;
            height: 400px;
            margin: 0 20px;
        }
        form button {
            position: fixed;
        }
    </style>
</head>
<body>
    <form id="form" method="<?php echo $options['method']; ?>" action="<?php echo $options['action']; ?>">
        <label>
            <textarea name="<?php echo $options['textarea_name']; ?>"></textarea>
        </label>
        <button type="submit">Submit</button>
    </form>

    <pre id="output"><?php echo $options['output'] ?? ''; ?></pre>
</body>

</html>