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
		
		function __construct($allitem)
		{
			$this->numberOfPage = $allitem / $this->step;

			if (intval($this->numberOfPage) < $this->numberOfPage) {
				$this->numberOfPage = intval($this->numberOfPage) + 1;
			}
		}

		function getPaginator($currentPage)
		{
			$this->from = ($currentPage - 1) * $this->step;
			$this->to = $currentPage * $this->step - 1;

			?>
			<nav aria-label="...">
				<ul class="pagination">
					<li class="page-item disabled">
						<a class="page-link" href="#" tabindex="-1" aria-disabled="true" style="color: #5cb85c;">Previous</a>
					</li>
					<?php for($i = 1; $i <= $this->numberOfPage; $i++): ?>
						<li class="page-item"><a class="page-link" href="#" style="color: #5cb85c;"><?php echo $i; ?></a></li>
					<?php endfor; ?>
					<li class="page-item">
						<a class="page-link" href="#" style="color: #5cb85c;">Next</a>
					</li>
				</ul>
			</nav>
			<?php
		}
	}

	$pg = new Paginator(1000);
 	
	echo $pg->from."<br>";
	echo $pg->to."<br>";
	echo $pg->numberOfPage."<br>";

	echo $pg->getPaginator(1);

	?>