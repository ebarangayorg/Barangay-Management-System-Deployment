<?php
require_once '../../backend/auth_resident.php';
require_once '../../backend/config.php';

$email = $_SESSION['email'];
$user = $usersCollection->findOne(['email' => $email]);

if (!$user) {
    die("Error: User not found.");
}

$resident = $residentsCollection->findOne(['user_id' => $user['_id']]);

if (!$resident) {
    die("Error: Resident record not found.");
}

$userId = (string)$user['_id'];
$residentId = isset($resident['_id']) ? (string)$resident['_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BMS - Resident Dashboard</title>
    <link rel="icon" type="image/png" href="../../assets/img/BMS.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../css/dashboard.css" />
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">
        <?php
            $profileImg = isset($resident['profile_image']) && $resident['profile_image'] !== ""
                ? "../../assets/img/" . $resident['profile_image']
                : "../../assets/img/profile.jpg";
            ?>
            <img src="<?= $profileImg ?>" alt="">

        <div>
            <h3><?= $resident['first_name'] . " " . $resident['last_name'] ?></h3>
            <small><?= $resident['email'] ?></small>
        </div>
    </div>

    <div class="sidebar-menu">
        <a href="resident_dashboard.php" class="active"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="resident_rqs_service.php"><i class="bi bi-newspaper"></i> Request Service</a>
        <a href="../../index.php"><i class="bi bi-arrow-down-left"></i> Return to Homepage</a>
    </div>

    <div class="sidebar-bottom">
      <a href="../../backend/logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a>
    </div>
</div>

<div style="width:100%">

    <div class="header">
        <div class="hamburger" onclick="toggleSidebar()">☰</div>
        <h1 class="header-title">RESIDENT <span class="green">DASHBOARD</span></h1>

        <div class="header-logos">
            <img src="../../assets/img/barangaygusalogo.png">
            <img src="../../assets/img/cdologo.png">
        </div>
    </div>

    <div class="content">
        <div class="grid">

            <div class="card">
                <h3>Profile</h3><br>

                <?php
                    $profileImg = isset($resident['profile_image']) && $resident['profile_image'] !== ""
                        ? "../../assets/img/" . $resident['profile_image']
                        : "../../assets/img/profile.jpg";
                    ?>
                    <img src="<?= $profileImg ?>" alt="">


                <strong><?= $resident['first_name'] . " " . $resident['last_name'] ?></strong><br>

                <p>Email: <?= $resident['email'] ?></p>
                <p>Occupation: <?= $resident['occupation'] ?></p>
                <p>Family Income: <?= $resident['income'] ?></p>
                <p>Resident Since: <?= $resident['resident_since'] ?></p>

                <strong style="color:#2E9F43">Account
                    <?= $user['status'] ?>
                </strong>

                <button class="update-btn" data-bs-toggle="modal" data-bs-target="#updateModal">
                    Update
                </button>

            </div>

            <div>
                <section class="calendar-container">
                    <div class="calendar-header">
                        <button id="prev-month">&lt;</button>
                        <h2 id="month-year"></h2>
                        <button id="next-month">&gt;</button>
                    </div>

                    <div class="calendar-grid" id="calendar-grid"></div>
                </section>

                <div class="events">
                    <h3>EVENTS</h3>
                    <p>No events for today...</p>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- UPDATE MODAL -->
<div class="modal fade" id="updateModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5>Update Your Information</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="../../backend/update_resident_self.php" method="POST" enctype="multipart/form-data">
        
      <div class="modal-body">

        <input type="hidden" name="user_id" value="<?= $resident->_id ?>">

        <input type="hidden" name="existing_image" value="<?= $resident['profile_image'] ?? '' ?>">

        <div class="row g-2">

            <div class="col-md-12">
                <label>Profile Picture:</label>
                <input type="file" class="form-control" name="profile_image" accept="image/*">
            </div>

          <div class="col-md-4">First Name:
            <input class="form-control" name="fname" value="<?= $resident->first_name ?>">
          </div>

          <div class="col-md-4">Middle Name:
            <input class="form-control" name="mname" value="<?= $resident->middle_name ?>">
          </div>

          <div class="col-md-4">Last Name:
            <input class="form-control" name="lname" value="<?= $resident->last_name ?>">
          </div>

          <div class="col-md-4">Suffix:
            <input class="form-control" name="sname" value="<?= $resident->suffix ?>">
          </div>

          <div class="col-md-4">Gender:
            <select class="form-control" name="gender">
              <option <?= $resident->gender == "Male" ? 'selected' : '' ?>>Male</option>
              <option <?= $resident->gender == "Female" ? 'selected' : '' ?>>Female</option>
            </select>
          </div>

          <div class="col-md-4">Birthdate:
            <input type="date" class="form-control" name="bdate" value="<?= $resident->birthdate ?>">
          </div>

          <div class="col-md-4">Birthplace:
            <input class="form-control" name="bplace" value="<?= $resident->birthplace ?>">
          </div>

          <div class="col-md-4">Purok:
            <select class="form-control" name="purok">
              <?php for ($i=1; $i<=5; $i++): ?>
                <option <?= $resident->purok == "Purok $i" ? 'selected' : '' ?>>Purok <?= $i ?></option>
              <?php endfor; ?>
            </select>
          </div>

          <div class="col-md-4">Contact:
            <input class="form-control" name="contact" value="<?= $resident->contact ?>">
          </div>

          <div class="col-md-4">Occupation:
            <input class="form-control" name="occupation" value="<?= $resident->occupation ?>">
          </div>

          <div class="col-md-4">Resident Since:
            <input class="form-control" name="resident_since" value="<?= $resident->resident_since ?>">
          </div>

          <div class="col-md-4">Email:
            <input class="form-control" name="email" value="<?= $resident->email ?>" readonly>
          </div>

          <div class="col-md-4">Voter:
            <select class="form-control" name="voter_status">
              <option <?= $resident->voter == "Yes" ? 'selected' : '' ?>>Yes</option>
              <option <?= $resident->voter == "No" ? 'selected' : '' ?>>No</option>
            </select>
          </div>

          <div class="col-md-4">Income:
            <input class="form-control" name="income" value="<?= $resident->income ?>">
          </div>

          <div class="col-md-4">Family Head:
            <select class="form-control" name="family_head">
              <option <?= $resident->family_head == "Yes" ? 'selected' : '' ?>>Yes</option>
              <option <?= $resident->family_head == "No" ? 'selected' : '' ?>>No</option>
            </select>
          </div>

        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-success">Save Changes</button>
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>

      </form>
    </div>
  </div>
</div>



<script src="../../assets/js/calendar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
}
function openUpdateModal(data) {
    document.getElementById("u_resident_id").value = data._id;
    document.getElementById("u_fname").value = data.first_name;
    document.getElementById("u_mname").value = data.middle_name;
    document.getElementById("u_lname").value = data.last_name;
    document.getElementById("u_sname").value = data.suffix;
    document.getElementById("u_gender").value = data.gender;
    document.getElementById("u_bdate").value = data.birthdate;
    document.getElementById("u_bplace").value = data.birthplace;
    document.getElementById("u_purok").value = data.purok;
    document.getElementById("u_contact").value = data.contact;
    document.getElementById("u_occupation").value = data.occupation;
    document.getElementById("u_resident_since").value = data.resident_since;
    document.getElementById("u_email").value = data.email;
    document.getElementById("u_voter").value = data.voter;
    document.getElementById("u_income").value = data.income;
    document.getElementById("u_family_head").value = data.family_head;
}
</script>

</body>
</html>
