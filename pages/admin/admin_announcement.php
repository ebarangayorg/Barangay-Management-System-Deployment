<?php require_once '../../backend/auth_admin.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BMS - Admin Announcement</title>
    <link rel="icon" type="image/png" href="../../assets/img/BMS.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../css/dashboard.css" />

</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">
        <img src="../../assets/img/profile.jpg" alt="">
        <div>
            <h3>Lorebina C. Carrasco II</h3>
            <small>carrasco.lorebina85@gmail.com</small>
            <div class="dept">IT Department</div>
        </div>
    </div>

    <div class="sidebar-menu">
        <a href="admin_dashboard.php"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="admin_announcement.php" class="active"><i class="bi bi-megaphone"></i> Announcement</a>
        <a href="admin_officials.php"><i class="bi bi-people"></i> Officials</a>
        <a href="admin_issuance.php"><i class="bi bi-bookmark"></i> Issuance</a>

        <div class="dropdown-container">
          <button class="dropdown-btn">
              <i class="bi bi-file-earmark-text"></i> Records
              <i class="bi bi-caret-down-fill dropdown-arrow"></i>
          </button>
          <div class="dropdown-content">
              <a href="admin_rec_residents.php">Residents</a>
              <a href="admin_rec_complaints.php">Complaints</a>
              <a href="admin_rec_blotter.php">Blotter</a>
          </div>
      </div>

        <a href="../../backend/logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a>
    </div>
</div>

<div style="width:100%">

    <div class="header">
        <div class="hamburger" onclick="toggleSidebar()">☰</div>
        <h1 class="header-title"><span class="green">ANNOUNCEMENT</span></h1>

        <div class="header-logos">
            <img src="../../assets/img/barangaygusalogo.png">
            <img src="../../assets/img/cdologo.png">
        </div>
    </div>

    <div class="content">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

        <!-- Search Bar -->
        <div class="search-box">
            <input type="text" placeholder="Search for Document Type..." class="form-control">
            <button><i class="bi bi-search"></i></button>
        </div>

        <!-- Buttons: Add New + Archive -->
        <div class="mt-2 mt-md-0">
            <button class="btn btn-primary me-2"><i class="bi bi-plus-circle"></i> Add New</button>
            <button class="btn btn-secondary"><i class="bi bi-archive"></i> Archive</button>
        </div>

    <table>
        <tr>
            <th>Image</th>
            <th>Title</th>
            <th>Details</th>
            <th>Request Date</th>
            <th>Action</th>
        </tr>

        <tr>
            <td><img src="../../assets/img/announcement1.png" style="width: 300px; height: auto;"></td>
            <td>National Heroes Day</td>
            <td>National Heroes Day is a public holiday in the Philippines celebrated on the last Monday of August to honor the country's heroes.</td>
            <td>08/02/2025</td>
            <td>
                <button class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </td>
        </tr>

        <tr>
            <td><img src="../../assets/img/announcement2.png" style="width: 300px; height: auto;" /></td>
            <td>Higalaay Festival 2025</td>
            <td>The 2025 Higalaay Festival in Cagayan de Oro City ran throughout August with the theme "CDO@75: Proud of our Roots. Bold in our Dreams". </td>
            <td>08/03/2025</td>
            <td>
                <button class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </td>
        </tr>

        <tr>
            <td><img src="../../assets/img/announcement3.png" style="width: 300px; height: auto;" /></td>
            <td>Pamaskong Handog</td>
            <td>The City Government of Muntinlupa kicked off the distribution of its Pamaskong Handog, marking the third consecutive year of the city’s Christmas program that brings joy and assistance to Muntinlupeño families during the holiday season.</td>
            <td>08/04/2025</td>
            <td>
                <button class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
            </td>
        </tr>
    </table>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
}
document.querySelectorAll('.dropdown-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        this.parentElement.classList.toggle('active');
    });
});
</script>

</body>
</html>
