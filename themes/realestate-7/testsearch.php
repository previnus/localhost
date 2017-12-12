<div class="widget artwork-seachform search" rol="search">

    <h3 class="widget-title"&gt;Search Listings&lt;/h3>

	<form role="search" action="<php echo site_url('/'); ?>" method="get">

		<input type="search" name="s" placeholder="Search: Enter artwork keywords hit enter"/>

		<input type="hidden" name="post_type" value="listings" /> <!-- // hidden 'your_custom_post_type' value -->

		<input type="submit" alt="Search" value="Search" />

	</form>

</div>