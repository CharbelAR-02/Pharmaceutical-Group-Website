@auth
    @if (Auth::user()->role === 'customer' || Auth::user()->role === 'pharmacist')
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block sidebar">
            <div class="position-sticky h-100">
                <ul class="nav flex-column">
                    <!-- Add sidebar navigation links here -->
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ Route::is('shop') ? 'active-side-link' : '' }}"
                            href="{{ route('shop', ['id' => Auth::user()->id]) }}">
                            <i class="bi-house-door"></i> Shop Here
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ Route::is('cart.index') ? 'active-side-link' : '' }}"
                            href="{{ route('cart.index', ['id' => Auth::user()->id]) }}">
                            <i class="bi-house-door"></i> Cart
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark {{ Route::is('customer.commands.show') ? 'active-side-link' : '' }}"
                            href="{{ route('customer.commands.show', ['id' => Auth::user()->id]) }}">
                            <i class="bi-house-door"></i> My Commands
                        </a>
                    </li>
                    @if (Auth::user()->role === 'pharmacist')
                        <li class="nav-item">
                            <a class="nav-link text-dark {{ Route::is('depot.index') ? 'active-side-link' : '' }}"
                                href="{{ route('depot.index', ['id' => Auth::user()->id]) }}">
                                <i class="bi-house-door"></i> Depot
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark {{ Route::is('supplier.command.form.show') ? 'active-side-link' : '' }}"
                                href="{{ route('supplier.command.form.show', ['id' => Auth::user()->id]) }}">
                                <i class="bi-house-door"></i>make supplier command
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark {{ Route::is('pharmacist.supplier.commands.show') ? 'active-side-link' : '' }}"
                                href="{{ route('pharmacist.supplier.commands.show', ['id' => Auth::user()->id]) }}">
                                <i class="bi-house-door"></i>supplier commands
                            </a>
                        </li>
                    @endif

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
        z-index: 1;
        /* Ensure it's above the content */
        padding-top: 20px;
        /* Add padding to align content properly */
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
