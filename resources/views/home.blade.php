@extends('layouts.admin')

@section('main-content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ __('Hello') }} {{ Auth::user()->name }}!</h1>
    <a href="#" class="btn btn-success btn-icon-split"data-toggle="modal" data-target="#addExpenseModal">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Add Expense</span>
    </a>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show mb-2 mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row mt-2">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Earnings (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><input type="number" id="monthlyEarnings"
                                    class="form-control" value="{{ auth()->user()->monthly_earnings }}"
                                    onblur="updateEarnings()" /></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"> Expense (Monthly)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rs.{{ number_format($totalExpense) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Remaining (Monthly)</div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                        Rs.{{ number_format($remaining) }}</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ min($spendPercentage, 100) }}%"
                                            aria-valuenow="{{ $spendPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-bars-progress"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trend -->
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
                            <i class="fa-solid fa-arrow-trend-up"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <!-- Area chart example-->
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
        <div class="col-lg-4 mb-4">
            <!-- Progress card example-->
            <div class="card bg-primary border-0">
                <div class="card-body">
                    <h5 class="text-white-50">Spent Since Using This App</h5>
                    <div class="mb-4">
                        <span class="display-4 text-white">Rs. {{ number_format($all_time_expense, 0) }}</span>
                        <span class="text-white-50">till today</span>
                    </div>
                </div>
            </div>
            <div class="card shadow mt-4">
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
        <div class="col-lg-12 mb-4">
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
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($all_expense_user as $index => $expense)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td data-order="{{ $expense->amount }}">
                                            Rs. {{ number_format($expense->amount, 2) }}</td>
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
                                        <td>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-id="{{ $expense->id }}">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- add Expense Modal -->
    <div class="modal fade" id="addExpenseModal" tabindex="-1" role="dialog" aria-labelledby="addExpenseModalLabel"
        aria-hidden="true">
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
    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" id="deleteForm">
                @csrf
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this expense?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    {{-- <script src="{{ asset('js/sb-admin-2.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var deleteModal = document.getElementById('deleteModal');
            deleteModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var expenseId = button.getAttribute('data-id');

                // Update the form action dynamically (replace ':id' with actual expenseId)
                var form = document.getElementById('deleteForm');
                var action = "{{ route('expenses.destroy', ':id') }}";
                action = action.replace(':id', expenseId);
                form.action = action;
            });
        });
    </script>


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
                        backgroundColor: "rgb(0, 0, 0)",
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
                                const label = tooltipItem.label || '';
                                const value = Number(tooltipItem.raw);

                                if (!isNaN(value)) {
                                    return `${value.toFixed(2)}`;
                                }

                                // fallback for non-numeric strings
                                return `${tooltipItem.raw}`;
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
                maintainAspectRatio: false,
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
@endsection
