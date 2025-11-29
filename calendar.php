<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>BMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="icon" type="image/png" href="assets/img/BMS.png">
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<?php include 'includes/nav.php'; ?>

<section class="header-banner">
    <img src="assets/img/cdologo.png" class="left-logo" alt="left logo">
    <div class="header-text">
        <h1>Barangay</h1> 
        <h3>Calendar</h3>
    </div>
    <img src="assets/img/barangaygusalogo.png" class="right-logo" alt="right logo">
</section>

<section class="calendar-container container py-5">

    <div class="row">

        <div class="col-lg-7 col-md-12 mb-5">

            <h3 class="fw-bold mb-3">
                BARANGAY <span style="color:#3cbf4c;">CALENDAR</span>
                <span style="color:#8dc63f;">2025</span>
            </h3>

            <div class="calendar-header d-flex justify-content-between align-items-center mb-3">
                <button id="prev-month" class="nav-btn">&lt;</button>
                <h2 id="month-year" class="fw-bold"></h2>
                <button id="next-month" class="nav-btn">&gt;</button>
            </div>

            <div class="calendar-grid" id="calendar-grid"></div>

            <div id="event-labels" style="display:none;">

                <div data-day="3" class="event-label">
                    <span class="event-dot"></span> Clean-Up Drive
                </div>

                <div data-day="6" class="event-label">
                    <span class="event-dot"></span> Health Check-Up
                </div>

                <div data-day="9" class="event-label">
                    <span class="event-dot"></span> Seniors’ Assembly
                </div>

                <div data-day="12" class="event-label">
                    <span class="event-dot"></span> Sports League
                </div>

                <div data-day="22" class="event-label">
                    <span class="event-dot"></span> PWD Payout
                </div>

                <div data-day="24" class="event-label">
                    <span class="event-dot"></span> Tree Planting
                </div>

                <div data-day="31" class="event-label">
                    <span class="event-dot"></span> Halloween Party
                </div>

            </div>

        </div>

        <div class="col-lg-5 col-md-12">
            <h3 class="fw-bold mb-3">TIMELINE OF <span style="color:#3cbf4c;">EVENTS</span></h3>

            <ul class="timeline-list">

                <li>
                    <strong>Barangay Clean-Up Drive – Coastal & Riverside Areas</strong><br>
                    <small>October 3, 2025 (7:00 AM – 11:00 AM)</small>
                </li>

                <li>
                    <strong>Barangay Health Check-Up – Covered Court</strong><br>
                    <small>October 6, 2025</small>
                </li>

                <li>
                    <strong>Senior Citizens’ General Assembly – Barangay Hall</strong><br>
                    <small>October 9, 2025 (1:00 PM – 4:00 PM)</small>
                </li>

                <li>
                    <strong>Youth Sports League Opening – Gusa Covered Court</strong><br>
                    <small>October 12, 2025</small>
                </li>

                <li>
                    <strong>PWD Assistance Payout – Barangay Hall</strong><br>
                    <small>October 22, 2025 (10:00 AM – 3:00 PM)</small>
                </li>

                <li>
                    <strong>Tree Planting Activity – Near Coastal Highway</strong><br>
                    <small>October 24, 2025 (6:00 AM – 10:00 AM)</small>
                </li>

                <li>
                    <strong>Barangay Halloween Kids’ Party – Covered Court</strong><br>
                    <small>October 31, 2025 (3:00 PM – 6:00 PM)</small>
                </li>

            </ul>
        </div>

    </div>

</section>

<?php include('includes/footer.php'); ?>

<script src="assets/js/calendar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>