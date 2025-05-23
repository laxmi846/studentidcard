<?php
?><!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .container {
            max-width: 500px;
            margin-top: 60px;
            background: #fff;
            padding: 30px 25px 25px 25px;
            border-radius: 8px;
            box-shadow: 0 0 16px rgba(0,0,0,0.08);
        }
        h3 {
            text-align: center;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
<div class="container">
    <h3>Add Department</h3>
    <form method="post" action="add_department.php" class="mb-4">
        <div class="mb-3">
            <label for="department_name" class="form-label">Department Name</label>
            <input type="text" class="form-control" id="department_name" name="department_name" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 mb-2">Add Department</button>
        <a href="display_depart.php" class="btn btn-secondary w-100">Back to Department List</a>
    </form>
</div>
</body>
</html>