

@extends('admin.app')
@section('content')



			<!-- CONTENT WRAPPER -->
			<div class="ec-content-wrapper">
				<div class="content">
					<!-- Top Statistics -->
					<div class="row">
						<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-1">
								<div class="card-body">
									<h2 class="mb-1">1,503</h2>
									<p>Daily Signups</p>
									<span class="mdi mdi-account-arrow-left"></span>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-2">
								<div class="card-body">
									<h2 class="mb-1">79,503</h2>
									<p>Daily Visitors</p>
									<span class="mdi mdi-account-clock"></span>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-3">
								<div class="card-body">
									<h2 class="mb-1">15,503</h2>
									<p>Daily Order</p>
									<span class="mdi mdi-package-variant"></span>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 p-b-15 lbl-card">
							<div class="card card-mini dash-card card-4">
								<div class="card-body">
									<h2 class="mb-1">$98,503</h2>
									<p>Daily Revenue</p>
									<span class="mdi mdi-currency-usd"></span>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xl-8 col-md-12 p-b-15">
							<!-- Sales Graph -->
							<div id="user-acquisition" class="card card-default">
								<div class="card-header">
									<h2>Sales Report</h2>
								</div>
								<div class="card-body">
									<ul class="nav nav-tabs nav-style-border justify-content-between justify-content-lg-start border-bottom"
										role="tablist">
										<li class="nav-item">
											<a class="nav-link active" data-bs-toggle="tab" href="#todays" role="tab"
												aria-selected="true">Today's</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-bs-toggle="tab" href="#monthly" role="tab"
												aria-selected="false">Monthly </a>
										</li>
										<li class="nav-item">
											<a class="nav-link" data-bs-toggle="tab" href="#yearly" role="tab"
												aria-selected="false">Yearly</a>
										</li>
									</ul>
									<div class="tab-content pt-4" id="salesReport">
										<div class="tab-pane fade show active" id="source-medium" role="tabpanel">
											<div class="mb-6" style="max-height:247px">
												<canvas id="acquisition" class="chartjs2"></canvas>
												<div id="acqLegend" class="customLegend mb-2"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xl-4 col-md-12 p-b-15">
							<!-- Doughnut Chart -->
							<div class="card card-default">
								<div class="card-header justify-content-center">
									<h2>Orders Overview</h2>
								</div>
								<div class="card-body">
									<canvas id="doChart"></canvas>
								</div>
								<a href="#" class="pb-5 d-block text-center text-muted"><i
										class="mdi mdi-download mr-2"></i> Download overall report</a>
								<div class="card-footer d-flex flex-wrap bg-white p-0">
									<div class="col-6">
										<div class="p-20">
											<ul class="d-flex flex-column justify-content-between">
												<li class="mb-2"><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
														style="color: #4c84ff"></i>Order Completed</li>
												<li class="mb-2"><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
														style="color: #80e1c1 "></i>Order Unpaid</li>
												<li><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
														style="color: #ff7b7b "></i>Order returned</li>
											</ul>
										</div>
									</div>
									<div class="col-6 border-left">
										<div class="p-20">
											<ul class="d-flex flex-column justify-content-between">
												<li class="mb-2"><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
														style="color: #8061ef"></i>Order Pending</li>
												<li class="mb-2"><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
														style="color: #ffa128"></i>Order Canceled</li>
												<li><i class="mdi mdi-checkbox-blank-circle-outline mr-2"
														style="color: #7be6ff"></i>Order Broken</li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xl-8 col-md-12 p-b-15">
							<!-- User activity statistics -->
							<div class="card card-default" id="user-activity">
								<div class="no-gutters">
									<div>
										<div class="card-header justify-content-between">
											<h2>User Activity</h2>
											<div class="date-range-report ">
												<span></span>
											</div>
										</div>
										<div class="card-body">
											<div class="tab-content" id="userActivityContent"> 
												<div class="tab-pane fade show active" id="user" role="tabpanel">
													<canvas id="activity" class="chartjs"></canvas>
												</div>
											</div>
										</div>
										<div class="card-footer d-flex flex-wrap bg-white border-top">
											<a href="#" class="text-uppercase py-3">In-Detail Overview</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-md-12 p-b-15">
							<div class="card card-default">
								<div class="card-header flex-column align-items-start">
									<h2>Current Users</h2>
								</div>
								<div class="card-body">
									<canvas id="currentUser" class="chartjs"></canvas>
								</div>
								<div class="card-footer d-flex flex-wrap bg-white border-top">
									<a href="#" class="text-uppercase py-3">In-Detail Overview</a>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xl-8 col-12 p-b-15">
							<!-- World Chart -->
							<div class="card card-default" id="analytics-country">
								<div class="card-header justify-content-between">
									<h2>Purchased by Country</h2>
									<div class="date-range-report ">
										<span></span>
									</div>
								</div>
								<div class="card-body vector-map-world-2">
									<div id="regions_purchase" style="height: 100%; width: 100%;"></div>
								</div>
								<div class="border-top mt-3">
									<div class="row no-gutters">
										<div class="col-lg-6">
											<div class="world-data-chart border-bottom pt-15px pb-15px">
												<canvas id="hbar1" class="chartjs"></canvas>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="world-data-chart pt-15px pb-15px">
												<canvas id="hbar2" class="chartjs"></canvas>
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer d-flex flex-wrap bg-white">
									<a href="#" class="text-uppercase py-3">In-Detail Overview</a>
								</div>
							</div>
						</div>
						<div class="col-xl-4 col-12 p-b-15">
							<!-- Top Sell Table -->
							<div class="card card-default Sold-card-table">
								<div class="card-header justify-content-between">
									<h2>Sold by Items</h2>
									<div class="tools">
										<button class="text-black-50 mr-2 font-size-20"><i
												class="mdi mdi-cached"></i></button>
										<div class="dropdown show d-inline-block widget-dropdown">
											<a class="dropdown-toggle icon-burger-mini" href="#" role="button"
												id="dropdown-units" data-bs-toggle="dropdown" aria-haspopup="true"
												aria-expanded="false" data-display="static"></a>
											<ul class="dropdown-menu dropdown-menu-right">
												<li class="dropdown-item"><a href="#">Action</a></li>
												<li class="dropdown-item"><a href="#">Another action</a></li>
												<li class="dropdown-item"><a href="#">Something else here</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="card-body py-0 compact-units" data-simplebar style="height: 534px;">
									<table class="table ">
										<tbody>
											<tr>
												<td class="text-dark">Backpack</td>
												<td class="text-center">9</td>
												<td class="text-right">33% <i
														class="mdi mdi-arrow-up-bold text-success pl-1 font-size-12"></i>
												</td>
											</tr>
											<tr>
												<td class="text-dark">T-Shirt</td>
												<td class="text-center">6</td>
												<td class="text-right">150% <i
														class="mdi mdi-arrow-up-bold text-success pl-1 font-size-12"></i>
												</td>
											</tr>
											<tr>
												<td class="text-dark">Coat</td>
												<td class="text-center">3</td>
												<td class="text-right">50% <i
														class="mdi mdi-arrow-up-bold text-success pl-1 font-size-12"></i>
												</td>
											</tr>
											<tr>
												<td class="text-dark">Necklace</td>
												<td class="text-center">7</td>
												<td class="text-right">150% <i
														class="mdi mdi-arrow-up-bold text-success pl-1 font-size-12"></i>
												</td>
											</tr>
											<tr>
												<td class="text-dark">Jeans Pant</td>
												<td class="text-center">10</td>
												<td class="text-right">300% <i
														class="mdi mdi-arrow-down-bold text-danger pl-1 font-size-12"></i>
												</td>
											</tr>
											<tr>
												<td class="text-dark">Shoes</td>
												<td class="text-center">5</td>
												<td class="text-right">100% <i
														class="mdi mdi-arrow-up-bold text-success pl-1 font-size-12"></i>
												</td>
											</tr>
											<tr>
												<td class="text-dark">T-Shirt</td>
												<td class="text-center">6</td>
												<td class="text-right">150% <i
														class="mdi mdi-arrow-up-bold text-success pl-1 font-size-12"></i>
												</td>
											</tr>
											<tr>
												<td class="text-dark">Watches</td>
												<td class="text-center">18</td>
												<td class="text-right">160% <i
														class="mdi mdi-arrow-up-bold text-success pl-1 font-size-12"></i>
												</td>
											</tr>
											<tr>
												<td class="text-dark">Inner</td>
												<td class="text-center">156</td>
												<td class="text-right">120% <i
														class="mdi mdi-arrow-up-bold text-success pl-1 font-size-12"></i>
												</td>
											</tr>
											<tr>
												<td class="text-dark">T-Shirt</td>
												<td class="text-center">6</td>
												<td class="text-right">150% <i
														class="mdi mdi-arrow-up-bold text-success pl-1 font-size-12"></i>
												</td>
											</tr>
										</tbody>
									</table>

								</div>
								<div class="card-footer d-flex flex-wrap bg-white">
									<a href="#" class="text-uppercase py-3">View Report</a>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12 p-b-15">
							<!-- Recent Order Table -->
							<div class="card card-table-border-none card-default recent-orders" id="recent-orders">
								<div class="card-header justify-content-between">
									<h2>Recent Orders</h2>
									<div class="date-range-report">
										<span></span>
									</div>
								</div>
								<div class="card-body pt-0 pb-5">
									<table class="table card-table table-responsive table-responsive-large"
										style="width:100%">
										<thead>
											<tr>
												<th>Order ID</th>
												<th>Product Name</th>
												<th class="d-none d-lg-table-cell">Units</th>
												<th class="d-none d-lg-table-cell">Order Date</th>
												<th class="d-none d-lg-table-cell">Order Cost</th>
												<th>Status</th>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>24541</td>
												<td>
													<a class="text-dark" href=""> Coach Swagger</a>
												</td>
												<td class="d-none d-lg-table-cell">1 Unit</td>
												<td class="d-none d-lg-table-cell">Oct 20, 2018</td>
												<td class="d-none d-lg-table-cell">$230</td>
												<td>
													<span class="badge badge-success">Completed</span>
												</td>
												<td class="text-right">
													<div class="dropdown show d-inline-block widget-dropdown">
														<a class="dropdown-toggle icon-burger-mini" href=""
															role="button" id="dropdown-recent-order1"
															data-bs-toggle="dropdown" aria-haspopup="true"
															aria-expanded="false" data-display="static"></a>
														<ul class="dropdown-menu dropdown-menu-right">
															<li class="dropdown-item">
																<a href="#">View</a>
															</li>
															<li class="dropdown-item">
																<a href="#">Remove</a>
															</li>
														</ul>
													</div>
												</td>
											</tr>
											<tr>
												<td>24541</td>
												<td>
													<a class="text-dark" href=""> Toddler Shoes, Gucci Watch</a>
												</td>
												<td class="d-none d-lg-table-cell">2 Units</td>
												<td class="d-none d-lg-table-cell">Nov 15, 2018</td>
												<td class="d-none d-lg-table-cell">$550</td>
												<td>
													<span class="badge badge-primary">Delayed</span>
												</td>
												<td class="text-right">
													<div class="dropdown show d-inline-block widget-dropdown">
														<a class="dropdown-toggle icon-burger-mini" href="#"
															role="button" id="dropdown-recent-order2"
															data-bs-toggle="dropdown" aria-haspopup="true"
															aria-expanded="false" data-display="static"></a>
														<ul class="dropdown-menu dropdown-menu-right">
															<li class="dropdown-item">
																<a href="#">View</a>
															</li>
															<li class="dropdown-item">
																<a href="#">Remove</a>
															</li>
														</ul>
													</div>
												</td>
											</tr>
											<tr>
												<td>24541</td>
												<td>
													<a class="text-dark" href=""> Hat Black Suits</a>
												</td>
												<td class="d-none d-lg-table-cell">1 Unit</td>
												<td class="d-none d-lg-table-cell">Nov 18, 2018</td>
												<td class="d-none d-lg-table-cell">$325</td>
												<td>
													<span class="badge badge-warning">On Hold</span>
												</td>
												<td class="text-right">
													<div class="dropdown show d-inline-block widget-dropdown">
														<a class="dropdown-toggle icon-burger-mini" href="#"
															role="button" id="dropdown-recent-order3"
															data-bs-toggle="dropdown" aria-haspopup="true"
															aria-expanded="false" data-display="static"></a>
														<ul class="dropdown-menu dropdown-menu-right">
															<li class="dropdown-item">
																<a href="#">View</a>
															</li>
															<li class="dropdown-item">
																<a href="#">Remove</a>
															</li>
														</ul>
													</div>
												</td>
											</tr>
											<tr>
												<td>24541</td>
												<td>
													<a class="text-dark" href=""> Backpack Gents, Swimming Cap Slin</a>
												</td>
												<td class="d-none d-lg-table-cell">5 Units</td>
												<td class="d-none d-lg-table-cell">Dec 13, 2018</td>
												<td class="d-none d-lg-table-cell">$200</td>
												<td>
													<span class="badge badge-success">Completed</span>
												</td>
												<td class="text-right">
													<div class="dropdown show d-inline-block widget-dropdown">
														<a class="dropdown-toggle icon-burger-mini" href="#"
															role="button" id="dropdown-recent-order4"
															data-bs-toggle="dropdown" aria-haspopup="true"
															aria-expanded="false" data-display="static"></a>
														<ul class="dropdown-menu dropdown-menu-right">
															<li class="dropdown-item">
																<a href="#">View</a>
															</li>
															<li class="dropdown-item">
																<a href="#">Remove</a>
															</li>
														</ul>
													</div>
												</td>
											</tr>
											<tr>
												<td>24541</td>
												<td>
													<a class="text-dark" href=""> Speed 500 Ignite</a>
												</td>
												<td class="d-none d-lg-table-cell">1 Unit</td>
												<td class="d-none d-lg-table-cell">Dec 23, 2018</td>
												<td class="d-none d-lg-table-cell">$150</td>
												<td>
													<span class="badge badge-danger">Cancelled</span>
												</td>
												<td class="text-right">
													<div class="dropdown show d-inline-block widget-dropdown">
														<a class="dropdown-toggle icon-burger-mini" href="#"
															role="button" id="dropdown-recent-order5"
															data-bs-toggle="dropdown" aria-haspopup="true"
															aria-expanded="false" data-display="static"></a>
														<ul class="dropdown-menu dropdown-menu-right">
															<li class="dropdown-item">
																<a href="#">View</a>
															</li>
															<li class="dropdown-item">
																<a href="#">Remove</a>
															</li>
														</ul>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xl-5">
							<!-- New Customers -->
							<div class="card ec-cust-card card-table-border-none card-default">
								<div class="card-header justify-content-between ">
									<h2>New Customers</h2>
									<div>
										<button class="text-black-50 mr-2 font-size-20">
											<i class="mdi mdi-cached"></i>
										</button>
										<div class="dropdown show d-inline-block widget-dropdown">
											<a class="dropdown-toggle icon-burger-mini" href="#" role="button"
												id="dropdown-customar" data-bs-toggle="dropdown" aria-haspopup="true"
												aria-expanded="false" data-display="static">
											</a>
											<ul class="dropdown-menu dropdown-menu-right">
												<li class="dropdown-item"><a href="#">Action</a></li>
												<li class="dropdown-item"><a href="#">Another action</a></li>
												<li class="dropdown-item"><a href="#">Something else here</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="card-body pt-0 pb-15px">
									<table class="table ">
										<tbody>
											<tr>
												<td>
													<div class="media">
														<div class="media-image mr-3 rounded-circle">
															<a href="profile.html"><img
																	class="profile-img rounded-circle w-45"
																	src="assets/img/user/u1.jpg"
																	alt="customer image"></a>
														</div>
														<div class="media-body align-self-center">
															<a href="profile.html">
																<h6 class="mt-0 text-dark font-weight-medium">Selena
																	Wagner</h6>
															</a>
															<small>@selena.oi</small>
														</div>
													</div>
												</td>
												<td>2 Orders</td>
												<td class="text-dark d-none d-md-block">$150</td>
											</tr>
											<tr>
												<td>
													<div class="media">
														<div class="media-image mr-3 rounded-circle">
															<a href="profile.html"><img
																	class="profile-img rounded-circle w-45"
																	src="assets/img/user/u2.jpg"
																	alt="customer image"></a>
														</div>
														<div class="media-body align-self-center">
															<a href="profile.html">
																<h6 class="mt-0 text-dark font-weight-medium">Walter
																	Reuter</h6>
															</a>
															<small>@walter.me</small>
														</div>
													</div>
												</td>
												<td>5 Orders</td>
												<td class="text-dark d-none d-md-block">$200</td>
											</tr>
											<tr>
												<td>
													<div class="media">
														<div class="media-image mr-3 rounded-circle">
															<a href="profile.html"><img
																	class="profile-img rounded-circle w-45"
																	src="assets/img/user/u3.jpg"
																	alt="customer image"></a>
														</div>
														<div class="media-body align-self-center">
															<a href="profile.html">
																<h6 class="mt-0 text-dark font-weight-medium">Larissa
																	Gebhardt</h6>
															</a>
															<small>@larissa.gb</small>
														</div>
													</div>
												</td>
												<td>1 Order</td>
												<td class="text-dark d-none d-md-block">$50</td>
											</tr>
											<tr>
												<td>
													<div class="media">
														<div class="media-image mr-3 rounded-circle">
															<a href="profile.html"><img
																	class="profile-img rounded-circle w-45"
																	src="assets/img/user/u4.jpg"
																	alt="customer image"></a>
														</div>
														<div class="media-body align-self-center">
															<a href="profile.html">
																<h6 class="mt-0 text-dark font-weight-medium">Albrecht
																	Straub</h6>
															</a>
															<small>@albrech.as</small>
														</div>
													</div>
												</td>
												<td>2 Orders</td>
												<td class="text-dark d-none d-md-block">$100</td>
											</tr>
											<tr>
												<td>
													<div class="media">
														<div class="media-image mr-3 rounded-circle">
															<a href="profile.html"><img
																	class="profile-img rounded-circle w-45"
																	src="assets/img/user/u5.jpg"
																	alt="customer image"></a>
														</div>
														<div class="media-body align-self-center">
															<a href="profile.html">
																<h6 class="mt-0 text-dark font-weight-medium">Leopold
																	Ebert</h6>
															</a>
															<small>@leopold.et</small>
														</div>
													</div>
												</td>
												<td>1 Order</td>
												<td class="text-dark d-none d-md-block">$60</td>
											</tr>
											<tr>
												<td>
													<div class="media">
														<div class="media-image mr-3 rounded-circle">
															<a href="profile.html"><img
																	class="profile-img rounded-circle w-45"
																	src="assets/img/user/u3.jpg"
																	alt="customer image"></a>
														</div>
														<div class="media-body align-self-center">
															<a href="profile.html">
																<h6 class="mt-0 text-dark font-weight-medium">Larissa
																	Gebhardt</h6>
															</a>
															<small>@larissa.gb</small>
														</div>
													</div>
												</td>
												<td>1 Order</td>
												<td class="text-dark d-none d-md-block">$50</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>

						<div class="col-xl-7">
							<!-- Top Products -->
							<div class="card card-default ec-card-top-prod">
								<div class="card-header justify-content-between">
									<h2>Top Products</h2>
									<div>
										<button class="text-black-50 mr-2 font-size-20"><i
												class="mdi mdi-cached"></i></button>
										<div class="dropdown show d-inline-block widget-dropdown">
											<a class="dropdown-toggle icon-burger-mini" href="#" role="button"
												id="dropdown-product" data-bs-toggle="dropdown" aria-haspopup="true"
												aria-expanded="false" data-display="static">
											</a>
											<ul class="dropdown-menu dropdown-menu-right">
												<li class="dropdown-item"><a href="#">Update Data</a></li>
												<li class="dropdown-item"><a href="#">Detailed Log</a></li>
												<li class="dropdown-item"><a href="#">Statistics</a></li>
												<li class="dropdown-item"><a href="#">Clear Data</a></li>
											</ul>
										</div>
									</div>
								</div>
								<div class="card-body mt-10px mb-10px py-0">
									<div class="row media d-flex pt-15px pb-15px">
										<div
											class="col-lg-3 col-md-3 col-2 media-image align-self-center rounded">
											<a href="#"><img src="assets/img/products/p1.jpg" alt="customer image"></a>
										</div>
										<div class="col-lg-9 col-md-9 col-10 media-body align-self-center ec-pos">
											<a href="#">
												<h6 class="mb-10px text-dark font-weight-medium">Baby cotton shoes</h6>
											</a>
											<p class="float-md-right sale"><span class="mr-2">58</span>Sales</p>
											<p class="d-none d-md-block">Statement belting with double-turnlock hardware
												adds “swagger” to a simple.</p>
											<p class="mb-0 ec-price">
												<span class="text-dark">$520</span>
												<del>$580</del>
											</p>
										</div>
									</div>
									<div class="row media d-flex pt-15px pb-15px">
										<div
											class="col-lg-3 col-md-3 col-2 media-image align-self-center rounded">
											<a href="#"><img src="assets/img/products/p2.jpg" alt="customer image"></a>
										</div>
										<div class="col-lg-9 col-md-9 col-10 media-body align-self-center ec-pos">
											<a href="#">
												<h6 class="mb-10px text-dark font-weight-medium">Hoodies for men</h6>
											</a>
											<p class="float-md-right sale"><span class="mr-2">20</span>Sales</p>
											<p class="d-none d-md-block">Statement belting with double-turnlock hardware
												adds “swagger” to a simple.</p>
											<p class="mb-0 ec-price">
												<span class="text-dark">$250</span>
												<del>$300</del>
											</p>
										</div>
									</div>
									<div class="row media d-flex pt-15px pb-15px">
										<div
											class="col-lg-3 col-md-3 col-2 media-image align-self-center rounded">
											<a href="#"><img src="assets/img/products/p3.jpg" alt="customer image"></a>
										</div>
										<div class="col-lg-9 col-md-9 col-10 media-body align-self-center ec-pos">
											<a href="#">
												<h6 class="mb-10px text-dark font-weight-medium">Long slive t-shirt</h6>
											</a>
											<p class="float-md-right sale"><span class="mr-2">10</span>Sales</p>
											<p class="d-none d-md-block">Statement belting with double-turnlock hardware
												adds “swagger” to a simple.</p>
											<p class="mb-0 ec-price">
												<span class="text-dark">$480</span>
												<del>$654</del>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> <!-- End Content -->
			</div> <!-- End Content Wrapper -->

