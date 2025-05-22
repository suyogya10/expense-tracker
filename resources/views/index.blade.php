<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Expense Tracker</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <div class="container">
                        <h5>Expense Tracker</h5>
                    </div>
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <!-- Use a button for the logout action -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </li>


                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Page Heading -->
                    <div class="row">
                        <h1 class="h3 mb-2 text-gray-800">Dashboard</h1>
                        <a href="#" class="btn btn-success btn-icon-split" style="margin-left: 10px;"
                            data-toggle="modal" data-target="#addExpenseModal">
                            <span class="icon text-white-50">
                                <i class="fas fa-plus"></i>
                            </span>
                            <span class="text">Add Expense</span>
                        </a>
                    </div>

                    <!-- Content Row -->
                    <div class="row mt-3">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Earnings (Monthly)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <input type="number" id="monthlyEarnings" class="form-control"
                                                    value="{{ auth()->user()->monthly_earnings }}"
                                                    onblur="updateEarnings()" />
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- expense (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Expense (Monthly)</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">रु{{ $totalExpense }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Remaining (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Remaining (Monthly)</div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                        रु{{ $remaining }}</div>
                                                </div>
                                                <div class="col">
                                                    <div class="progress progress-sm mr-2">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width: {{ min($spendPercentage, 100) }}%"
                                                            aria-valuenow="{{ $spendPercentage }}" aria-valuemin="0"
                                                            aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Expense Trend Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Expense Trend</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $trend }}
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-xl-8 col-lg-7">
                            <!-- Area Chart -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-danger">Expense Trend (All Time)</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-area">
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Donut Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-info">Category Wise Expense (This Month)</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-warning">
                                Recent Expenses
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>S.N.</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Category</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($all_expense_user as $index => $expense)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td data-order="{{ $expense->amount }}">
                                                    ₹{{ number_format($expense->amount, 2) }}</td>
                                                <td>{{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}</td>
                                                <!-- Format date -->
                                                <td>
                                                    @switch($expense->category_id)
                                                        @case(1)
                                                            Food
                                                        @break

                                                        @case(2)
                                                            Transport
                                                        @break

                                                        @case(3)
                                                            Bills
                                                        @break

                                                        @case(4)
                                                            Shopping
                                                        @break

                                                        @case(5)
                                                            IT & Electronics
                                                        @break

                                                        @case(99)
                                                            Other
                                                        @break

                                                        @default
                                                            N/A
                                                    @endswitch
                                                </td>
                                                <td>{{ $expense->description ?? 'N/A' }}</td>
                                                <!-- Assuming a description field -->
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Suyogya Gautam 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- add Expense Modal -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog"
        aria-labelledby="addExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExpenseModalLabel">Add New Expense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="expenseForm" method="POST" action="{{ route('expenses.store') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="expenseDate">Date</label>
                            <input type="date" class="form-control" id="expenseDate" name="date" required>
                        </div>
                        <div class="form-group">
                            <label for="expenseAmount">Amount</label>
                            <input type="number" class="form-control" id="expenseAmount" name="amount" required>
                        </div>
                        <div class="form-group">
                            <label for="expenseCategory">Category</label>
                            <select class="form-control" id="expenseCategory" name="category" required>
                                <option value="" disabled selected>Select Category</option>
                                <option value="1">Food</option>
                                <option value="2">Transport</option>
                                <option value="3">Bills</option>
                                <option value="4">Shopping</option>
                                <option value="5">IT & Electronics</option>
                                <option value="99">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="expenseDescription">Description</label>
                            <textarea class="form-control" id="expenseDescription" name="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Expense</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateEarnings() {
            const earnings = document.getElementById('monthlyEarnings').value;

            fetch('{{ route('user.updateEarnings') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        earnings: earnings
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // alert('Earnings updated successfully!');
                        window.location.reload();
                    } else {
                        alert('Failed to update earnings.');
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>


    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript -->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>

    <!-- Custom scripts for all pages -->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
    <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>


    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script>
        // Get the category and amount data passed from the controller
        var categories = @json($categories); // Category IDs
        var amounts = @json($amounts); // Total amounts per category

        // Map the category IDs to category names for better readability
        var categoryNames = {
            1: "Food",
            2: "Transport",
            3: "Bills",
            4: "Shopping",
            5: "IT & Electronics",
            99: "Other"
        };

        // Map categories to their corresponding names
        var categoryLabels = categories.map(function(id) {
            return categoryNames[id] || 'Unknown'; // Handle unknown category IDs
        });

        // Setup the chart data
        var chartData = {
            labels: categoryLabels, // Use category names as labels
            datasets: [{
                label: 'Category-wise Expenses',
                data: amounts,
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
                borderColor: '#fff',
                borderWidth: 2
            }]
        };

        // Create the Doughnut chart
        var ctx = document.getElementById('myPieChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false, // To allow the chart to adjust size dynamically
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                family: "'Nunito', sans-serif",
                                size: 14
                            },
                            color: "#858796",
                        }
                    },
                    tooltip: {
                        backgroundColor: "rgb(255, 255, 255)",
                        bodyFontColor: "#858796",
                        titleMarginBottom: 10,
                        titleFontColor: "#6e707e",
                        titleFontSize: 14,
                        borderColor: "#dddfeb",
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        intersect: false,
                        mode: "index",
                        caretPadding: 10,
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2);
                            }
                        }
                    }
                }
            }
        });
    </script>

    <script>
        // Data for the chart (from the controller)
        var months = @json($months); // Array of months
        var expensesData = @json($expensesData); // Array of total expenses

        var ctx = document.getElementById('myAreaChart').getContext('2d');
        var myAreaChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months.map(month => moment().month(month - 1).format(
                    'MMMM')), // Convert month number to month name
                datasets: [{
                    label: 'Monthly Expenses',
                    data: expensesData,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(78, 115, 223, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                var value = context.raw;
                                return 'Expense: ' + value.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        ticks: {
                            beginAtZero: true,
                            callback: function(value) {
                                return value.toLocaleString(); // Add thousands separator
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
