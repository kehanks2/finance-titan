<button type="button" class="btn btn-info" id="help-btn" data-toggle="modal" data-target="#help-modal">
	<i class="fa fa-info-circle"></i>
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
					<!-- CARD 1 -->
					<div class="card">
						<div class="card-header" id="heading1" role="tab">
							<h2 class="mb-0">
								<a class="btn btn-link" role="button" data-toggle="collapse" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
									Item #1
								</a>
							</h2>
						</div>
						<div class="collapse show" id="collapse1" aria-labelledby="heading1" role="tabpanel" data-parent="#help-accordion">
							<div class="card-body">
								Content for item #1
							</div>
						</div>
					</div>
					<!-- CARD 2 -->
					<div class="card">
						<div class="card-header" id="heading2" role="tab">
							<h2 class="mb-0">
								<a class="btn btn-link" role="button" data-toggle="collapse" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
									Item #2
								</a>
							</h2>
						</div>
						<div class="collapse" id="collapse2" aria-labelledby="heading2" role="tabpanel" data-parent="#help-accordion">
							<div class="card-body">
								Content for item #2
							</div>
						</div>
					</div>
					<!-- CARD 3 -->
					<div class="card">
						<div class="card-header" id="heading3" role="tab">
							<h2 class="mb-0">
								<a class="btn btn-link" role="button" data-toggle="collapse" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
									Item #3
								</a>
							</h2>
						</div>
						<div class="collapse" id="collapse3" aria-labelledby="heading3" role="tabpanel" data-parent="#help-accordion">
							<div class="card-body">
								Content for item #3
							</div>
						</div>
					</div>
					<!-- CARD 4 -->
					<div class="card">
						<div class="card-header" id="heading4" role="tab">
							<h2 class="mb-0">
								<a class="btn btn-link" role="button" data-toggle="collapse" href="#collapse4" aria-expanded="false" aria-controls="collapse4">
									Item #4
								</a>
							</h2>
						</div>
						<div class="collapse" id="collapse4" aria-labelledby="heading4" role="tabpanel" data-parent="#help-accordion">
							<div class="card-body">
								Content for item #4
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>