<?php 
$has_paid_onboarding = has_paid_onboarding(Auth::user()->id);
$has_done_kyc = has_done_kyc(Auth::user()->id);
$kycLevels = kyc_levels();
?>

{{-- 🔹 If user has NOT paid onboarding, show onboarding modal --}}
@if(!$has_paid_onboarding)
    <button type="button" class="btn btn-warning d-none" id="showOnboardingModal" data-bs-toggle="modal" data-bs-target="#onboardingModal"></button>

   {{-- ✅ Fancy Onboarding Modal (Uncancelable + Two Payment Options) --}}
<div class="modal fade" id="onboardingModal" tabindex="-1" aria-labelledby="onboardingLabel" aria-hidden="true" 
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content border-0 shadow-lg" 
             style="border-radius:25px; overflow:hidden; background:#fff;">

            <!-- Gradient Header -->
            <div class="modal-header border-0 text-center d-block py-4"
                 style="background:linear-gradient(135deg,#ff7e00,#ff5500,#ff9900); background-size:300% 300%; animation:gradientFlow 8s ease infinite;">
                <h3 class="modal-title fw-bold mb-1 text-white">🚀 Complete Your Onboarding</h3>
                <p class="mb-0 text-white" style="opacity:0.85;">Make a one-time payment to unlock full access</p>
            </div>

            <!-- Body -->
            <div class="modal-body d-flex flex-column justify-content-center align-items-center text-center px-5 py-4" 
                 style="background:#fffaf5;">
                
                <!-- Payment Info -->
                <p class="fw-bold mb-3" style="color:#ff5500; font-size:1.3rem;">
                    Pay N500 & N,1000 for both activation fee and KYC  to get your account fully activated
                </p>

                <!-- Features -->
                <ul class="list-unstyled mb-4 text-start" style="max-width:400px; font-size:1rem; color:#444;">
                    <li class="mb-2">✅ Full access to all platform features</li>
                    <li class="mb-2">✅ Eligibility for KYC verification</li>
                    <li class="mb-2">✅ Priority support & exclusive benefits</li>
                </ul>

                <!-- ✅ Two Payment Options -->
                <!-- ✅ Two Payment Options (Always Side by Side) -->
