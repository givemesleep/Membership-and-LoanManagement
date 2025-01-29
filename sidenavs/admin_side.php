<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a <?php echo ($pages == 'index') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_index.php">
          <i class="bi bi-grid-fill"></i>
          <span>Dashboard</span>
        </a>
      </li>
      
      <li>
        <a <?php echo ($pages == 'viewpay') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_viewtrans.php">
          <i class="bi bi-collection"></i>
          <span>Member Account</span>
        </a>
      </li>

      <li class="nav-heading">Membership</li>

      <li class="nav-item">
        <a <?php echo ($pages == 'applications') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_addmem.php">
          <i class="bi bi-person-plus-fill"></i>
          <span>Create New Member</span>
        </a>
      </li>
<!--       
      <li class="nav-item">
        <a <?php echo ($pages == 'deathcare') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_deathcare.php">
          <i class="bi bi-person-plus-fill"></i>
          <span>Death Care Renewal</span>
        </a>
      </li> -->

      <li class="nav-item">
        <a <?php echo ($nav == 'membership') ? 'class="nav-link collapse"' : 'class="nav-link collapsed"' ?> data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-table"></i><span>Members Account</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" <?php echo ($nav == 'membership') ? 'class="nav-content collapse show"' : 'class="nav-content collapse"' ?> data-bs-parent="#sidebar-nav">
          <li>
            <a <?php echo ($pages == 'app') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_masterlist.php">
              <i class="bi bi-circle"></i><span>Member Masterlist</span>
            </a>
          </li>
          <li>
            <a <?php echo ($pages == 'pending') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="">
              <i class="bi bi-circle"></i><span>Member On-Going</span>
            </a>
          </li>
          <li>
            <a <?php echo ($pages == 'pending') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_pendings.php">
              <i class="bi bi-circle"></i><span>Member Schedule</span>
            </a>
          </li>
          <li>
            <a <?php echo ($pages == 'removed') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_removed.php">
              <i class="bi bi-circle"></i><span>Member Inactive</span>
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-heading">Add Transaction</li>

      <!-- <li class="nav-item">
        <a <?php echo ($nav == 'trans') ? 'class="nav-link collapse"' : 'class="nav-link collapsed"' ?> data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gem"></i><span>Transactions</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="icons-nav" <?php echo ($nav == 'trans') ? 'class="nav-content collapse show"' : 'class="nav-content collapse"' ?> data-bs-parent="#sidebar-nav">
          <li>
            <a <?php echo ($pages == 'viewpay') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_viewtrans.php">
              <i class="bi bi-circle"></i><span>View Payments</span>
            </a>
          </li>
          <li>
            <a <?php echo ($pages == 'cretdep') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_createdep.php">
              <i class="bi bi-circle"></i><span>Create Deposit</span>
            </a>
          </li>
          <li>
            <a <?php echo ($pages == 'cretloan') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_createloan.php">
              <i class="bi bi-circle"></i><span>Create Loan</span>
            </a>
          </li>
        </ul>
      </li> -->

      <li>
        <a <?php echo ($pages == 'payloan') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_lnpay.php">
          <i class="bi bi-plus"></i>
          <span>Loan Payment</span>
        </a>
      </li>

      <li>
        <a <?php echo ($pages == 'cretdep') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_createdep.php">
          <i class="bi bi-plus"></i>
          <span>Create Deposit</span>
        </a>
      </li>
      
      <li>
        <a <?php echo ($pages == 'cretloan') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_createloan.php">
          <i class="bi bi-plus"></i>
          <span>Create Loan</span>
        </a>
      </li>

      <!-- <li>
        <a <?php echo ($pages == 'lnpending') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_lnpending.php">
          <i class="bi bi-circle"></i>
          <span>Active Loan</span>
        </a>
      </li> -->

      <li class="nav-heading">Application</li>

      <li>
        <a <?php echo ($pages == 'lnactive') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_lnactive.php">
          <i class="bi bi-hourglass-split"></i>
          <span>Active Loan</span>
        </a>
      </li>
      
      <li>
        <a <?php echo ($pages == 'lnpending') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_lnpending.php">
          <i class="bi bi-hourglass-split"></i>
          <span>Pending Loan</span>
        </a>
      </li>

      <!-- <li class="nav-item">
        <a <?php echo ($nav == 'deptrans') ? 'class="nav-link collapse"' : 'class="nav-link collapsed"' ?> data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Deposit</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" <?php echo ($nav == 'deptrans') ? 'class="nav-content collapse show"' : 'class="nav-content collapse"' ?> data-bs-parent="#sidebar-nav">
          <li>
            <a <?php echo ($pages == 'credep') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_createdep.php">
              <i class="bi bi-circle"></i><span>Create Deposit</span>
            </a>
          </li>
          <li>
            <a <?php echo ($pages == 'checkdep') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_checkdep.php">
              <i class="bi bi-circle"></i><span>Check Deposit</span>
            </a>
          </li>   
        </ul>
      </li>

      <li class="nav-item">
        <a <?php echo ($nav == 'loantrans') ? 'class="nav-link collapse"' : 'class="nav-link collapsed"' ?> data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bar-chart"></i><span>Loan</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="charts-nav" <?php echo ($nav == 'loantrans') ? 'class="nav-content collapse show"' : 'class="nav-content collapse"' ?> data-bs-parent="#sidebar-nav">
        <li>
            <a href="forms-layouts.html">
              <i class="bi bi-circle"></i><span>Create Loan</span>
            </a>
          </li>
          <li>
            <a <?php echo ($pages == 'actLoan') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_actloan.php">
              <i class="bi bi-circle"></i><span>Active Loan</span>
            </a>
          </li>
          <li>
            <a <?php echo ($pages == 'pendLoan') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_penloan.php">
              <i class="bi bi-circle"></i><span>Pending Loan</span>
            </a>
          </li>
          <li>
            <a <?php echo ($pages == 'checkbal') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_checkdep.php">
              <i class="bi bi-circle"></i><span>Check Balance</span>
            </a>
          </li>
        </ul>
      </li> -->

      

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

      <!-- <li class="nav-heading">Transaction</li> -->

      <!-- <li class="nav-item">
        <a  href="loan_create.php">
          
          <i class="bi bi-layer-forward"></i>
          <span>Create Loan</span>
        </a>
      </li> -->

      

      <!-- <li class="nav-item">
        <a <?php //echo ($pages == 'tran') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_transaction.php?sel=1">
          <i class="bi bi-receipt-cutoff"></i>
          <span>Transaction Management</span>
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