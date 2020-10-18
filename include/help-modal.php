<button type="button" class="btn btn-info" id="help-btn" data-toggle="modal" data-target="#help-modal">
	<i data-toggle="tooltip" data-placement="left" title="Click for application help" class="fa fa-info-circle"></i>
</button>

<div class="modal fade" id="help-modal" tabindex="-1" role="dialog" aria-labelledby="help-modal-label" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="help-modal-label">Finance Titan Help</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div id="help-accordion" role="tablist">
					<?php
						if(!isset($_SESSION['user_type']) || isset($_SESSION['inactive']) || ($_SESSION['user_type'] != 'admin' && $_SESSION['user_type'] != 'manager' && $_SESSION['user_type'] != 'accountant')) { ?>
							<!-- CARD 1 -->
							<div class="card">
								<div class="card-header" id="heading1" role="tab">
									<h2 class="mb-0">
										<a class="btn btn-link" role="button" data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
											Creating an Account</a>
									</h2>
								</div>
								<div class="collapse show" id="collapse1" aria-labelledby="heading1" role="tabpanel" data-parent="#help-accordion">
									<div class="card-body">
										From the log in page, click the New? user tab at the bottom of the page and create account form. Fill in the necessary information and click create account. A username will automatically be generated using the first initial of the first name, the last name, and the date the account was created (for example, if John Doe created an account in January, 2020, the username would be jdoe0120). Before the created account can be accessed, an admin will need to activate the account.
									</div>
								</div>
							</div>
							<!-- CARD 2 -->
							<div class="card">
								<div class="card-header" id="heading2" role="tab">
									<h2 class="mb-0">
										<a class="btn btn-link" role="button" data-toggle="collapse" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
											Logging In
										</a>
									</h2>
								</div>
								<div class="collapse" id="collapse2" aria-labelledby="heading2" role="tabpanel" data-parent="#help-accordion">
									<div class="card-body">
										Once the desired account has been activated, a user can log in using their credentials on the log in page (which can be accessed in the top right). After logging in, users will be greeted with a welcome page. Navigate to other pages using the tabs at the top of the page.
									</div>
								</div>
							</div>
					<?php } else { ?>
							<!-- CARD 3 -->
							<div class="card">
								<div class="card-header" id="heading3" role="tab">
									<h2 class="mb-0">
										<a class="btn btn-link" role="button" data-toggle="collapse" href="#collapse3" aria-expanded="true" aria-controls="collapse3">
											Accessing Chart of Accounts
										</a>
									</h2>
								</div>
								<div class="collapse show" id="collapse3" aria-labelledby="heading3" role="tabpanel" data-parent="#help-accordion">
									<div class="card-body">
										Information regarding the chart of accounts can be found by clicking "Manage Accounts" under the System Management tab. All types of users can view these accounts, including the names, dates, and users associated with the accounts. Admin users can add new accounts to the chart using the ADD button at the top of the chart. Accounts can also be edited or set to inactive by using the corresponding buttons on the far right of the chart. The current value of the accounts is calculated automatically.
									</div>
								</div>
							</div>
							<!-- CARD 4 -->
							<div class="card">
								<div class="card-header" id="heading4" role="tab">
									<h2 class="mb-0">
										<a class="btn btn-link" role="button" data-toggle="collapse" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
											Event Log
										</a>
									</h2>
								</div>
								<div class="collapse" id="collapse4" aria-labelledby="heading4" role="tabpanel" data-parent="#help-accordion">
									<div class="card-body">
										The Event Log contains a history of the changes made to the records. This includes which users made the changes and what the records looked like before and after they were modified. The Event Log can be accessed under the System Management tab.
									</div>
								</div>
							</div>
							<!-- CARD 5 -->
							<div class="card">
								<div class="card-header" id="heading5" role="tab">
									<h2 class="mb-0">
										<a class="btn btn-link" role="button" data-toggle="collapse" href="#collapse5" aria-expanded="false" aria-controls="collapse5">
											Managing Users
										</a>
									</h2>
								</div>
								<div class="collapse" id="collapse5" aria-labelledby="heading5" role="tabpanel" data-parent="#help-accordion">
									<div class="card-body">
										Admin users can edit the information associated with each user account, as well as change account types. The Manage Users page can be found under the System Management tab. Only Admins have access to this page.
									</div>
								</div>
							</div>
							<!-- CARD 6 -->
							<div class="card">
								<div class="card-header" id="heading6" role="tab">
									<h2 class="mb-0">
										<a class="btn btn-link" role="button" data-toggle="collapse" href="#collapse6" aria-expanded="false" aria-controls="collapse6">
											Password Report
										</a>
									</h2>
								</div>
								<div class="collapse" id="collapse6" aria-labelledby="heading6" role="tabpanel" data-parent="#help-accordion">
									<div class="card-body">
										Passwords will automatically expire over time. Passwords will need to be changed and account may need to be reset after a password expires. Information regarding when user account passwords expire can be accessed by admin users on the Password Report page under the System Management tab
									</div>
								</div>
							</div>
					<!-- CARD 7 -->
							<div class="card">
								<div class="card-header" id="heading7" role="tab">
									<h2 class="mb-0">
										<a class="btn btn-link" role="button" data-toggle="collapse" href="#collapse7" aria-expanded="true" aria-controls="collapse7">
											Journalize</a>
									</h2>
								</div>
								<div class="collapse" id="collapse7" aria-labelledby="heading7" role="tabpanel" data-parent="#help-accordion">
									<div class="card-body">
										On the Journalize page, found under the System Management tab, users can make changes to existing accounts. Changes made by Accountants must be approved by Managers.
									</div>
								</div>
							</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>