<div class="mt-3 d-flex justify-content-center gap-3 flex-wrap">
    <a href="{{ route('pay.onboarding', ['gateway' => 'paystack']) }}" 
       class="btn btn-lg fw-bold text-white shadow-sm"
       style="background:linear-gradient(135deg,#00b9f1,#007ad9); border:none; border-radius:50px; padding:12px 40px; font-size:1.1rem; min-width:180px;">
         Pay with Paystack
    </a>
    <a href="{{ route('pay.onboarding', ['gateway' => 'fincra']) }}" 
       class="btn btn-lg fw-bold text-white shadow-sm"
       style="background:linear-gradient(135deg,#ff7e00,#ff5500); border:none; border-radius:50px; padding:12px 40px; font-size:1.1rem; min-width:180px;">
        Pay with Fincra
    </a>
</div>

            </div>
        </div>
    </div>
</div>

<!-- 🌈 Gradient Animation -->
<style>
@keyframes gradientFlow {
    0% { background-position:0% 50%; }
    50% { background-position:100% 50%; }
    100% { background-position:0% 50%; }
}
.btn:hover {
    transform: scale(1.05);
}
</style>

    {{-- ✅ Auto-show onboarding modal --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById('showOnboardingModal').click();
        });
    </script>

{{-- 🔹 If user paid onboarding but has NOT done KYC, show KYC modal --}}
@elseif(!$has_done_kyc)
    <!-- Hidden Trigger Button -->
