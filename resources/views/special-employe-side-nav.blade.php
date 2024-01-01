@auth
    @if (Auth::user()->role === 'special_employe')
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar side-nav" style="background-color: #B3E0F2">
            <div class="position-sticky h-100">
                <ul class="nav flex-column">
                    <!-- Add sidebar navigation links here -->
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ Route::is('pharmacies.show') ? 'active-side-link' : '' }}"
                            href="{{ route('pharmacies.show', ['id' => Auth::user()->id]) }}">
                            <i class="bi-house-door"></i> Pharmacies
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ Route::is('pharmacists.show') ? 'active-side-link' : '' }}"
                            href="{{ route('pharmacists.show', ['id' => Auth::user()->id]) }}">
                            <i class="bi-person"></i> Pharmacists
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ Route::is('customers.show') ? 'active-side-link' : '' }} nav-link"
                            href="{{ route('customers.show', ['id' => Auth::user()->id]) }}">
                            <i class="bi-people"></i> Customers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ Route::is('specialEmployes.show') ? 'active-side-link' : '' }}"
                            href="{{ route('specialEmployes.show', ['id' => Auth::user()->id]) }}">
                            <i class="bi-gear"></i> Special Employes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ Route::is('commands.show') ? 'active-side-link' : '' }}"
                            href="{{ route('commands.show', ['id' => Auth::user()->id]) }}">
                            <i class="bi-gear"></i> Commands
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ Route::is('baseDepot.show') ? 'active-side-link' : '' }}"
                            href="{{ route('baseDepot.show', ['id' => Auth::user()->id]) }}">
                            <i class="bi-gear"></i>Depot
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ Route::is('supplier.command.form.show') ? 'active-side-link' : '' }}"
                            href="{{ route('supplier.command.form.show', ['id' => Auth::user()->id]) }}">
                            <i class="bi-gear"></i>make supplier command
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ Route::is('suppliers.show') ? 'active-side-link' : '' }}"
                            href="{{ route('suppliers.show', ['id' => Auth::user()->id]) }}">
                            <i class="bi-gear"></i> Suppliers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ Route::is('supplier.commands.show') ? 'active-side-link' : '' }}"
                            href="{{ route('supplier.commands.show', ['id' => Auth::user()->id]) }}">
                            <i class="bi-gear"></i> Supplier Commands
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    @endif
@endauth

<style>
    #sidebar {
        background-color: #B3E0F2;
        position: fixed;
        /* Fixed position so it remains visible while scrolling */
        height: 100%;
        /* Make the sidebar full height */
        width: 250px;
        /* Adjust the width as needed */
        transition: width 0.3s ease;
        /* Add smooth transition for width changes */
        /* Ensure it's above the content */
        padding-top: 20px;
        /* Add padding to align content properly */


        position: fixed;
        top: 50px;
        left: 0;
        z-index: 1100;
    }

    /* Style sidebar links */
    #sidebar .nav-link {
        color: #000;
        /* Text color for links */
        padding: 10px 20px;
        /* Add padding to the links */
    }

    /* Sidebar hover effect */
    #sidebar .nav-item:hover .nav-link {
        background-color: #f2f2f2;
        /* Hover background color */
        color: #fff;
        /* Text color on hover */
    }

    /* Adjust the sidebar width when collapsed */
    #sidebar.collapsed {
        width: 80px;
        /* Adjust the collapsed width as needed */
    }

    /* Style for the sidebar toggle button (if used) */

    .active-side-link {
        background-color: #FFFFCC;
        /* Light blue background color */
        color: #000;
        /* Black text color */
        border-radius: 10px;
        /* Rounded corners if desired */
    }
</style>
