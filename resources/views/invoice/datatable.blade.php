<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready( function(){
	$('#AllInvoices').DataTable({
		timeout : 100000,
		"ajax": {
			"url": "/invoices",
		},
	columns: [
		{ data: 'invoice_number', name: 'invoice_number' },
		{ data: 'total', name: 'total' },
		{ data: 'actions', name: 'actions' },
	]

});
});

</script>