<button type="button" class="btn btn-warning d-none" id="showKycModal" data-bs-toggle="modal" data-bs-target="#kycModal"></button>

{{-- ✅ Fancy KYC Modal (Uncancelable) --}}
<div class="modal fade" id="kycModal" tabindex="-1" aria-hidden="true" 
     data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-md">
        <div class="modal-content border-0 shadow-lg" style="border-radius:25px; overflow:hidden; background:#fff;">

            <!-- Gradient Header -->
            <div class="modal-header border-0 text-center d-block py-4"
                 style="background:linear-gradient(135deg,#ff7e00,#ff5500,#ff9900); background-size:300% 300%; animation:gradientFlow 8s ease infinite;">
                <h3 class="modal-title fw-bold mb-1 text-white"> Choose Account Type</h3>
                <p class="mb-0 text-white" style="opacity:0.85;">Select the verification level you wish to complete</p>
            </div>

            <!-- Body -->
            <div class="modal-body px-4 py-5" style="background:#fffaf5;">

                <p class="fw-bold text-center mb-4" style="color:#ff5500; font-size:1.1rem;">
                    Select an Account level below to see its details and start verification.
                </p>

                <!-- Fancy KYC Level Cards -->
                <div class="d-flex flex-wrap justify-content-center gap-4 mb-4">
                    @foreach($kycLevels as $key => $level)
                        <div class="kyc-level-card shadow-sm" data-level="{{ $key }}" 
                             style="width:200px; padding:15px; border-radius:15px; background:#fff; cursor:pointer; transition:all 0.3s; border:1px solid #eee; text-align:center;">
                            <h5 class="fw-bold mb-2" style="color:#ff5500;">{{ $level['title'] }}</h5>
                            <p class="text-muted small mb-0">Click to view details</p>
                        </div>
                    @endforeach
                </div>

                <hr>

                <!-- KYC Details Section -->
                <div id="kyc-details" style="display:none;">
                    <h4 id="kyc-title" class="fw-bold mb-2" style="color:#ff5500;"></h4>
                    <p id="kyc-desc" class="text-muted mb-4"></p>

                    <form id="kyc-form" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-lg fw-bold text-white shadow-sm"
                                style="background:linear-gradient(135deg,#ff7e00,#ff5500); border:none; border-radius:50px; padding:5px 40px; font-size:1rem; transition:0.3s;">
                             Proceed
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 🌈 Animation + Hover Effects -->
<style>
@keyframes gradientFlow {
    0% { background-position:0% 50%; }
    50% { background-position:100% 50%; }
    100% { background-position:0% 50%; }
}
.kyc-level-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(255, 85, 0, 0.15);
    border-color: #ff7e00;
}
.active-card {
    border: 2px solid #ff7e00 !important;
    box-shadow: 0 6px 20px rgba(255, 85, 0, 0.15) !important;
    transform: translateY(-3px);
}
</style>

    {{-- ✅ Auto-show KYC modal & dynamic behavior --}}
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('showKycModal').click();

    const kycData = @json($kycLevels);
    const title = document.getElementById('kyc-title');
    const desc = document.getElementById('kyc-desc');
    const form = document.getElementById('kyc-form');
    const details = document.getElementById('kyc-details');

    document.querySelectorAll('.kyc-level-card').forEach(card => {
        card.addEventListener('click', () => {
            const data = kycData[card.dataset.level];
            title.textContent = data.title;
            desc.innerHTML = data.description; 
            form.action = data.endpoint || "#";
            details.style.display = 'block';
            document.querySelectorAll('.kyc-level-card').forEach(c => c.classList.remove('active-card'));
            card.classList.add('active-card');
        });
    });
});
</script>

@endif

{{-- ✅ Custom Styles --}}
<style>
    .kyc-level-btn {
        background:linear-gradient(135deg,#ff7e00,#ff5500);
        color:white; font-weight:bold; border:none;
        border-radius:25px; padding:12px 20px; width:45%;
        box-shadow:0 4px 10px rgba(255,85,0,0.3);
        transition:transform .2s, box-shadow .3s;
    }
    .kyc-level-btn:hover {
        transform:scale(1.05);
        box-shadow:0 6px 15px rgba(255,85,0,0.5);
    }
</style>

@endsection
