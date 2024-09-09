$(document).ready(function() {
    $('.edit').on('click', function(){
      var orderid = $(this).attr('orderid');
      $('#editform')[0].reset();  
      $.ajax({
      url: `/invoices/${orderid}`,
      type: 'GET',
      success: function(res) {
        $("#order_id").val(res.id);
        $("#due_date").val(res.due_date);
        $('#editform').attr('action' , "");
        $('#editform').attr('action' ,`/invoice/${orderid}/update`);
        let num=0;
        $.each(res.invoice_items, function (i ,data) {
          console.log(data);
          num++;
          $(".orderitems").append(`<tr><td><input type="hidden" name="invoice_items[${num}][id]" value="${data.id}" >
            <input type="text" value="${data.description}" name="invoice_items[${num}][description]"></td>
            <td><input type="number" value="${data.price}"  step="0.01"  name="invoice_items[${num}][price]"></td>
            <td><input type="number" value="${data.quantity}" name="invoice_items[${num}][quantity]"></td></tr>`)
      });
        $("#editEmployeeModal").modal('show');
      }
       });
     });
     $('.delete').on('click', function(){
      var orderid = $(this).attr('orderid');
      $('#deleteform')[0].reset();  
        $("#order_id_delete").val(orderid);
        $('#deleteform').attr('action' , "");
        $('#deleteform').attr('action' ,`/invoice/${orderid}/delete`);
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

  });
  