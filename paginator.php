
<?php 
	/**
	 * 
	 */
	class Paginator
	{
		public $step = 10;
		public $from;
		public $to;
		public $numberOfPage;
		public $currentPage;
		
		function __construct($allitem, $currentPage)
		{
			$this->currentPage = $currentPage;
			$this->numberOfPage = $allitem / $this->step;
			$this->from = ($currentPage - 1) * $this->step;
			$this->to = $currentPage * $this->step - 1;

			if (intval($this->numberOfPage) < $this->numberOfPage) {
				$this->numberOfPage = intval($this->numberOfPage) + 1;
			}
		}

		function getPaginator()
		{
			
			?>
			<nav aria-label="...">
				<ul class="pagination">
					<li onclick="previous()" class="page-item <?php echo (1 < $this->currentPage)? '' : 'disabled' ?>">
						<a class="page-link" href="#webshop" tabindex="-1" aria-disabled="true" style="color: #5cb85c;">Previous</a>
					</li>

					<?php if($this->numberOfPage < 5): ?>
						<?php for($i = 1; $i <= $this->numberOfPage; $i++): ?>
							<li onclick="getPage(<?php echo $i; ?>)" class="page-item <?php echo ($i == $this->currentPage)? 'active' : '' ?>"><a class="page-link" href="#webshop" style="color: #5cb85c;"><?php echo $i; ?></a></li>
						<?php endfor; ?>
						<?php else: ?>
							<li class="page-item <?php echo (1 == $this->currentPage)? 'active' : '' ?>"><a class="page-link" href="#webshop" style="color: #5cb85c;">1</a></li>
							<?php if($this->currentPage == 1): ?>

									<li onclick="getPage(2)" class="page-item"><a class="page-link" href="#webshop" style="color: #5cb85c;">2</a></li>
									<li onclick="getPage(3)" class="page-item"><a class="page-link" href="#webshop" style="color: #5cb85c;">3</a></li>
									<li onclick="getPage(4)" class="page-item"><a class="page-link" href="#webshop" style="color: #5cb85c;">4</a></li>

								<?php elseif($this->currentPage == 2): ?>
									<li onclick="getPage(2)" class="page-item active"><a class="page-link" href="#webshop" style="color: #5cb85c;">2</a></li>
									<li onclick="getPage(3)" class="page-item"><a class="page-link" href="#webshop" style="color: #5cb85c;">3</a></li>
									<li onclick="getPage(4)" class="page-item"><a class="page-link" href="#webshop" style="color: #5cb85c;">4</a></li>

								<?php elseif($this->currentPage == $this->numberOfPage): ?>
									<li onclick="getPage(<?php echo $this->currentPage - 3; ?>)" class="page-item"><a class="page-link" href="#webshop" style="color: #5cb85c;"><?php echo $this->currentPage - 3; ?></a></li>
									<li onclick="getPage(<?php echo $this->currentPage - 2; ?>)" class="page-item"><a class="page-link" href="#webshop" style="color: #5cb85c;"><?php echo $this->currentPage - 2; ?></a></li>
									<li onclick="getPage(<?php echo $this->currentPage - 1; ?>)" class="page-item"><a class="page-link" href="#webshop" style="color: #5cb85c;"><?php echo $this->currentPage - 1; ?></a></li>

								<?php elseif($this->currentPage == $this->numberOfPage - 1): ?>
									<li onclick="getPage(<?php echo $this->currentPage - 2; ?>)" class="page-item"><a class="page-link" href="#webshop" style="color: #5cb85c;"><?php echo $this->currentPage - 2; ?></a></li>
									<li onclick="getPage(<?php echo $this->currentPage - 1; ?>)" class="page-item"><a class="page-link" href="#webshop" style="color: #5cb85c;"><?php echo $this->currentPage - 1; ?></a></li>
									<li onclick="getPage(<?php echo $this->currentPage; ?>)" class="page-item active"><a class="page-link" href="#webshop" style="color: #5cb85c;"><?php echo $this->currentPage; ?></a></li>
								<?php else: ?>
									<li onclick="getPage(<?php echo $this->currentPage - 1; ?>)" class="page-item <?php echo ($i == $this->currentPage)? 'active' : '' ?>"><a class="page-link" href="#webshop" style="color: #5cb85c;"><?php echo $this->currentPage - 1; ?></a></li>
									<li onclick="getPage(<?php echo $this->currentPage; ?>)" class="page-item <?php echo ($i == $this->currentPage)? 'active' : '' ?>"><a class="page-link" href="#webshop" style="color: #5cb85c;"><?php echo $this->currentPage; ?></a></li>
									<li onclick="getPage(<?php echo $this->currentPage + 1; ?>)" class="page-item <?php echo ($i == $this->currentPage)? 'active' : '' ?>"><a class="page-link" href="#webshop" style="color: #5cb85c;"><?php echo $this->currentPage + 1; ?></a></li>
								<?php endif; ?>

								<li onclick="getPage(<?php echo $this->numberOfPage; ?>)" class="page-item <?php echo ($this->numberOfPage == $this->currentPage)? 'active' : '' ?>"><a class="page-link" href="#webshop" style="color: #5cb85c;"><?php echo $this->numberOfPage; ?></a></li>
							<?php endif; ?>

							<li <?php if((int)$this->currentPage != (int)$this->numberOfPage){echo "onclick='next()'";} ?> class="page-item">
								<a class="page-link"  style="color: #5cb85c;" href="#webshop">Next</a>
							</li>
						</ul>
					</nav>
					<?php
				}
			}
			?>