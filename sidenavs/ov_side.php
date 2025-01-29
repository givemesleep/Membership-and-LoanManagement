<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
        <a <?php echo ($pages == 'index') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="index.php">
          <i class="bi bi-grid-fill"></i>
          <span>Dashboard</span>
        </a>
      </li>      
        
      <li class="nav-heading">Membership</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="apply_application.php">
          <i class="bi bi-person-plus-fill"></i>
          <span>Create New Application</span>
        </a>
      </li>

      <li class="nav-item">
        <a  <?php echo ($pages == 'app') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="membership_tables.php?sel=1">
          <i class="bi bi-person-check-fill"></i>
          <span>Membership Accounts</span>
        </a>
      </li>

      <!-- <li class="nav-item">
        <a  <?php //echo ($pages == 'app') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="applicant_approved.php">
          <i class="bi bi-person-check-fill"></i>
          <span>Non-Member Applications</span>
        </a>    
      </li> -->

      <!-- <li class="nav-item">
        <a <?php //echo ($pages == 'pendings') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="applicant_pendings.php">
          <i class="ri-calendar-schedule-fill"></i>
          <span>Pending Applications</span>
        </a>
      </li> -->

      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="applicant_ongoing.php">
          <i class="bi bi-hourglass-split"></i>
          <span>On-Going Application</span>
        </a>
      </li> -->

      <!-- <li class="nav-heading">General Transaction</li> -->

      <!-- <li class="nav-item">
        <a  href="loan_create.php">
          
          <i class="bi bi-layer-forward"></i>
          <span>Create Loan</span>
        </a>
      </li> -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="applicant_approved.php">
          <i class="bi bi-clock-fill"></i>
          <span>Pending Loan</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="applicant_approved.php">
          <i class="bi bi-patch-check-fill"></i>
          <span>Active Loan</span>
        </a>
      </li>

      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="applicant_approved.php">
          <i class="bi bi-receipt-cutoff"></i>
          <span>Loan History</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="applicant_approved.php">
          <i class="bi bi-receipt-cutoff"></i>
          <span>Deposit History</span>
        </a>
      </li> -->

      <!-- <li class="nav-heading">System Maintenance</li> -->

      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="applicant_approved.php">
          <i class="bi bi-table"></i>
          <span>Membership Masterlist</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="applicant_approved.php">
          <i class="bi bi-table"></i>
          <span>Transaction Log</span>
        </a>
      </li> -->

      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="applicant_approved.php">
          <i class="bi bi-table"></i>
          <span>Non-Member Masterlist</span>
        </a>
      </li> -->

      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="applicant_approved.php">
          <i class="bi bi-table"></i>
          <span>Remove Account Masterlist</span>
        </a>
      </li> -->

      <!-- <li class="nav-item">
        <a <?php //echo ($pages == 'loanrates') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="main_loanrates.php">
          <i class="bi bi-table"></i>
          <span>Loan Rates</span>
        </a>
      </li> -->

      

    </ul>
  </aside>