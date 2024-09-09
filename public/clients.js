$(document).ready(function() {
    $('.edit').on('click', function(){
      var orderid = $(this).attr('orderid');
      $('#editform')[0].reset();  
      $.ajax({
      url: `/clients/${orderid}`,
      type: 'GET',
      success: function(res) {
        $("#client_id").val(res.id);
        $("#phone").val(res.phone);
        $("#address").val(res.address);
        $("#email").val(res.user.email);
        $("#client_name").val(res.user.name);
        $('#editform').attr('action' , "");
        $('#editform').attr('action' ,`/clients/${orderid}/update`);
        $("#editEmployeeModal").modal('show');
      }
       });
     });
     $('.delete').on('click', function(){
      var orderid = $(this).attr('orderid');
      $('#deleteform')[0].reset();  
        $("#order_id_delete").val(orderid);
        $('#deleteform').attr('action' , "");
        $('#deleteform').attr('action' ,`/clients/${orderid}/delete`);
        $("#deleteEmployeeModal").modal('show');
   
     });
     $('.ios').on('click', function(){
      var orderid = $(this).attr('orderid');
      var order_status="";
      console.log($(this).is(':checked'));
      if($(this).is(':checked')){
          order_status="Delivered";
      }else{
          order_status="Pending";
      }
      $.ajax({
      url: `/invoice/update/status/${orderid}`,
      data:{order_status},
      type: 'GET',
      success: function(res) {
          console.log(res);
      }
      });
     });
     let num=1;
     $('.addnew').on('click', function(){
      num++;
     $(".orderitems").append(`<tr>   <td><input type="text"  name="invoice_items[${num}][description]">
      </td>
<td><input type="number"  step="0.01"  name="invoice_items[${num}][price]"></td>
<td><input type="number" name="invoice_items[${num}][quantity]"></td></tr>`)
     });
    
    
$(".view").click(function (e) {
var modal_name=$(this).attr('href')
$(`${modal_name}`).modal('show');
})
$('#client_password').on('keyup', function(){

	var number = /([0-9])/;
	var alphabets = /([a-zA-Z])/;
	var special_characters = /([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/;
	var password = $('#client_password').val().trim();
	if (password.length < 6) {
		$('#password-strength-status').removeClass();
		$('#password-strength-status').addClass('weak-password');
		$('#password-strength-status').html("Weak (should be atleast 6 characters.)");
	} else {
		if (password.match(number) && password.match(alphabets) && password.match(special_characters)) {
			$('#password-strength-status').removeClass();
			$('#password-strength-status').addClass('strong-password');
			$('#password-strength-status').html("Strong");
		}
		else {
			$('#password-strength-status').removeClass();
			$('#password-strength-status').addClass('medium-password');
			$('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.)");
		}
	}
});
  });
  