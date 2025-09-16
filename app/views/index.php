<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Student Attendance Records</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Roboto', sans-serif;
      color: #333;
    }

    .card {
      border-radius: 15px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .card-body {
      padding: 2rem;
    }

    .table thead {
      background-color: #0d6efd;
      color: white;
    }

    .table td, .table th {
      vertical-align: middle;
      text-align: center;
    }

    .table-bordered td, .table-bordered th {
      border: 1px solid #ddd;
    }

    .table-hover tbody tr:hover {
      background-color: #f1f1f1;
    }

    .btn {
      border-radius: 25px;
      padding: 8px 16px;
      font-size: 14px;
    }

    .btn:hover {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-outline-primary:hover {
      background-color: #0d6efd;
      color: white;
    }

    .btn-outline-danger:hover {
      background-color: #dc3545;
      color: white;
    }

    .search-form input {
      border-radius: 25px;
      padding-right: 40px;
    }

    .search-form button {
      border-radius: 25px;
    }

    .modal-header {
      background-color: #0d6efd;
      color: white;
    }

    .modal-footer .btn {
      width: 120px;
    }

    .modal-content {
      border-radius: 10px;
    }

    .search-form button:focus, .search-form input:focus {
      box-shadow: none;
      outline: none;
    }

    .modal-body input {
      border-radius: 10px;
    }

    /* Clear button for search input */
    .search-form .clear-btn {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
    }

    .modal-content .form-floating input {
      border-radius: 10px;
    }

    /* Make the card responsive */
    @media (max-width: 768px) {
      .table-responsive {
        overflow-x: auto;
      }
    }
  </style>
</head>
<body>

<div class="container py-5">
  <div class="card shadow-lg border-0 mb-4">
    <div class="card-body">
      <h2 class="text-center text-primary mb-4">📋 Student Attendance Records</h2>

      <div class="mb-3">
        <?php getErrors(); ?>
        <?php getMessage(); ?>
      </div>

      <div class="d-flex justify-content-between mb-3">
        <form action="<?=site_url('/');?>" method="get" class="search-form d-flex col-lg-4 col-md-5 col-12 position-relative">
          <?php
          $q = '';
          if(isset($_GET['q'])) {
            $q = $_GET['q'];
          }
          ?>
          <input class="form-control me-2" name="q" type="text" placeholder="Search" value="<?=html_escape($q);?>">
          <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Search</button>
          <?php if($q): ?>
            <a href="<?=site_url('/');?>" class="clear-btn"><i class="bi bi-x-circle-fill"></i></a>
          <?php endif; ?>
        </form>

        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
          <i class="bi bi-plus-lg"></i> Add Attendance
        </button>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>Student ID</th>
              <th>Full Name</th>
              <th>Class</th>
              <th>Section</th>
              <th>Date</th>
              <th>Time In</th>
              <th>Time Out</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($all)): ?>
              <?php foreach ($all as $student): ?>
                <tr>
                  <td><?= htmlspecialchars($student['student_id']); ?></td>
                  <td><?= htmlspecialchars($student['full_name']); ?></td>
                  <td><?= htmlspecialchars($student['class']); ?></td>
                  <td><?= htmlspecialchars($student['section']); ?></td>
                  <td><?= htmlspecialchars($student['attendance_date']); ?></td>
                  <td><?= htmlspecialchars($student['time_in']); ?></td>
                  <td><?= htmlspecialchars($student['time_out']); ?></td>
                  <td>
                    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $student['id']; ?>">Edit</button>
                    <button class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $student['id']; ?>">Delete</button>
                  </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal<?= $student['id']; ?>" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content border-0 shadow">
                      <form action="/update-user/<?= $student['id']; ?>" method="POST">
                        <div class="modal-header bg-primary text-white">
                          <h5 class="modal-title">Edit Attendance</h5>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" name="id" value="<?= $student['id']; ?>">
                          <!-- Form fields here -->
                          <div class="form-floating mb-3">
                            <input type="text" name="student_id" class="form-control" value="<?= $student['student_id']; ?>" required>
                            <label>Student ID</label>
                          </div>
                          <div class="form-floating mb-3">
                            <input type="text" name="full_name" class="form-control" value="<?= $student['full_name']; ?>" required>
                            <label>Full Name</label>
                          </div>
                          
                           <div class="form-floating mb-3">
                            <input type="text" name="class" class="form-control" value="<?= $student['class']; ?>" required>
                            <label>Class</label>
                          </div>

                           <div class="form-floating mb-3">
                            <input type="text" name="section" class="form-control" value="<?= $student['section']; ?>" required>
                            <label>Section</label>
                          </div>

                           <div class="form-floating mb-3">
                            <input type="text" name="a  ttendance_date" class="form-control" value="<?= $student['attendance_date']; ?>" required>
                            <label>Attedance date</label>
                          </div>

                           <div class="form-floating mb-3">
                            <input type="text" name="time_in" class="form-control" value="<?= $student['time_in']; ?>" required>
                            <label>Time in</label>
                          </div>

                            <div class="form-floating mb-3">
                            <input type="text" name="time_out" class="form-control" value="<?= $student['time_out']; ?>" required>
                            <label>Time Out</label>
                          </div>

                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success">Update</button>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal<?= $student['id']; ?>" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content border-0 shadow">
                      <form action="/delete-user/<?= $student['id']; ?>" method="POST">
                        <div class="modal-header bg-danger text-white">
                          <h5 class="modal-title">Confirm Delete</h5>
                          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                          <p>Are you sure you want to delete attendance record for <strong><?= $student['full_name']; ?></strong> on <strong><?= $student['attendance_date']; ?></strong>?</p>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-danger">Delete</button>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-muted">No attendance records found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
        <?php echo $page ?>
      </div>
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <form action="/create-user" method="POST">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title">Add Attendance</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="form-floating mb-3">
            <input type="text" name="student_id" class="form-control" required>
            <label>Student ID</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" name="full_name" class="form-control" required>
            <label>Full Name</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" name="class" class="form-control" required>
            <label>Class</label>
          </div>
          <div class="form-floating mb-3">
            <input type="text" name="section" class="form-control" required>
            <label>Section</label>
          </div>
          <div class="form-floating mb-3">
            <input type="date" name="attendance_date" class="form-control" required>
            <label>Date</label>
          </div>
          <div class="form-floating mb-3">
            <input type="time" name="time_in" class="form-control" required>
            <label>Time In</label>
          </div>
          <div class="form-floating mb-3">
            <input type="time" name="time_out" class="form-control" required>
            <label>Time Out</label>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Add</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL; ?>/public/js/alert.js"></script>
</body>
</html>
