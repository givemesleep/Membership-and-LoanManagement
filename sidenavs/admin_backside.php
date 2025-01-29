<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a <?php echo ($pages == 'Account') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_backoffice.php?pages=Account">
          <i class="bi bi-person-circle"></i>
          <span>Account</span>
        </a>
      </li>

      <li class="nav-item">
        <a <?php echo ($pages == 'AddUser') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_backoffice.php?pages=AddUser">
          <i class="bi bi-person-fill-add"></i>
          <span>Add User</span>
        </a>
      </li>

      <li class="nav-item">
        <a <?php echo ($pages == 'EditUser') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_backoffice.php?pages=EditUser">
          <i class="bi bi-person-gear"></i>
          <span>Edit User</span>
        </a>
      </li>

      <li class="nav-item">
        <a <?php echo ($pages == 'LoanArchive') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_backoffice.php?pages=LoanArchive">
          <i class="bi bi-archive-fill"></i>
          <span>Loan Archive</span>
        </a>
      </li>

      <li class="nav-item">
        <a <?php echo ($pages == 'BackUp') ? 'class="nav-link "' : 'class="nav-link collapsed"' ?> href="admin_backoffice.php?pages=BackUp">
          <i class="bi bi-database-fill-up"></i>
          <span>Database Back-up</span>
        </a>
      </li>

    </ul>
  </aside>